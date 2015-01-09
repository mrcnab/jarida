<?php
function get_home_recent( $cat_data ){

	$exclude = $cat_data['exclude'];
	$Posts = $cat_data['number'];
	$Box_Title = $cat_data['title'];
	$display = $cat_data['display'];
	
	$cat_query = new WP_Query(array ( 'posts_per_page' => $Posts , 'category__not_in' => $exclude)); 
?>
		<section class="cat-box recent-box">
			<h2 class="cat-box-title"><?php echo $Box_Title ; ?></h2>
			<div class="cat-box-content">
			
				<?php if($cat_query->have_posts()): ?>

				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
				<?php if( $display == 'blog' ): ?>
					<article class="item-list">

							<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
						<div class="post-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<?php $image_id = get_post_thumbnail_id($post->ID);  
						echo $image_url = wp_get_attachment_image($image_id, array(300,160) );   ?>
								<?php tie_get_score( true ); ?>
							</a>
						</div><!-- post-thumbnail /-->
							<?php endif; ?>
						<h2 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<p class="post-meta">
							<?php tie_get_time() ?>
							<span class="post-comments"><?php comments_popup_link( __( '0', 'tie' ), __( '1 Comment', 'tie' ), __( '% Comments', 'tie' ) ); ?></span>
							<?php echo tie_views(); ?>
						</p>
						<div class="entry">
							<p><?php tie_excerpt_home() ?></p>
							<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'tie' ) ?></a>
						</div>
						
						<?php tie_include( 'post-share' ); // Get Share Button template ?>	
					</article><!-- .item-list -->
				<?php else: ?>
					<div class="recent-item">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php tie_thumb('', 300 ,160); ?>
									<?php tie_get_score( ); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>			
						<h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<p class="post-meta">
							<?php tie_get_time() ?>
						</p>
					</div>
				<?php endif; ?>
				<?php endwhile;?>
				<div class="clear"></div>

			<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section>
		<div class="clear"></div>

<?php
}
?>