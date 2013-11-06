<?php 
// Prevent the direct loading of this file, only for WP to use
if(!empty($_SERVER['SCRIPT-FILENAME']) && basename($_SERVER['SCRIPT-FILENAME']) == 'comments.php') {
	die(__('You cannot access this file directly', 'mike-framework'));
}

// Check if post is password protected
if (post_password_required()) : ?>
	<p>
		<?php _e('This post is password protected. Enter the possword to view the comments.', 'mike-framework'); ?>
		<?php return; ?>
	</p>

<?php endif; 

if(have_comments()) : ?>

	<a href="#respond" class="article-add-comments">+</a>
	<h3><?php comments_number(__('No Comments', 'mike-framework'),
														__('1 Comment', 'mike-framework'),
														__('% Comments', 'mike-framework')); ?></h3>
	<ol class="commentslist">
		 <?php wp_list_comments('callback=adaptive_comments'); ?>
	</ol>

	<div class="comments-nav-section clearfix">
						
		<p class="fl"><a href="">&larr; Older Comments</a></p>
		<p class="fr"><a href="">Newer Comments &rarr;</a></p>
		
	</div> <!-- end comments-nav-section -->


<?php elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>

	<p><?php _e('Comments are closed', 'mike-framework'); ?></p>
<?php endif; 

// Display comment form
comment_form();

?>