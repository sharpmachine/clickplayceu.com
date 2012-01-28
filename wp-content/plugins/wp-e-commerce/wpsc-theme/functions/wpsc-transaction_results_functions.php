<?php

/**
 * WP eCommerce transaction results class
 *
 * This class is responsible for theming the transaction results page.
 *
 * @package wp-e-commerce
 * @since 3.8
 */
function wpsc_transaction_theme() {
	global $wpdb, $user_ID, $nzshpcrt_gateways, $sessionid, $cart_log_id, $errorcode;
	$errorcode = '';
	$transactid = '';
	$dont_show_transaction_results = false;
	if ( isset( $_GET['sessionid'] ) )
		$sessionid = $_GET['sessionid'];

	if ( !isset( $_GET['sessionid'] ) && isset( $_GET['ms'] ) )
		$sessionid = $_GET['ms'];

	if ( isset( $_GET['gateway'] ) && 'google' == $_GET['gateway'] ) {
		wpsc_google_checkout_submit();
		unset( $_SESSION['wpsc_sessionid'] );
	}

	if ( isset( $_SESSION['wpsc_previous_selected_gateway'] ) && in_array( $_SESSION['wpsc_previous_selected_gateway'], array( 'paypal_certified', 'wpsc_merchant_paypal_express' ) ) )
		$sessionid = $_SESSION['paypalexpresssessionid'];

	if ( isset( $_REQUEST['eway'] ) && '1' == $_REQUEST['eway'] )
		$sessionid = $_GET['result'];
	elseif ( isset( $_REQUEST['eway'] ) && '0' == $_REQUEST['eway'] )
		echo $_SESSION['eway_message'];
	elseif ( isset( $_REQUEST['payflow'] ) && '1' == $_REQUEST['payflow'] ){
		echo $_SESSION['payflow_message'];
		$_SESSION['payflow_message'] = '';
	}
	
	$dont_show_transaction_results = false;
	
	if ( isset( $_SESSION['wpsc_previous_selected_gateway'] ) ) {
		// Replaces the ugly if else for gateways
		switch($_SESSION['wpsc_previous_selected_gateway']){
			case 'paypal_certified':
			case 'wpsc_merchant_paypal_express':
				echo $_SESSION['paypalExpressMessage'];

				if(isset($_SESSION['reshash']['PAYMENTINFO_0_TRANSACTIONTYPE']) && 'expresscheckout' == $_SESSION['reshash']['PAYMENTINFO_0_TRANSACTIONTYPE'])
					$dont_show_transaction_results = false;
				else
					$dont_show_transaction_results = true;		
			break;
			case 'dps':
				$sessionid = decrypt_dps_response();
			break;
			//paystation was not updating the purchase logs for successful payment - this is ugly as need to have the databse update done in one place by all gatways on a sucsessful transaction hook not some within the gateway and some within here and some not at all??? This is getting a major overhaul but for here and now it just needs to work for the gold cart people!
			case 'paystation':
				$ec = $_GET['ec'];
				$result= $_GET['em'];
				
				if($result == 'Transaction successful' && $ec == 0)
						$processed_id = '3';					
				
				if($result == 'Insufficient Funds' && $ec == 5){
						$processed_id = '6';
				
				$payment_instructions = printf( __( 'Sorry your transaction was not accepted due to insufficient funds <br /><a href="%1$s">Click here to go back to checkout page</a>.', 'wpsc' ), get_option( "shopping_cart_url" ) );
				}
				if($processed_id){
					$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array('processed' => $processed_id),array('sessionid'=>$sessionid), array('%f') );
				}		
			break;
		}
	}
	
	if(!$dont_show_transaction_results ) {
		if ( !empty($sessionid) ){
			$cart_log_id = $wpdb->get_var( "SELECT `id` FROM `" . WPSC_TABLE_PURCHASE_LOGS . "` WHERE `sessionid`= " . $sessionid . " LIMIT 1" );
			return transaction_results( $sessionid, true );
		}else
		printf( __( 'Sorry your transaction was not accepted.<br /><a href="%1$s">Click here to go back to checkout page</a>.', 'wpsc' ), get_option( "shopping_cart_url" ) );
	}
	
}


