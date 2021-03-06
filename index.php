<?php get_header(); ?>

<!-- MAIN CONTENT -->
	<div class="container">
	
		<div class="row">
		
			<div class="span9col-sm-9 col-md-9 article-container-fix">
				
				<div class="articles">

					<?php if (have_posts()) : while(have_posts()) : the_post(); ?>

						<?php get_template_part('content', get_post_format()); ?>

						<article <?php post_class('clearfix'); ?> id="post-<?php the_ID(); ?>">

							<header>
								
								<?php 
									if (comments_open() && !post_password_required()) {
										comments_popup_link('0', '1', '%', 'article-meta-comments');
									}
								?>
								<p class="article-meta-categories"><?php the_category('&nbsp;/&nbsp;'); ?></p>
								<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
								<p class="article-meta-extra"><?php the_time(get_option('date_format')); ?>, by <?php the_author_posts_link(); ?></p>
								
							</header>
							
							<?php if(has_post_thumbnail()) : ?>
								<figure class="article-preview-image">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
								</figure>
							
							<?php endif; ?>	

							<?php the_content(__('Read more &raquo;', 'mike-blog')); ?>
							
						</article>
						
						<hr class="fancy-hr" />

					<?php endwhile; else : ?>
						<h1><?php _e('No posts were found', 'mike-blog') ?></h1>
					<?php endif; ?>
					<hr class="fancy-hr" />
				
					


					<article>
						
						<header>
							
							<span class="post-format-quote"></span>
							<p class="article-meta-categories"><a href="">Category</a></p>
							<p class="article-meta-extra">November 10th, 2013, by <a href="">Mike Situ</a></p>
							
						</header>
						
						<div class="quote-container">
							
							<blockquote>Thank you for visiting my blog!</blockquote>
							<cite>- Mike Situ</cite>
							
						</div> <!-- end quote-container -->
						
					</article>

					<hr class="fancy-hr" />

					<article>
						
						<header>
							
							<span class="post-format-url"></span>
							<p class="article-meta-categories"><a href="">Category</a></p>
							<p class="article-meta-extra">November 10th, 2013, by <a href="">Mike Situ</a></p>
							
						</header>
						
						<div class="url-container">
							
							<p>Learn more about Mike here!</p>
							<span><a href="http:mikesitu.com/about.html">http:mikesitu.com/about.html</a></span>
							
						</div> <!-- end quote-container -->
						
					</article>
					
					<hr class="fancy-hr" />
					
					<div class="articles-nav clearfix">
						
						<!-- in this case, previous posts are on the lowest numbered pages, which are the newest ones. -->
						<p class="articles-nav-prev"><?php next_posts_link(__('&larr; Older Posts', 'mike-blog')); ?></p>
						<p class="articles-nav-next"><?php previous_posts_link(__('Newer Posts &rarr;', 'mike-blog')); ?></p>
						
					</div> <!-- end articles-nav -->
					
				</div> <!-- end articles -->
				
			</div> <!-- end col-sm-9 col-md-9 -->
			
			<aside class="col-sm-3 col-md-3 main-sidebar">
				
				<?php get_sidebar(); ?>

			</aside>
			
		</div> <!-- end row -->
		
	</div> <!-- end container -->

<?php get_footer(); ?>