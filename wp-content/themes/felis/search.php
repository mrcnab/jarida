<?php get_header(); ?>
<div class="wrap720">
	<?php if (have_posts()) { ?>
		<div class="posts">
			<div class="small-posts-wrap">
				<?php while (have_posts()) : the_post(); ?>
					<?php
						$img = get_the_post_thumbnail(null, 'sg_post', array('alt' => get_the_title()));
						$img_e = (empty($img)) ? FALSE : TRUE;
					?>
					<div class="small-post">
						<div class="inner">
							<div class="inner-t">
								<div class="heading bott-15">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								</div>
								<?php if ($img_e) { ?>
									<div class="proj-img bott-15">
										<a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="prettyPhoto zoom" title="<?php //the_title(); ?>"></a><a href="<?php the_permalink(); ?>"></a><?php echo $img; ?><i></i>
									</div>
								<?php } ?>
								<?php
									$txt = sg_text_trim(get_the_excerpt(), 80);
									echo apply_filters('the_excerpt', $txt);
									if (substr(trim($txt), -5) == '[...]') {
								?>
									<a href="<?php the_permalink(); ?>" class="button"><span><?php _e('Read more', SG_TDN); ?><img src="<?php echo get_template_directory_uri(); ?>/images/arr.gif" alt=""></span></a>
								<?php } ?>
							</div>
						</div>
						<div class="shady bott-27"></div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php } else {
		echo sg_message(__('Not Found', SG_TDN));
	} ?>
	<?php sg_pagination($wp_query->max_num_pages); ?>
</div>
<div class="col1-4 sidebar omega">
	<?php
		sg_right_sidebar();
		sg_right_sidebar2();
	?>
</div>
<?php get_footer(); ?>