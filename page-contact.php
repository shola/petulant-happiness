<?php 
/*
	Template Name: Contact Page
*/
?>

<?php 
	// Function for email address validation
	function isEmail($verify_email) {
	
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$verify_email));
	
	}

	// form submission detection/validation
	if (isset($_POST['contact-submit'])) {
		$error_name = false;
		$error_email = false;
		$error_message = false;

		//trim strips trail/lead whitespace from string
		$name = trim($_POST['contact-author']);
		$email = trim($_POST['contact-email']);
		$message = trim($_POST['contact-message']);
		$website = stripslashes(trim($_POST['contact-url'])); //unquotes a quoted string, needed for large texts
		$receiver_email = 'michael.o.situ@gmail.com';
		
		if ($name === '') {
			$error_name = true;
			$name = '';
		} 

		if ($email === '' || !isEmail($email)) {
			$error_email = true;
			$email = '';
		} 

		if ($message  === '') {
			$error_message  = true;
			$message  = '';
		} 

		if (!($error_name || $error_email || $error_message)) {
			$subject = 'You have been contacted by ' . $name;

			$body = "You have been contacted by $name. Their message is:" . PHP_EOL . PHP_EOL; // you can use variable names directly in double-quoted strings!
			$body .= $message . PHP_EOL . PHP_EOL; // PHP_EOL is a blank line
			$body .= "You can contact $name via email at $email.";
			if ($website != '') {
				$body .= " or visit their website: $website";
			}
			$body .= PHP_EOL . PHP_EOL;

			$headers = "From $email" . PHP_EOL;
			$headers .= "Reply-To: $email" . PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
			$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL; 

			// evals to true if messages are sent correctly
			if (mail($receiver_email, $subject, $body, $headers)) {
				$email_sent = true;
			} else {
				$email_sent_error = true;
			}
		}
	}

?>

<!-- custom page template that takes precedence over single.php and index.php -->

<?php get_header(); ?>

	<!-- MAIN CONTENT -->
	<div class="container">
	
		<div class="row">
		
			<div class="col-sm-9 col-md-9 article-container-fix">
				
				<div class="articles">
				
					<?php if(have_posts()) : while(have_posts()) : the_post();  ?>
					<article class="clearfix">
						
						<header>
							
							<h1><?php the_title(); ?></a></h1>
							<?php if(current_user_can('edit_post', $post->ID)) {
																// BEFORE                         AFTER
								edit_post_link(__('Edit This', 'mike-blog'), '<p class="article-meta-extra">',	'</p>'); 
							}?>
						
						</header>

						<?php if (isset($email_sent) && $email_sent) : ?>
							<h3><?php _e('Success!', 'mike-blog'); ?></h3>
							<p><?php _e('You have successfully sent the message.', 'mike-blog'); ?></p>
						<?php elseif (isset($email_sent_error) && $email_sent_error) : ?>
							<h3><?php _e('Error!', 'mike-blog'); ?></h3>
							<p><?php _e('We could not send the message at this time. Please try again later.', 'mike-blog'); ?></p>
						<?php else : ?>
							<hr/>

							<form action="<?php the_permalink(); ?>" method="post" id="contact-form">
								<p <?php if (isset($error_name) && $error_name) echo 'class="p-errors"'; ?>>
									<input type="text" value="<?php if (isset($_POST['contact-author'])) echo $_POST['contact-author']; ?>" name="contact-author" id="contact-author" />
									<label for="contact-author"><?php _e('Name *', 'mike-blog'); ?></label>
								</p>
								<p <?php if (isset($error_email) && $error_email) echo 'class="p-errors"'; ?>>
									<input type="text" value="<?php if (isset($_POST['contact-email'])) echo $_POST['contact-email']; ?>" name="contact-email" id="contact-email" />
									<label for="contact-email"><?php _e('Email *', 'mike-blog'); ?></label>
								</p>
								<p>
									<input type="text" value="<?php if (isset($_POST['contact-url'])) echo stripslashes($_POST['contact-url']); ?>" name="contact-url" id="contact-url" />
									<label for="contact-url"><?php _e('Website', 'mike-blog'); ?></label>
								</p>
								<p <?php if (isset($error_message) && $error_message) echo 'class="p-errors"'; ?>>
									<textarea name="contact-message" id="contact-message" cols="30" rows="10"></textarea>
								</p>

								<!-- used to verify that form was submitted, i combined the submit button with this code from Adi because it makes more sense to me. to make it stock, uncomment code below, and remove name and id from the p>input -->
								<!-- <input type="hidden" name="contact-submit" id="contact-submit" value="true"> -->

								<p><input type="submit" name="contact-submit" id="contact-submit" value="Send Message" /></p>
							</form>
						<?php endif; ?>

						<hr class="image-replacement"/>
						
						<?php the_content(); ?>
						
					</article>

				<?php endwhile; else : ?>

					<article>
						<h1><?php _e('No posts were found', 'mike-blog'); ?></h1>
					</article>

				<?php endif; ?>
					
				</div> <!-- end articles -->
				
				<div class="comments-area" id="comments">
					
					<?php comments_template('', true); ?>
					
				</div> <!-- end comments-area -->
				
			</div> <!-- end span9 -->
			
			<aside class="col-sm-3 col-md-3 main-sidebar">
				
				<?php get_sidebar(); ?>

			</aside>
			
		</div> <!-- end row -->
		
	</div> <!-- end container --> 

<?php get_footer(); ?>