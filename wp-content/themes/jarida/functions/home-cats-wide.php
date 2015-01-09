<?php 
function get_home_wide_cat( $cat_data ){ ?>

<?php
	
	$Cat_ID = $cat_data['id'];
	$Posts = $cat_data['number'];
	$order = $cat_data['order'];
	if( $order == 'rand') $rand ="&orderby=rand";

	$cat_query = new WP_Query('cat='.$Cat_ID.'&posts_per_page='.$Posts.$rand); 
	$cat_title = get_the_category_by_ID($Cat_ID);
	$home_layout = $cat_data['style'];
	
?>
			
	
		<section class="cat-box wide-cat-box tie-cat-<?php echo $Cat_ID ?>">
			<h2 class="cat-box-title"><a href="<?php echo get_category_link( $Cat_ID ); ?>"><?php echo $cat_title ; ?></a></h2>
			<div class="cat-box-content">
			
				<?php if($cat_query->have_posts()): ?>
				<ul>
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post(); ?>
					<li>
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php tie_thumb('',300,160); ?>
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
						</li><!-- .first-news -->

				<?php endwhile;?>
				</ul>
				<div class="clear"></div>

					<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section><!-- List Box -->
<?php } 

function get_home_wide_scroll( $cat_data ){ ?>
	
<?php
    wp_enqueue_script( 'tie-cycle' );

	$Cat_ID = $cat_data['id'];
	$Posts = $cat_data['number'];
	$Box_Title = $cat_data['title'];
	
	$cat_query = new WP_Query('cat='.$Cat_ID.'&posts_per_page='.$Posts); 
?>
		<section class="cat-box scroll-box scroll-box-wide tie-cat-<?php echo $Cat_ID ?>">
			<h2 class="cat-box-title"><?php echo $Box_Title ; ?></h2>
			<div class="cat-box-content">
			
				<?php if($cat_query->have_posts()): ?>
				<div  id="slideshow<?php echo $Cat_ID ?>">
				<?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
					<div class="scroll-item">
						<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
									<?php tie_thumb('',300,160); ?>
									<?php tie_get_score( true ); ?>
								</a>
							</div><!-- post-thumbnail /-->
						<?php endif; ?>			
						<h3 class="post-box-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<p class="post-meta">
							<?php tie_get_time() ?>
						</p>
					</div>
				<?php endwhile;?>
				<div class="clear"></div>
				</div>
				<div class="scroll-nav"><a id="next<?php echo $Cat_ID ?>" href="#">Next</a><a class="prev-scroll" id="prev<?php echo $Cat_ID ?>" href="#">Prev</a></div>
				<?php endif; ?>
			</div><!-- .cat-box-content /-->
		</section>
		<div class="clear"></div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var vids = jQuery("#slideshow<?php echo $Cat_ID ?> .scroll-item");
		for(var i = 0; i < vids.length; i+=4) {
		  vids.slice(i, i+4).wrapAll('<div class="group_items"></div>');
		}
		jQuery(function() {
			jQuery('#slideshow<?php echo $Cat_ID ?>').cycle({
				fx:     'scrollHorz',
				timeout: 3000,
				//pager:  '#nav<?php echo $Cat_ID ?>',
				slideExpr: '.group_items',
				prev:   '#prev<?php echo $Cat_ID ?>', 
				next:   '#next<?php echo $Cat_ID ?>',
				speed: 300,
				pause: true
			});
		});
  });
</script>
	
<?php } 

function get_home_reviews( $cat_data ){ 

	$Posts = $cat_data['number'];
	$Box_Title = $cat_data['title'];
	$order = $cat_data['order'];
	if( $order == 'rand') $orderby ="rand";
	elseif( $order == 'best') $orderby ="meta_value";
	else $orderby ="date";
?>
	<section class="cat-box cats-review-box">
			<h2 class="cat-box-title"><?php echo $Box_Title ; ?></h2>
			<div class="cat-box-content">
			<?php $i=0;
				for($i=1 ; $i<=3 ; $i++ ){ 
				$id= 'id'.$i;
				$Cat_ID = $cat_data[$id]
			?> 
				<div class="reviews-cat">
					<h3><a href="<?php echo get_category_link( $Cat_ID ); ?>"><?php echo get_the_category_by_ID($Cat_ID); ?></a></h3>
					<?php $cat_query = new WP_Query(array('posts_per_page' => $Posts, 'meta_key' => 'tie_review_score', 'orderby' => $orderby , 'cat' => $Cat_ID, 'post_status' => 'publish')); ?>
					<ul>
					<?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
						<li><h4><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h4> <?php tie_get_score( true ); ?></li>
					<?php endwhile;?>
					</ul>
				</div>			
				<?php } ?>

			</div><!-- .cat-box-content /-->
		</section>

<?php
}?>