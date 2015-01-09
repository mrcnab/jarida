<?php get_header(); ?>
<?php
	the_post();
	$l = _sg('Layout')->getLayout();
	$sb = _sg('Sidebars')->getSidebar('content');
	$usb = ($l == 'page_r' AND $sb != SG_Module::USE_NONE);
?>
<?php if (_sg('Page')->getTopType() == 'team') { ?>
	<?php
		$args = array();
		$args['post_type'] = 'our-team';
		$args['posts_per_page'] = -1;
		$args['order'] = 'ASC';
		if (_sg('Page')->getTeamCategory() != 0) {
			$args['post__in'] = get_objects_in_term(_sg('Page')->getTeamCategory(), 'our-team_category');
		}
		query_posts($args);
		$cur = 0;
		$count = sg_posts_count();
		$count = ($count < 4) ? $count : 4;
	?>
	<div class="inner clearfix">
		<div class="inner-t">
			<?php if (have_posts()) { ?>
				<div class="col1-3">
					<div class="heading">
						<h3><?php _sg('Page')->eTeamTitle(); ?></h3>
					</div>
					<p><?php _sg('Page')->eTeamText(); ?></p>
				</div>
				<div class="team">
					<?php while (have_posts()) : the_post(); ?>
						<?php $ot_person = _sg('OurTeam', TRUE)->getPerson(get_the_ID()); ?>
						<?php if ((++$cur > $count) AND ($cur % $count == 1)) echo '<div class="bott-27 clear"></div>'; ?>
						<div class="item-holder1<?php if (($cur % $count) == 0) echo ' omega'; ?>">
							<div class="proj-img1">
								<?php echo $ot_person->photo; ?>
							</div>
							<div class="descr">
								<h5><?php the_title(); ?></h5>
								<p class="clr"><?php _e($ot_person->position); ?></p>
								<?php the_content(); ?>
							</div>
							<?php echo $ot_person->soc; ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php } else {
				$empty_extras = __('Team is empty', SG_TDN);
				echo '<div style="width:938px; padding:20px 0 0 0;">' . sg_message($empty_extras) . '</div>';
			} ?>
		</div>
	</div>
	<div class="shady bott-27"></div>
<?php } ?>
<?php if (_sg('Page')->getTopType() == 'extra') { ?>
	<?php
		$args = array();
		$args['post_type'] = 'extra';
		$args['posts_per_page'] = -1;
		$args['order'] = 'ASC';
		if (_sg('Page')->getExtrasCategory() != 0) {
			$args['post__in'] = get_objects_in_term(_sg('Page')->getExtrasCategory(), 'extra_category');
		}
		query_posts($args);
		$cur = 0;
		$count = sg_posts_count();
		$ecount = _sg('Page')->getExtrasCount();
		$count = ($count < $ecount) ? $count : $ecount;
	?>
	<div class="inner clearfix">
		<div class="inner-t">
			<?php if (have_posts()) { ?>
				<?php if (_sg('Page')->showExtrasTitle()) { ?>
					<div class="heading">
						<h3><?php _sg('Page')->eExtrasTitle(); ?></h3>
					</div>
				<?php } ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php if ((++$cur > $count) AND ($cur % $count == 1)) echo '<div class="bott-27 clear"></div>'; ?>
					<div class="col1-<?php echo $count; if (($cur % $count) == 0) echo ' omega'; ?>">
						<?php _sg('Extra', TRUE)->eExtraIcon(get_the_ID(), get_the_title()); ?>
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>
			<?php } else {
				$empty_extras = __('Extras is empty', SG_TDN);
				echo '<div style="width:938px; padding:20px 0 0 0;">' . sg_message($empty_extras) . '</div>';
			} ?>
		</div>
	</div>
	<div class="shady bott-27"></div>
<?php } ?>
<?php if ($usb) { ?>
	<div class="wrap720">
<?php } ?>
		<div class="inner-blank clearfix<?php if (_sg('Page')->showLatest()) echo ' bott-15'; ?>">
			<?php wp_reset_query(); the_content();?>
		</div>
<?php if ($usb) { ?>
	</div>
	<div class="col1-4 sidebar omega">
		<?php if (!dynamic_sidebar($sb)) sg_empty_sidebar(_sg('Sidebars')->getSidebarName($sb)); ?>
	</div>
	<div class="clear"></div>
<?php } ?>
<?php if (_sg('Page')->showLatest()) { ?>
	<?php
		query_posts('post_type=portfolio&meta_key=_thumbnail_id&posts_per_page=' . _sg('Page')->getLatestCount());
		$args = array();
		$args['post_type'] = 'portfolio';
		$args['posts_per_page'] = _sg('Page')->getLatestCount();
		$args['meta_key'] = '_thumbnail_id';
		if (_sg('Page')->getLatestCategory() != 0) {
			$args['post__in'] = get_objects_in_term(_sg('Page')->getLatestCategory(), 'portfolio_category');
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
    	                <h3><?php _sg('Page')->eLatestTitle(); ?></h3>
	                </div>
					<?php _sg('Page')->eLatestText(); ?>
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
										<?php the_post_thumbnail(_sg('Page')->showLatestEx() ? 'sg_portfolio' : 'sg_portfolio2', array('alt' => get_the_title(), 'class' => (_sg('Page')->showLatestEx() ? 'l-w' : 'l-w2'))); ?>
										<i></i>
									</div>
									<?php if (_sg('Page')->showLatestEx()) { ?>
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
<?php get_footer(); ?>