/**
 * transaction_results function main function for creating the purchase reports, transaction results page, and email receipts
 * @access public
 *
 * @since 3.7
 * @param $sessionid (string) unique session id
 * @param echo_to_screen (boolean) whether to output the results or return them (potentially redundant)
 * @param $transaction_id (int) the transaction id
 */
function transaction_results( $sessionid, $display_to_screen = true, $transaction_id = null ) {
	// Do we seriously need this many globals?
	global $wpdb, $wpsc_cart, $echo_to_screen, $purchase_log, $order_url; 
	global $message_html, $cart, $errorcode,$wpsc_purchlog_statuses, $wpsc_gateways;
	
	$wpec_taxes_controller = new wpec_taxes_controller();
	$is_transaction = false;
	$errorcode = 0;
	$purchase_log = $wpdb->get_row( "SELECT * FROM `" . WPSC_TABLE_PURCHASE_LOGS . "` WHERE `sessionid`= " . $sessionid . " LIMIT 1", ARRAY_A );
	$order_status = $purchase_log['processed'];
	$curgateway = $purchase_log['gateway'];
	//new variable to check whether function is being called from resen_email
	if(isset($_GET['email_buyer_id']))
		$resend_email = true;
	else
		$resend_email = false;
		
	if( !is_bool( $display_to_screen )  )
		$display_to_screen = true;
		
	$echo_to_screen = $display_to_screen;

	if ( is_numeric( $sessionid ) ) {
		if ( $echo_to_screen )
			echo apply_filters( 'wpsc_pre_transaction_results', '' );
		
		// New code to check whether transaction is processed, true if accepted false if pending or incomplete
		$is_transaction = wpsc_check_purchase_processed($purchase_log['processed']);
		$message_html = $message = stripslashes( get_option( 'wpsc_email_receipt' ) );
	
		if( $is_transaction ){
			$message = __('The Transaction was successful', 'wpsc')."\r\n".$message;
			$message_html = __('The Transaction was successful', 'wpsc')."<br />".$message_html;
		}
		$country = get_option( 'country_form_field' );
		$billing_country = '';
		$shipping_country = '';
		if ( !empty($purchase_log['shipping_country']) ) {
			$billing_country = $purchase_log['billing_country'];
			$shipping_country = $purchase_log['shipping_country'];
		} elseif (  !empty($country) ) {
			$country = $wpdb->get_var( "SELECT `value` FROM `" . WPSC_TABLE_SUBMITED_FORM_DATA . "` WHERE `log_id`=" . $purchase_log['id'] . " AND `form_id` = '" . get_option( 'country_form_field' ) . "' LIMIT 1" );
						
			$billing_country = $country;
			$shipping_country = $country;
		}

		$email = wpsc_get_buyers_email($purchase_log['id']);
		$previous_download_ids = array( );
		$product_list = $product_list_html = $report_product_list = '';
	
		$cart = $wpdb->get_results( "SELECT * FROM `" . WPSC_TABLE_CART_CONTENTS . "` WHERE `purchaseid` = '{$purchase_log['id']}'" , ARRAY_A );
		if ( ($cart != null) && ($errorcode == 0) ) {
			$total_shipping = '';
			foreach ( $cart as $row ) {
				$link = array( );
				$wpdb->update(WPSC_TABLE_DOWNLOAD_STATUS, array('active' => '1'), array('cartid' => $row['id'], 'purchid'=>$purchase_log['id']) );
				do_action( 'wpsc_transaction_result_cart_item', array( "purchase_id" => $purchase_log['id'], "cart_item" => $row, "purchase_log" => $purchase_log ) );

				if ( $is_transaction ) {

					$download_data = $wpdb->get_results( "SELECT *
					FROM `" . WPSC_TABLE_DOWNLOAD_STATUS . "`
					WHERE `active`='1'
					AND `purchid`='" . $purchase_log['id'] . "'
					AND `cartid` = '" . $row['id'] . "'", ARRAY_A );

					if ( count( $download_data ) > 0 ) {
						foreach ( $download_data as $single_download ) {
							$file_data = get_post( $single_download['product_id'] );
							// if the uniqueid is not equal to null, its "valid", regardless of what it is
							if ( $single_download['uniqueid'] == null )
								$link[] = array( "url" => site_url( "?downloadid=" . $single_download['id'] ), "name" => $file_data->post_title );
							else
								$link[] = array( "url" => site_url( "?downloadid=" . $single_download['uniqueid'] ), "name" => $file_data->post_title );
							
						}
					} else {
						$order_status = $purchase_log['processed'];
					}
					if( isset( $download_data['id'] ) )
						$previous_download_ids[] = $download_data['id'];
						
					if ($row['prodid'] == 55) {
						//generate coupons
						//$row['quantity'];
						//date( 'Y-m-d', strtotime("now") . " 00:00:00");
						//date( 'Y-m-d', strtotime("+1 year") . " 00:00:00");
						//date('Y-m-d H:i:s', time());
						$length = 10;
						$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
						for ($p = 0; $p < $length; $p++) {
							$couponcode .= $characters[mt_rand(0, strlen($characters))];
						}
						$condition = "a:1:{i:0;a:3:{s:8:\"property\";s:9:\"item_name\";s:5:\"logic\";s:11:\"not_contain\";s:5:\"value\";s:11:\"CEU Credits\";}}";
						$wpdb->insert(WPSC_TABLE_COUPON_CODES, array('coupon_code' => $couponcode, 'value' => 100.00, 'is-percentage' => 1, 'uses_remaining' => $row['quantity'], 'active' => '1', 'every_product' => 1, 'start' => date( 'Y-m-d', strtotime("now") . " 00:00:00"), 'expiry' => date( 'Y-m-d', strtotime("+1 year") . " 00:00:00"), 'condition' => $condition));
						$wpdb->update(WPSC_TABLE_CART_CONTENTS, array('custom_message' => $couponcode), array('purchaseid' => $purchase_log['id'], 'id' => $row['id']));
					}
					
					//generate certificate of completion
					//get meta info like credits
					/*if ((get_post_meta($row['prodid'], 'Credits') > 0) && ((empty($row['custom_message'])))) {
					   //	global $wpdb, $user_ID;
					    $img_file = WP_CONTENT_DIR . "/uploads/certificates/Certificate-20110821.jpg";
					   	//$current_user = wp_get_current_user();
					   	$lastname = get_user_meta($purchase_log['user_ID'],'last_name', True);
					   	$firstname = get_user_meta($purchase_log['user_ID'],'first_name', True); 
					   	
					   	$RCFE = '';
					   	$GH = '';
					   	$ARF = '';
					   	$date = '';
					   	$rnlicense = '';
					   	$credits = '';
					   	$name = '';
					   	$title = '';
					   	$filename = '';
					   	
						$credits = get_post_meta($row['prodid'], 'Credits', true);
						$ARF = get_post_meta($row['prodid'], 'ARF', true);
						$RCFE = get_post_meta($row['prodid'], 'RCFE', true);
						$GH = get_post_meta($row['prodid'], 'GH', true);
						$course = get_post($row['prodid']);
						$name = $firstname . ' ' . $lastname;
						$title = $course->post_title;
						
						$meta_data = '';
						$meta_data = get_user_meta($purchase_log['user_ID'], 'wpshpcrt_usr_profile',1);
						$rnlicense = isset( $meta_data[31] ) ? 'Professional License#: ' . $meta_data[31] : '';
						$date = date("F j, Y");
						$filename = genRandomString() . ".pdf";
						
						$boards = '';
						$boards = "<b>Adult Residential Facility</b> (ARF) Vendor No. 2000149-735-2 Course Approval No. " . $ARF;
						$boards .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Residential Facility for the Elderly</b> (RCFE) Vendor No. 2000149-740-2 Course Approval No. " . $RCFE . "<br />";
						$boards .= "<b>Group Home</b> (GH) Vendor No. 2000149-730-2 Course Approval No. " . $GH;
						
						require_once(WP_CONTENT_DIR."/plugins/tcpdf/config/lang/eng.php");
						require_once(WP_CONTENT_DIR."/plugins/tcpdf/tcpdf.php");
					
						// create new PDF document
						$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						
						// set document information
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->SetAuthor('CogentCEU.com');
						$pdf->SetTitle('Certificate of Completion for ' .$title);
						$pdf->SetSubject($title);
						$pdf->SetKeywords('CogentCEU.com, '. $title);
					
						$bMargin = $pdf->getBreakMargin();
						$auto_page_break = $pdf->getAutoPageBreak();
						
						$pdf->setPageMark();
						// set header and footer fonts
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
						
						// set default monospaced font
						$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
						
						//set margins
						$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
						
						// remove default footer
						$pdf->setPrintFooter(false);
						$pdf->setPrintHeader(false);
						
						//set auto page breaks
						$pdf->SetAutoPageBreak(false, 0);
						
						//set image scale factor
						$pdf->setImageScale();
						
						//set some language-dependent strings
						$pdf->setLanguageArray($l);
					
						// set font
						$pdf->SetFont('times', '', 48);
						
						// add a page
						$pdf->AddPage('L', 'A4');
						$pdf->Image($img_file, 0, 0, 300, 210, '', '', '', false, 300, '', false, false, 0);
						
						$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
						
						$pdf->setCellPaddings(1,1,1,1);
						$pdf->setCellMargins(1,1,1,1);
						$pdf->setFillColor(255,255,255);
						
						$pdf->SetFont('times', '', 24);
						$pdf->MultiCell(0,0, $name, 0,'C',0,0,'',56,true);
						$pdf->SetFont('times', '', 16);
						$pdf->MultiCell(0,0, $title, 0,'C',0,0,'',86,true);
						
						$pdf->SetFont('times', '', 6);						
						$pdf->writeHTMLCell(0,0,0,166.8, $boards, 0, 0, 0, true, 'C', true);
						
						$pdf->SetFont('times', '', 17);
						$pdf->MultiCell(0,0, $credits, 0,'C',0,0,-57,93.5,true);
						
						$pdf->SetFont('times', '', 12);
						$pdf->MultiCell(0,0, $rnlicense, 0,'C',0,0,-92,68,true);
						$pdf->MultiCell(0,0, $date, 0,'C',0,0,-120,110,true);
						
						//Close and output PDF document
						$pdf->Output(WP_CONTENT_DIR . "/uploads/certificates/generated/". $filename, 'F');
						$wpdb->query($wpdb->prepare("UPDATE `".WPSC_TABLE_CART_CONTENTS."` set `custom_message` = '". $filename ."' where `id` = '".$row['id']."'"));

					}*/
				}

				do_action( 'wpsc_confirm_checkout', $purchase_log['id'] );

				$total = 0;
				$shipping = $row['pnp'] * $row['quantity'];
				$total_shipping += $shipping;

				$total += ( $row['price'] * $row['quantity']);
				$message_price = wpsc_currency_display( $total, array( 'display_as_html' => false ) );
				$message_price_html = wpsc_currency_display( $total );
				$shipping_price = wpsc_currency_display( $shipping, array( 'display_as_html' => false ) );

				if ( isset( $purchase['gateway'] ) && 'wpsc_merchant_testmode' != $purchase['gateway'] ) {
					if ( $gateway['internalname'] == $purch_data[0]['gateway'] )
						$gateway_name = $gateway['name'];
				} else {
					$gateway_name = "Manual Payment";
				}

				$variation_list = '';

				if ( !empty( $link ) ) {
					$additional_content = apply_filters( 'wpsc_transaction_result_content', array( "purchase_id" => $purchase_log['id'], "cart_item" => $row, "purchase_log" => $purchase_log ) );
					if ( !is_string( $additional_content ) ) {
						$additional_content = '';
					}
					$product_list .= " - " . $row['name'] . "  " . $message_price . " " . __( 'Click to download', 'wpsc' ) . ":";
					$product_list_html .= " - " . $row['name'] . "  " . $message_price_html . "&nbsp;&nbsp;" . __( 'Click to download', 'wpsc' ) . ":\n\r";
					foreach ( $link as $single_link ) {
						$product_list .= "\n\r " . $single_link["name"] . ": " . $single_link["url"] . "\n\r";
						$product_list_html .= "<a href='" . $single_link["url"] . "'>" . $single_link["name"] . "</a>\n";
					}
					$product_list .= $additional_content;
					$product_list_html .= $additional_content;
				} else {
				
					$product_list.= " - " . $row['quantity'] . " " . $row['name'] . "  " . $message_price . "\n\r";
					//add coupon code to email
					if ($row['name'] == 'CEU Credits') {
						$product_list .= "Your coupon code is: " . $couponcode . " and is good for " . $row['quantity']. " credits.\n\r";
						$product_list_html .= "Your coupon code is: " . $couponcode . " and is good for " . $row['quantity']. " credits.\n";
					}
					//certificate link
					if ((empty($row['custom_message'])) || (get_post_meta($row['prodid'], 'Credits') > 0)) {	
						$img_file = WP_CONTENT_DIR . "/uploads/certificates/Certificate-20111203.png";
					   	//$current_user = wp_get_current_user();
						
						$meta_data = '';
						$user_id = $purchase_log['user_ID'];
						$meta_data = get_user_meta($user_id, 'wpshpcrt_usr_profile', true);
					   	$RCFE = '';
					   	$GH = '';
					   	$ARF = '';
					   	$date = '';
					   	$rnlicense = '';
					   	$credits = '';
					   	$name = '';
					   	$title = '';
					   	$filename = '';
					   	
						$lastname = $meta_data[3];
						$firstname = $meta_data[2];
						$rnlicense = isset( $meta_data[31] ) && $meta_data[31] ? 'Professional License#: ' . $meta_data[31] : '';
					   	
						$credits = get_post_meta($row['prodid'], 'Credits', true);
						$ARF = get_post_meta($row['prodid'], 'ARF', true);
						$RCFE = get_post_meta($row['prodid'], 'RCFE', true);
						$GH = get_post_meta($row['prodid'], 'GH', true);
						$course = get_post($row['prodid']);
						$name = (isset($meta_data[2]) ? $meta_data[2] : get_user_meta($user_id, 'first_name', true)) . ' ' . (isset($meta_data[3]) ? $meta_data[3] : get_user_meta($user_id, 'last_name', true));
						$title = $course->post_title;
						
						$date = date("F j, Y");
						$filename = genRandomString() . ".pdf";
						
						$boards = '';
						$boards = "<b>Adult Residential Facility</b> (ARF) Vendor No. 2000149-735-2 Course Approval No. " . $ARF;
						$boards .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Residential Facility for the Elderly</b> (RCFE) Vendor No. 2000149-740-2 Course Approval No. " . $RCFE . "<br />";
						$boards .= "<b>Group Home</b> (GH) Vendor No. 2000149-730-2 Course Approval No. " . $GH;
						
						require_once(WP_CONTENT_DIR."/plugins/tcpdf/config/lang/eng.php");
						require_once(WP_CONTENT_DIR."/plugins/tcpdf/tcpdf.php");
					
						// create new PDF document
						$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						
						// set document information
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->SetAuthor('CogentCEU.com');
						$pdf->SetTitle('Certificate of Completion for ' .$title);
						$pdf->SetSubject($title);
						$pdf->SetKeywords('ClickCEU.com, '. $title);
					
						$bMargin = $pdf->getBreakMargin();
						$auto_page_break = $pdf->getAutoPageBreak();
						
						$pdf->setPageMark();
						// set header and footer fonts
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
						
						// set default monospaced font
						$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
						
						//set margins
						$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
						
						// remove default footer
						$pdf->setPrintFooter(false);
						$pdf->setPrintHeader(false);
						
						//set auto page breaks
						$pdf->SetAutoPageBreak(false, 0);
						
						//set image scale factor
						$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
						
						//set some language-dependent strings
						$pdf->setLanguageArray($l);
					
						// set font
						$pdf->SetFont('times', '', 48);
						
						// add a page
						$pdf->AddPage('L', 'A4');
						$pdf->Image($img_file, 0, 0, 300, 210, '', '', '', false, 300, '', false, false, 0);
						
						$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
						
						$pdf->setCellPaddings(1,1,1,1);
						$pdf->setCellMargins(1,1,1,1);
						$pdf->setFillColor(255,255,255);
						
						$pdf->SetFont('times', '', 24);
						$pdf->MultiCell(0, 0, $name, 0, 'C', 0, 0, '', 56, true);
						$pdf->SetFont('times', '', 16);
						$pdf->MultiCell(0,0, $title, 0,'C',0,0,'',86,true);
						
						$pdf->SetFont('times', '', 6);						
						$pdf->writeHTMLCell(0,0,0,166.8, $boards, 0, 0, 0, true, 'C', true);
						
						$pdf->SetFont('times', '', 17);
						$pdf->MultiCell(0,0, $credits, 0,'C',0,0,-57,93.5,true);
						
						$pdf->SetFont('times', '', 12);
						$pdf->MultiCell(0,0, $rnlicense, 0,'C',0,0,-110,68,true);
						$pdf->MultiCell(0,0, $date, 0,'C',0,0,-120,110,true);
						
						//Close and output PDF document
						$pdf->Output(WP_CONTENT_DIR . "/uploads/certificates/generated/". $filename, 'F');
						$wpdb->query($wpdb->prepare("UPDATE `".WPSC_TABLE_CART_CONTENTS."` set `custom_message` = '". $filename ."' where `id` = '".$row['id']."'"));
						
						
						$upload_dir = wp_upload_dir();
						
						$product_list .= "Download your certificate here: ". $upload_dir['baseurl'] . "/certificates/generated/". $filename ."\n\r";
						$product_list_html .= "<a href='". $upload_dir['baseurl'] . "/certificates/generated/". $filename ."' target='_blank'>Print certificate</a>\n";
						
					}
					if ( $shipping > 0 )
						$product_list .= sprintf(__( ' - Shipping: %s', 'wpsc' ), $shipping_price);
					$product_list_html.= "\n\r - " . $row['quantity'] . " " . $row['name'] . "  " . $message_price_html . "\n\r";
					if ( $shipping > 0 )
						$product_list_html .=  sprintf(__( ' &nbsp; Shipping: %s', 'wpsc' ), $shipping_price);
				}

				//add tax if included
				if($wpec_taxes_controller->wpec_taxes_isenabled() && $wpec_taxes_controller->wpec_taxes_isincluded())
				{
					$taxes_text = ' - - '.__('Tax Included', 'wpsc').': '.wpsc_currency_display( $row['tax_charged'], array( 'display_as_html' => false ) )."\n\r";
					$taxes_text_html = ' - - '.__('Tax Included', 'wpsc').': '.wpsc_currency_display( $row['tax_charged'] );
					$product_list .= $taxes_text;
					$product_list_html .= $taxes_text_html;
				}// if

				$report = get_option( 'wpsc_email_admin' );
				$report_product_list.= " - " . $row['quantity'] . " " . $row['name'] . "  " . $message_price . "\n\r";
			} // closes foreach cart as row

			// Decrement the stock here
			if ( $is_transaction )
				wpsc_decrement_claimed_stock( $purchase_log['id'] );

			if ( !empty($purchase_log['discount_data'])) {
				$coupon_data = $wpdb->get_row( "SELECT * FROM `" . WPSC_TABLE_COUPON_CODES . "` WHERE coupon_code='" . $wpdb->escape( $purchase_log['discount_data'] ) . "' LIMIT 1", ARRAY_A );
				if ( $coupon_data['use-once'] == 1 ) {
					$wpdb->update(WPSC_TABLE_COUPON_CODES, array('active' => '0', 'is-used' => '1', 'uses_remaining' => 0), array('id' => $coupon_data['id']) );
				} 
				
				if ($is_transaction) {
					//decrement coupon uses by number of credits
					//need to get credits for all items in cart
					$credits = wpsc_get_credit_count($purchase_log['id']);
					if ($coupon_data['uses_remaining'] > $credits) {
						$credits = $coupon_data['uses_remaining'] - $credits;
						$wpdb->update(WPSC_TABLE_COUPON_CODES, array('uses_remaining' => $credits), array('id' => $coupon_data['id']) );	
					} else {
						$wpdb->update(WPSC_TABLE_COUPON_CODES, array('active' => '0', 'is-used' => '1', 'uses_remaining' => 0), array('id' => $coupon_data['id']) );
					}	
				}
			}

			$total_shipping += $purchase_log['base_shipping'];

			$total = $purchase_log['totalprice'];
			
			$total_price_email = '';
			$total_price_html = '';
			$total_tax_html = '';
			$total_tax = '';
			$total_shipping_html = '';
			$total_shipping_email = '';
			if ( wpsc_uses_shipping() )
				$total_shipping_email.= sprintf(__( 'Total Shipping: %s', 'wpsc' ), wpsc_currency_display( $total_shipping, array( 'display_as_html' => false ) ) );
			$total_price_email.= sprintf(__( 'Total: %s', 'wpsc' ), wpsc_currency_display( $total, array( 'display_as_html' => false ) ));
			if ( $purchase_log['discount_value'] > 0 ) {
				$discount_email.= __( 'Discount', 'wpsc' ) . "\n\r: ";
				$discount_email .=$purchase_log['discount_data'] . ' : ' . wpsc_currency_display( $purchase_log['discount_value'], array( 'display_as_html' => false ) ) . "\n\r"; 
				
				$report.= $discount_email . "\n\r";
				$total_shipping_email .= $discount_email;
				$total_shipping_html.= __( 'Discount', 'wpsc' ) . ": " . wpsc_currency_display( $purchase_log['discount_value'] ) . "\n\r";
			}

			//only show total tax if tax is not included
			if($wpec_taxes_controller->wpec_taxes_isenabled() && !$wpec_taxes_controller->wpec_taxes_isincluded()){
				$total_tax_html .= __('Total Tax', 'wpsc').': '. wpsc_currency_display( $purchase_log['wpec_taxes_total'] )."\n\r";
				$total_tax .= __('Total Tax', 'wpsc').': '. wpsc_currency_display( $purchase_log['wpec_taxes_total'] , array( 'display_as_html' => false ) )."\n\r"; 		
			}
			if ( wpsc_uses_shipping() )
				$total_shipping_html.= sprintf(__( '<hr>Total Shipping: %s', 'wpsc' ), wpsc_currency_display( $total_shipping ));
			$total_price_html.= sprintf(__( 'Total: %s', 'wpsc' ), wpsc_currency_display( $total ) );
			$report_id = sprintf(__("Purchase # %s", 'wpsc'), $purchase_log['id']);
			
			if ( isset( $_GET['ti'] ) ) {
				$message.= "\n\r" . __( 'Your Transaction ID', 'wpsc' ) . ": " . $_GET['ti'];
				$message_html.= "\n\r" . __( 'Your Transaction ID', 'wpsc' ) . ": " . $_GET['ti'];
				$report.= "\n\r" . __( 'Transaction ID', 'wpsc' ) . ": " . $_GET['ti'];
			} 
			$message = str_replace( '%purchase_id%', $report_id, $message );
			$message = str_replace( '%product_list%', $product_list, $message );
			$message = str_replace( '%total_tax%', $total_tax, $message );
			$message = str_replace( '%total_shipping%', $total_shipping_email, $message );
			$message = str_replace( '%total_price%', $total_price_email, $message );
			$message = str_replace( '%shop_name%', get_option( 'blogname' ), $message );
			$message = str_replace( '%find_us%', $purchase_log['find_us'], $message );

			$report = str_replace( '%purchase_id%', $report_id, $report );
			$report = str_replace( '%product_list%', $report_product_list, $report );
			$report = str_replace( '%total_tax%', $total_tax, $report );
			$report = str_replace( '%total_shipping%', $total_shipping_email, $report );
			$report = str_replace( '%total_price%', $total_price_email, $report );
			$report = str_replace( '%shop_name%', get_option( 'blogname' ), $report );
			$report = str_replace( '%find_us%', $purchase_log['find_us'], $report );

			$message_html = str_replace( '%purchase_id%', $report_id, $message_html );
			$message_html = str_replace( '%product_list%', $product_list_html, $message_html );
			$message_html = str_replace( '%total_tax%', $total_tax_html, $message_html );
			$message_html = str_replace( '%total_shipping%', $total_shipping_html, $message_html );
			$message_html = str_replace( '%total_price%', $total_price_html, $message_html );
			$message_html = str_replace( '%shop_name%', get_option( 'blogname' ), $message_html );
			$message_html = str_replace( '%find_us%', $purchase_log['find_us'], $message_html );

			if ( !empty($email) ) {
				add_filter( 'wp_mail_from', 'wpsc_replace_reply_address', 0 );
				add_filter( 'wp_mail_from_name', 'wpsc_replace_reply_name', 0 );
				$message = apply_filters('wpsc_email_message', $message, $report_id, $product_list, $total_tax, $total_shipping_email, $total_price_email);
				
				//delete_transient("{$sessionid}_pending_email_sent");
				//delete_transient( "{$sessionid}_receipt_email_sent" );
				
				if ( !$is_transaction ) {
	
					$payment_instructions = strip_tags( stripslashes( get_option( 'payment_instructions' ) ) );
					if(!empty($payment_instructions))
						$payment_instructions .= "\n\r";					
					$message = __( 'Thank you, your purchase is pending, you will be sent an email once the order clears.', 'wpsc' ) . "\n\r" . $payment_instructions . $message;
					$message_html = __( 'Thank you, your purchase is pending, you will be sent an email once the order clears.', 'wpsc' ) . "\n\r" . $payment_instructions . $message_html;
					
					// prevent email duplicates
					if ( ! get_transient( "{$sessionid}_pending_email_sent" ) ) {
						wp_mail( $email, __( 'Order Pending: Payment Required', 'wpsc' ), $message );
						set_transient( "{$sessionid}_pending_email_sent", true, 10); //60 * 60 * 12
					}
				} elseif ( ! get_transient( "{$sessionid}_receipt_email_sent" ) ) {
					wp_mail( $email, __( 'Purchase Receipt', 'wpsc' ), $message );
					set_transient( "{$sessionid}_receipt_email_sent", true, 10); //60 * 60 * 12
				}
			}

			remove_filter( 'wp_mail_from_name', 'wpsc_replace_reply_name' );
			remove_filter( 'wp_mail_from', 'wpsc_replace_reply_address' );

			$report_user = __( 'Customer Details', 'wpsc' ) . "\n\r";
			$form_sql = "SELECT * FROM `" . WPSC_TABLE_SUBMITED_FORM_DATA . "` WHERE `log_id` = '" . $purchase_log['id'] . "'";
			$form_data = $wpdb->get_results( $form_sql, ARRAY_A );
			
			if ( $form_data != null ) {
				foreach ( $form_data as $form_field ) {
					$form_data = $wpdb->get_row( "SELECT * FROM `" . WPSC_TABLE_CHECKOUT_FORMS . "` WHERE `id` = '" . $form_field['form_id'] . "' LIMIT 1", ARRAY_A );
		
					switch ( $form_data['type'] ) {
						case "country":
							$country_code = $form_field['value'];
							$report_user .= $form_data['name'] . ": " . wpsc_get_country( $country_code ) . "\n";
							//check if country has a state then display if it does.
							$country_data = wpsc_country_has_state($country_code);
							if(($country_data['has_regions'] == 1))
								$report_user .= __( 'Billing State', 'wpsc' ) . ": " . wpsc_get_region( $purchase_log['billing_region'] ) . "\n";
							break;

						case "delivery_country":
							$report_user .= $form_data['name'] . ": " . wpsc_get_country( $form_field['value'] ) . "\n";			
							break;
					
						default:
							if ($form_data['name'] == 'State' && is_numeric($form_field['value'])){
								$report_user .= __( 'Delivery State', 'wpsc' ) . ": " . wpsc_get_state_by_id( $form_field['value'], 'name' ) . "\n";
							}else{
							$report_user .= wp_kses( $form_data['name'], array( ) ) . ": " . $form_field['value'] . "\n";
							}
							break;
					}
				}
			}

			$report_user .= "\n\r";
			$report = $report_id . $report_user . $report;

			//echo '======REPORT======<br />'.$report.'<br />';
			//echo '======EMAIL======<br />'.$message.'<br />';
			if ( (get_option( 'purch_log_email' ) != null) && ( $purchase_log['email_sent'] != 1 ) ){
				wp_mail( get_option( 'purch_log_email' ), __( 'Purchase Report', 'wpsc' ), $report );
				$wpdb->update(WPSC_TABLE_PURCHASE_LOGS, array('email_sent' => '1'), array( 'sessionid' => $sessionid ) );
			}

			/// Adjust stock and empty the cart
			$wpsc_cart->submit_stock_claims( $purchase_log['id'] );
			$wpsc_cart->empty_cart();
		}
	}
}

?>
