<?php 
function get_home_news_pic( $cat_data ){ ?>

<?php
	$Cat_ID = $cat_data['id'];
	$Posts = 9;
	$Box_Title = $cat_data['title'];
	
	$cat_query = new WP_Query('cat='.$Cat_ID.'&posts_per_page='.$Posts); 
?>
		<section class="cat-box pic-box clear tie-cat-<?php echo $Cat_ID ?>">
			<h2 class="cat-box-title"><?php echo $Box_Title ; ?></h2>
			<div class="cat-box-content">
				<?php if($cat_query->have_posts()): $count=0; ?>
				<ul>
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); $count ++ ;?>
				<?php if($count == 1 ) : ?>
					<li class="first-pic">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php tie_thumb('',300,160); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>
					
					</li><!-- .first-pic -->
					<?php else: ?>
					<li>
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ttip"><?php tie_thumb('',70,70); ?></a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>			
					</li>
					<?php endif; ?>
				<?php endwhile;?>
				</ul>
				<div class="clear"></div>

					<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section>

	
<?php } ?>