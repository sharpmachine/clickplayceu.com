<?php get_header(); ?>
	<div id="content">
		<div id="content-inside">
			<div id="breadcrumbs">
				<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p>','</p>'); } ?>
				<?php include('searchform.php'); ?>
			</div>
			
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
				
					<div class="post-meta">
					
					<?php if (is_user_logged_in()) : ?>
						<?php //pretest
						$replacement = '';
						$examid = get_post_meta($post->ID, 'ExamID', true)	;				
						$testnamerow=$wpdb->get_row("select testname,testtype from wp_hexam_testnames where id=".$examid);
					    $testname=$testnamerow->testname;
					    $testtype=$testnamerow->testtype;
						 if ($testtype=='QUIZ') {
						?>	<h3><a href="#" id="slick-pretest">Step 1 Take the Pre-Test!</a></h3>
							<div id="pretest" style="padding:10px;">
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
						      for ($j=1;$j<=(sizeof($answers_ed)-1);$j++) {
						        $replacement=$replacement.'
						        <input type="radio" name="answer_'.$i.'" value="'.$j.'">'.$answers_ed[$j];
						      }
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
							    echo '<P>test value: ' . $_POST["test"] . '</p>';
						     	$replacement= $replacement.'<b>Your pre-test score is '.$point.' points.</b>';
						     }
							}
							echo $replacement;
						 }
						?></div>
						
						<h3><a href="#" id="slick-test">Step 2 Take the Test!</a></h3>
						<div id="test" style="padding:10px;">
	
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
						      for ($j=1;$j<=(sizeof($answers_ed)-1);$j++) {
						        $replacement=$replacement.'
						        <input type="radio" name="answer_'.$i.'" value="'.$j.'">'.$answers_ed[$j];
						      }
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
						     if ($testnamerow->testtype=='QUIZ' & (isset($_POST["test"]) & ($_POST["test"]=="True"))) {
							    $replacement= $replacement.'<b>Your score is '.$point.' points.</b>';
						     }
							 if (isset($_POST["test"]) & ($_POST["test"]=="True")) {
							      $wpdb->query("select ID from wp_hexam_userdata where testid=".$examid." and userid=".get_current_user_id());
								  if ($wpdb->num_rows==0) {
							          $wpdb->query("insert into wp_hexam_userdata(userid,testid,point) values(".get_current_user_id().",".$examid.",".$point.")");
							          //message for score
							          $percent = $point / $question_count;
									  echo '<P>test value: ' . $_POST["test"] . '</p>';
							          if ($percent >= .7) {
									  	$replacement=$replacement.'<br><b>'.$word["hcongrat"].'</b>';
									  } else {
									  	$replacement=$replacement.'<br><b>'.$word["hbest"].'</b>';	
									  }
							      } else {
										//compare previous scores
								  		$points = $wpdb->get_row("select point from wp_hexam_userdata where testid=".$examid." and userid=".get_current_user_id());
								  		$percent = $points->point / $question_count;
								  		$replacement=$replacement.'<p>Best so far: '.$points->point.'. Points this time: '.$point.'. Percent: '.$percent.'</p>';
								  		//update query if points is greater than previous entry
								  		if ($point > $points->point) {
								  			$wpdb->query("update wp_hexam_userdata set point = ".$point." where testid=".$examid." and userid=".get_current_user_id());
								  		} 
								  		if ($percent >= .7) {
											$replacement=$replacement.'<br><b>Congratulations! You\'ve passed!</b>';
											
										} else {
											$replacement=$replacement.'<br><b>You\'ve scored a personal best for this test but have not met the minimum score of 70%. Please try again.</b>';	
										}
								  		
								  		
								  }
									//$prodid = $wpdb->get_row("select prodid from wp_hexam_testnames where id =".$examid);
									//$replacement=$replacement.'[add_to_cart=95]';
							 }
							}
							echo $replacement;
						 }
						?></div>
						<h3>Step 3 Purchase CEU</h3>
						<?php //display add to cart button
						
						$question_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM wp_hexam_questions where testid=".$examid));
						$points = $wpdb->get_var($wpdb->prepare("select point from wp_hexam_userdata where testid=".$examid." and userid=".get_current_user_id()));
						if (isset($question_count) & isset($points)) {
							$percent = $points / $question_count;
						}
						
						if (isset($percent) & $percent >= .7) :
							$productID = get_post_meta($post->ID, 'ProductID', true); ?>
							<form class="product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo $productID; ?>">
							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
							<input type="hidden" value="<?php echo $productID; ?>" name="product_id" />
							<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow') !='1')) : ?>
								<?php if(wpsc_product_has_stock()) : ?>
									<div class="wpsc_buy_button_container">
											<?php if(wpsc_product_external_link($productID) != '') : ?>
											<?php $action = wpsc_product_external_link($productID); ?>
											<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text($productID, __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target($productID); ?>')">
											<?php else: ?>
										<input type="submit" value="<?php _e('Add To Cart', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button" id="product_<?php echo $productID; ?>_submit_button"/>
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
							<p>Score 70% to purchase this CEU</p>
							<?php
						
						
						endif; ?> 
							
							
						<?php else: ?>	
							<?php if ( wpsc_show_user_login_form() && !is_user_logged_in() ): ?>
									<p><?php _e('You must sign in or register to take the Pre-Test and Test', 'wpsc');?></p>
									<div class="wpsc_registration_form">
										
										<fieldset class='wpsc_registration_form'>
											<h2><?php _e( 'Sign in', 'wpsc' ); ?></h2>
											
											<?php
											$args = array( 'remember' => false );
											wp_login_form( $args );
											?>
											<div class="wpsc_signup_text"><?php _e('If you have bought from us before please sign in here to purchase', 'wpsc');?></div>
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
					</div>
					
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
				
				<?php //comments_template(); ?>
				
				<div class="divider-top">
					<!-- nothing to see here -->
				</div>	
				
				<?php endwhile; ?>
			<?php else : ?>
			
				<div class="single">
					<h2>Sorry, but you are looking for something that isn't here.</h2>
				</div>
				
			<?php endif; ?> 
			</div> <!-- main-single -->
			
			<?php get_sidebar(); ?>
		</div> <!-- content-inside -->
	</div> <!-- content -->

<?php get_footer(); ?>
