<?php
/* ------------------------------------------------------------------------------------------------------------
	
	Template Name: Home
	
------------------------------------------------------------------------------------------------------------ */
?>
<?php get_header(); ?>           
<?php if (_sg('Home')->showExtras()) { ?>
	<?php
		$args = array();
		$args['post_type'] = 'extra';
		$args['posts_per_page'] = 6;
		$args['order'] = 'ASC';
		if (_sg('Home')->getExtrasCategory() != 0) {
			$args['post__in'] = get_objects_in_term(_sg('Home')->getExtrasCategory(), 'extra_category');
		}
		query_posts($args);
		$cur = 0;
		$count = sg_posts_count();
	?>
	<div class="inner clearfix">
		<div class="inner-t">
			<?php if (have_posts()) { ?>
				<?php if (_sg('Home')->showExtrasTitle()) { ?>
					<div class="heading">
						<h3><?php _sg('Home')->eExtrasTitle(); ?></h3>
					</div>
				<?php } ?>
				<div class="icons">
				<?php while (have_posts()) : the_post(); ?>
					<div class="col1-<?php echo $count; if ((++$cur % $count) == 0) echo ' omega'; ?>">
						<?php _sg('Extra', TRUE)->eExtraIcon(get_the_ID(), get_the_title()); ?>
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>
				</div>
			<?php } else {
				$empty_extras = __('Extras is empty', SG_TDN);
				echo '<div style="width:938px; padding:20px 0 0 0;">' . sg_message($empty_extras) . '</div>';
			} ?>
		</div>
	</div>
	<div class="shady bott-27"></div>
<?php } ?>
<?php if (_sg('Home')->showLatest()) { ?>
	<?php
		$args = array();
		$args['post_type'] = 'portfolio';
		$args['posts_per_page'] = _sg('Home')->getLatestCount();
		$args['meta_key'] = '_thumbnail_id';
		if (_sg('Home')->getLatestCategory() != 0) {
			$args['post__in'] = get_objects_in_term(_sg('Home')->getLatestCategory(), 'portfolio_category');
		}
		query_posts($args);
		$cur = 0;
		$count = sg_posts_count();
	?>
	<div class="inner clearfix">
		<div class="inner-t">
			<?php if (have_posts()) { ?>
				<div class="col1-3">
        	        <div class="heading">
    	                <h3><?php _sg('Home')->eLatestTitle(); ?></h3>
	                </div>
					<?php _sg('Home')->eLatestText(); ?>
					<?php if ($count > 2) { ?>
						<div class="content-slider-nav">
							<div class="jFlow-arrows">
								<span class="jFlowPrev"></span>
								<span class="jFlowNext"></span>
								<div id="myController">
									<?php echo str_repeat('<span class="jFlowControl"></span>', round($count / 2)); ?>
								</div>
							</div>
						</div>
					<?php } ?>
            	</div>
				<div class="jflow-content-slider">
					<div<?php if ($count > 2) echo ' id="slides"' ?>>
						<div class="slide-wrapper">
						<?php while (have_posts()) : the_post(); ?>
						<?php if ((++$cur > 2) AND ($cur % 2 == 1)) echo '</div><div class="slide-wrapper">'; ?>
							<div class="col1-3<?php if (($cur % 2) == 0) echo ' omega'; ?>">
								<div class="item-holder">
									<div class="proj-img">
										<a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="prettyPhoto zoom" title="<?php //the_title(); ?>"></a>
										<a href="<?php the_permalink(); ?>"></a>
										<?php the_post_thumbnail(_sg('Home')->showLatestEx() ? 'sg_portfolio' : 'sg_portfolio2', array('alt' => get_the_title(), 'class' => (_sg('Home')->showLatestEx() ? 'l-w' : 'l-w2'))); ?>
										<i></i>
									</div>
									<?php if (_sg('Home')->showLatestEx()) { ?>
										<div class="descr">
											<a href="<?php the_permalink(); ?>"><h5><?php echo sg_text_trim(get_the_title(), 30); ?></h5></a>
											<?php echo apply_filters('the_excerpt', sg_text_trim(get_the_excerpt(), 35)); ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php endwhile; ?>
						</div>
					</div>
				</div>
			<?php } else {
				$empty_extras = __('Portfolio is empty', SG_TDN);
				echo '<div style="width:938px; padding:20px 0 0 0;">' . sg_message($empty_extras) . '</div>';
			} ?>
		</div>
	</div>
	<div class="shady bott-27"></div>
<?php } ?>
<div class="inner-blank clearfix">
	<?php wp_reset_query(); the_content();?>
</div>
<?php get_footer(); ?>