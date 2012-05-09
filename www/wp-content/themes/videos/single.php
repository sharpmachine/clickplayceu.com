<?php get_header(); ?>
	<div id="content">
		<div id="content-inside">
			<!-- <div id="breadcrumbs">
				<?php //if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p>','</p>'); } ?>
				<?php //include('searchform.php'); ?>
			</div> -->
			
			<div id="main-single">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
				<div id="post-<?php the_ID(); ?>" <?php post_class('single') ?>>
					<?php if ( get_post_meta($post->ID, "_videoembed", true) || get_post_meta($post->ID, "_videoembed_manual", true) ): ?>
					<div id="video-container-single">
						<div id="video-top">
							<!-- nothing to see here -->
						</div>
						
						<div id="post-nav">
							<div class="previous-post">
								<?php previous_post_link('%link', ' ', TRUE); ?>
							</div>
							
							<div id="video-single">
								<?php echo get_video($post->ID); ?>
								
								<div class="video-desc">
									<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<ul>
										<li><?php echo get_post_meta(get_post_meta($id, 'ProductID', true), 'Credits', true); ?> Continuing Education Hours</li>
										<?php 
											$total = get_post_meta(get_post_meta($id, 'ProductID', true), '_wpsc_price', true);
											$price = "$".number_format($total, 2, '.', ','); ?>
										<li>Price: <?php echo $price; ?></li>
									</ul>
									<?php the_excerpt(); ?>
								</div>
							</div> <!-- video -->
							
							<div class="next-post">
								<?php next_post_link('%link', ' ', TRUE); ?>
							</div>
						</div>
						
						<div id="video-bottom">
							<!-- nothing to see here -->
						</div>
					</div> <!-- video-container -->
					<?php else : ?>
						<!-- no video on this post -->
					<?php endif; ?>
				
					
					
					
					
					<div class="entry-single">
						<?php if ( get_post_meta($post->ID, "_videoembed", true) || get_post_meta($post->ID, "_videoembed_manual", true) ): ?>
							<!-- nothing to see here -->
						<?php else : ?>
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<?php endif; ?>
						
						<?php the_content('Continue Reading'); ?>
						
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						
						
					</div>
				</div> <!-- post -->
				
				<div class="post-meta">
					<div id="post-meta-top">
						<!-- nothing to see here -->
					</div>
					<?php if (is_user_logged_in()) : ?>
						<?php //pretest
						$replacement = '';
						$examid = get_post_meta($post->ID, 'ExamID', true)	;				
						$testnamerow=$wpdb->get_row("select testname,testtype from wp_hexam_testnames where id=".$examid);
					    $testname=$testnamerow->testname;
					    $testtype=$testnamerow->testtype;
						 if ($testtype=='QUIZ') {
						?>	
						<span>First, take the pre-test.</span>
						<h3><a href="#" id="slick-pretest" class="continue-reading" style="float: none;">1. Take Pre-Test!</a></h3>
						<?php if ($_POST["test"]=="False") : ?>
							<div id="pretest" style="padding:10px;display:block;">
						<?php else :?>
							<div id="pretest" style="padding:10px;display:none;">
						<?php endif; ?>
						
						<?php
						  if (!isset($_POST["test"]) || $_POST["test"]=="True") {
						  	//$replacement=$replacement.'<h3><a href="#" id="slick-pretest">Step 1 Take the Pre-Test!</a></h3>';
						  	//$replacement=$replacement.'<div id="pretest" style="padding:10px;">';
						    $replacement=$replacement.'<form method="post" action="" name="pretest">';
						    $testsnet=$wpdb->get_results("select * from wp_hexam_questions where testid=".$examid." order by id asc");
						    $i=0;
						    foreach ($testsnet as $tests) {
						      $i=$i+1;
						      $replacement=$replacement.$i.') <input type="hidden" name="qid'.$i.'" value="'.$tests->id.'">'.stripslashes($tests->content).'<br>';
						      $answers_ed=explode("~",stripslashes($tests->answers));// echo sizeof($answers_ed);
						      $replacement = $replacement. '<ul>';
						      for ($j=1;$j<=(sizeof($answers_ed)-1);$j++) {
						        $replacement=$replacement.'
						        <li><input type="radio" name="answer_'.$i.'" value="'.$j.'"> '.$answers_ed[$j].'</li>';
						      }
						      $replacement = $replacement. '</ul>';
						     $replacement=$replacement.'<br>';
						    }
						    $replacement=$replacement.'
						    <input type="hidden" name="test" value="False">
						    <br><input type="submit" name="Finish" value="Finish Pre-Test"> </form>';  
						  } elseif ($_POST["test"]=="False") {
						      $question_row=$wpdb->get_results("select answers,correct from wp_hexam_questions where testid=".$examid);
						      $question_count=$wpdb->num_rows;
						      $acount_row=$wpdb->get_row("select answers from wp_hexam_questions where testid=".$examid." limit 1");
						      $answers_count=count(explode("~",$acount_row->answers))-1;
						      $i=0;$point=0;
						      foreach ($question_row as $tests) {
						        $i=$i+1;
						        if ($_POST["answer_".$i]==$tests->correct){
						          $point=$point+1;
						        }
						     }
						     if (isset($_POST["test"]) & ($_POST["test"]=="False")) {
							    //echo '<P>test value: ' . $_POST["test"] . '</p>';
						     	$replacement .= 'You scored <strong>' . $point . '</strong> points.  You need at least ' . ((int) (.7 * $question_count)) . ' points to pass.  Watch the video and take the test.';
						     }
							}
							echo $replacement;
						 }
						?></div>
						<span>Next, watch the video and take the test.</span>
						<h3><a href="#" id="slick-test" class="continue-reading" style="float: none;">2.  Take Test!</a></h3>
						
						<?php if ($_POST["test"]=="True") : ?>
							<div id="test" style="padding:10px;display:block;">
						<?php else :?>
							<div id="test" style="padding:10px;display:none;">
						<?php endif; ?>
						
						<?php //test
						$replacement = '';
						
						 if ($testtype=='QUIZ') {
						  if (!isset($_POST["test"]) || $_POST["test"]=="False") {
						  	//$replacement=$replacement.'<h3><a href="#" id="slick-test">Step 2 Take the Test!</a></h3>';
						  	//$replacement=$replacement.'<div id="test" style="padding:10px;">';
						    $replacement=$replacement.'<form method="post" action="" name="test">';
						    $testsnet=$wpdb->get_results("select * from wp_hexam_questions where testid=".$examid." order by id asc");
						    $i=0;
						    foreach ($testsnet as $tests) {
						      $i=$i+1;
						      $replacement=$replacement.$i.') <input type="hidden" name="qid'.$i.'" value="'.$tests->id.'">'.stripslashes($tests->content).'<br>';
						      $answers_ed=explode("~",stripslashes($tests->answers));// echo sizeof($answers_ed);
						      $replacement = $replacement. '<ul>';
						      for ($j=1;$j<=(sizeof($answers_ed)-1);$j++) {
						        $replacement=$replacement.'
						        <li><input type="radio" name="answer_'.$i.'" value="'.$j.'"> '.$answers_ed[$j].'</li>';
						      }
						      $replacement = $replacement. '</ul>';
						     $replacement=$replacement.'<br>';
						    }
						    $replacement=$replacement.'
						    <input type="hidden" name="test" value="True">
						    <br><input type="submit" name="Finish" value="Finish"> </form>';  
						    } elseif ($_POST["test"]=="True") {
						      $question_row=$wpdb->get_results("select answers,correct from wp_hexam_questions where testid=".$examid);
						      $question_count=$wpdb->num_rows;
						      $acount_row=$wpdb->get_row("select answers from wp_hexam_questions where testid=".$examid." limit 1");
						      $answers_count=count(explode("~",$acount_row->answers))-1;
						      $i=0;$point=0;
						      foreach ($question_row as $tests) {
						        $i=$i+1;
						        if ($_POST["answer_".$i]==$tests->correct){
						          $point=$point+1;
						        }
						     }
						     $percent = round(($point / $question_count) * 100);
						     if ($testnamerow->testtype=='QUIZ' & (isset($_POST["test"]) & ($_POST["test"]=="True"))) {
							    $replacement= $replacement.'Your score is <strong class="hexam-score">' . $percent . '%</strong>.';
						     }
							 if (isset($_POST["test"]) & ($_POST["test"]=="True")) {
							      $wpdb->query("select ID from wp_hexam_userdata where testid=".$examid." and userid=".get_current_user_id());
								$minimum = 70;
								
								$old_percent = 0;
								
								if ($wpdb->num_rows==0) {
									$wpdb->query("insert into wp_hexam_userdata(userid,testid,point) values(".get_current_user_id().",".$examid.",".$point.")");
								} else {
									$points = $wpdb->get_row("select point from wp_hexam_userdata where testid=".$examid." and userid=".get_current_user_id());
									$old_percent = round(($points->point / $question_count) * 100);
									if ($point > $points->point) {
										$wpdb->query("update wp_hexam_userdata set point = ".$point." where testid=".$examid." and userid=".get_current_user_id());
								  	}
								}
								if ($old_percent >= $minimum && $percent < $minimum) {
									$replacement .= '<div class="hexam-result hexam-success"><p><strong>Congratulations</strong>, you already took the test and passed. Now add the certificate to your cart and check out.</p></div>';
								} elseif ($percent >= $minimum) {
									$replacement .= '<div class="hexam-result hexam-success"><p><strong>Congratulations</strong>, you\'ve passed the test! Now add the certificate to your cart and check out.</p></div>';
								} else {
									$replacement .= '<div class="hexam-result hexam-failure"><p><strong>Uh-oh</strong>, that score isn\'t quite high enough.  You need at least <strong>' . $minimum . '%</strong> to pass.</p><p><strong><a href="' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '">Try again!</a></strong></p></div>';
								}
								
							 }
							}
							echo $replacement;
						 }
						?></div>
						<?php //display add to cart button
						
						$question_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM wp_hexam_questions where testid=".$examid));
						$points = $wpdb->get_var($wpdb->prepare("select point from wp_hexam_userdata where testid=".$examid." and userid=".get_current_user_id()));
						if (isset($question_count) & isset($points)) {
							$percent = $points / $question_count;
						}
						
						if (isset($percent) & $percent >= .7) :
							$productID = get_post_meta($post->ID, 'ProductID', true); ?>
							<form class="product_form" enctype="multipart/form-data" action="<?php echo get_page_link('147'); ?>" method="post" name="1" id="product_<?php echo $productID; ?>">
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo $productID; ?>" name="product_id" />
							<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div class="wpsc_buy_button_container">
											<?php if(wpsc_product_external_link($productID) != '') : ?>
											<?php $action = wpsc_product_external_link($productID); ?>
											<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text($productID, __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target($productID); ?>')">
											<?php else: ?>
												<span>Now just add the certificate to your cart!</span>
										<input type="submit" value="<?php _e('3. Add To Cart', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button" id="product_<?php echo $productID; ?>_submit_button"/>
										<!-- bypass check in wp e-commerce Javascript to avoid changing plugin -->
										<input type="file" style="display:none;" />
										
											<?php endif; ?>
										<div class="wpsc_loading_animation">
											<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
											<?php _e('Updating cart...', 'wpsc'); ?>
										</div><!--close wpsc_loading_animation-->
									</div><!--close wpsc_buy_button_container-->
								<?php else : ?>
									<p class="soldout"><?php _e('This product has sold out.', 'wpsc'); ?></p>
								<?php endif ; ?>
							<?php endif ; ?>
							</form><!--close product_form-->
						<?php else :  
							?>
							<span>Finally, pass the test to add it to your cart.</span>
							<p>Score 70% to purchase this CEU</p>
							<?php
						
						
						endif; ?> 
							
							
						<?php else: ?>	
							<?php if ( wpsc_show_user_login_form() && !is_user_logged_in() ): ?>
									<p style="margin-bottom: 0;"><?php _e('You must sign in or register to take the Pre-Test and Test', 'wpsc');?></p>
									<div class="wpsc_registration_form">
										
										<fieldset class='wpsc_registration_form'>
											<h2><?php _e( 'Log in', 'wpsc' ); ?></h2>
											
											<?php
											$args = array( 'remember' => false );
											wp_login_form( $args );
											?>

											<p>Don't have an account? <a href="<?php bloginfo('url'); ?>/wp-login.php?action=register">Sign up now.</a></p>

										</fieldset>
									</div>
							<?php endif; ?>	
							
					   <?php endif; // closes user login form ?>
						
							
							
							
						<!--
						<div class="post-image">
							<?php if ( get_post_meta($post->ID, "_videoembed", true) || get_post_meta($post->ID, "_videoembed_manual", true) ): ?>
							<a class="post-frame-video" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"></a>
							<?php else : ?>
							<a class="post-frame-post" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"></a>
							<?php endif; ?>
							
							<?php the_post_thumbnail(); ?>
						</div>
						
						<ul class="details">
							<li><span class="date"><?php the_time('F j, Y'); ?></span></li>
							<li><span class="author">Posted by: <?php the_author(); ?></span></li>
							<li><span class="comments"><?php comments_number('No Comments','One Comment','% Comments'); ?></span></li>
							<li><span class="category"><?php the_category(', ') ?></span></li>
							<?php if (has_tag()): ?>
							<li><span class="tags"><?php the_tags(''); ?></span></li>
							<?php endif; ?>
						</ul>
						
						-->
						<div id="post-meta-bottom">
						<!-- nothing to see here -->
						</div>
					</div>
				

				
				<?php endwhile; ?>
			<?php else : ?>
			
				<div class="single-postorpage">
					<h2>Sorry, but you are looking for something that isn't here.</h2>
				</div>
				
			<?php endif; ?> 
			</div> <!-- main-single -->
		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>
