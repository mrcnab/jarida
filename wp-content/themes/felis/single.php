<?php get_header(); ?>
<?php
	$sb = _sg('Sidebars')->getSidebar('content');
?>
<?php if (sg_get_tpl() == 'our-team|default' OR sg_get_tpl() == 'extra|default') { ?>
	<?php if (have_posts()) { ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="inner clearfix">
				<div class="inner-t">
					<div class="heading bott-15">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					</div>
					<?php the_content(); ?>
				</div>
			</div>
			<div class="shady bott-27"></div>
		<?php endwhile; ?>
	<?php } else {
		echo sg_message(__('Sorry, no posts matched your criteria', SG_TDN));
	} ?>
<?php } else { ?>
	<div class="wrap720">
		<?php if (have_posts()) { ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php if (sg_get_tpl() == 'portfolio|default') { ?>
					<div class="inner clearfix">
						<div class="inner-t">
							<?php
								$img = get_the_post_thumbnail(null, 'sg_portfolio_big', array('alt' => get_the_title(), 'title' => '#htmlcaption'));
								$img_e = (empty($img)) ? FALSE : TRUE;
							?>
							<?php if (_sg('PortfolioPost')->showSlider()) { ?>
								<div class="portfolio-slider">
									<?php echo $img; ?>
									<?php _sg('PortfolioPost')->eSlider(); ?>
								</div>
							<?php } elseif ($img_e) { ?>
								<div class="portfolio-img">
									<?php echo $img; ?>
								</div>
							<?php } ?>
							<div class="heading">
								<h3><?php the_title(); ?></h3>
							</div>
							<?php the_content(); ?>
						</div>
					</div>
					<div class="shady bott-27"></div>
					<?php _sg('PortfolioPost')->eBackLink(); ?>
				<?php } else { ?>
					<div class="posts" id="post-<?php the_ID(); ?>">
						<div class="inner clearfix">
							<div class="inner-t">
								<div class="heading bott-15">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								</div>
								<?php
									if (_sg('Post')->showThumbnail()) {
										$img = get_the_post_thumbnail(null, 'sg_post_big', array('alt' => get_the_title()));
									} else {
										$img = '';
									}
									$img_e = (empty($img)) ? FALSE : TRUE;
								?>
								<?php if ($img_e) { ?>
									<div class="proj-img works1 bott-15">
										<a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="prettyPhoto zoom" title="<?php //the_title(); ?>"></a><?php echo $img; ?><i></i>
									</div>
								<?php } ?>
								<a href="<?php the_permalink(); ?>#comments" class="col1-12 null">
									<span><?php the_time('d'); ?></span>
									<span class="post-date"><?php the_time('M'); ?></span>
									<span class="num-comm"><?php echo sg_comments_count(); ?></span>
								</a>
								<div class="post">
									<p class="auth-cat"><?php _e('Posted by', SG_TDN); ?>&nbsp;<strong><?php the_author_posts_link(); ?></strong>&nbsp;<?php _e('in', SG_TDN); ?>&nbsp;<?php sg_the_category(); ?><img class="ml-10" src="<?php echo get_template_directory_uri(); ?>/images/pencil.gif" alt=""></p>
									<?php the_content(); ?>
								</div>
							</div>
						</div>
						<div class="shady bott-27"></div>
					</div>
					<?php if (_sg('Post')->showComments()) comments_template(); ?>
				<?php } ?>
			<?php endwhile; ?>
		<?php } else {
			echo sg_message(__('Sorry, no posts matched your criteria', SG_TDN));
		} ?>
	</div>
	<div class="col1-4 sidebar omega">
		<?php
			if ($sb == SG_Module::USE_DEFAULT) {
				if (sg_get_tpl() == 'portfolio|default') {
					sg_right_sidebar2();
				} else {
					sg_right_sidebar();
				}
			} else {
				if (!dynamic_sidebar($sb)) {
					sg_empty_sidebar(_sg('Sidebars')->getSidebarName($sb));
				}
			}
		?>
	</div>
<?php } ?>
<?php get_footer(); ?>