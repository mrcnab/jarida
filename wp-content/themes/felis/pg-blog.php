<?php
/* ------------------------------------------------------------------------------------------------------------
	
	Template Name: Blog
	
------------------------------------------------------------------------------------------------------------ */
?>
<?php get_header(); ?>
<?php
	$sb = _sg('Sidebars')->getSidebar('content');
	
	$prc = _sg('Blog')->getRequiredCategories();
	$args = array(
		'posts_per_page' => _sg('Blog')->getBigPostsCount() + _sg('Blog')->getPostsCount(),
		'paged' => sg_paged(),
	);
	if (!empty($prc)) $args['category__in'] = $prc;
	
	query_posts($args);
	$cur = 0;
?>
<div class="wrap720">
	<?php if (have_posts()) { ?>
		<div class="posts">
			<?php while (have_posts()) : the_post(); ?>
				<?php
					if (++$cur > _sg('Blog')->getBigPostsCount()) {
						$img = get_the_post_thumbnail(null, 'sg_post', array('alt' => get_the_title()));
						$txt_size = 80;
					} else {
						$img = get_the_post_thumbnail(null, 'sg_post_big', array('alt' => get_the_title()));
						$txt_size = 250;
					}
					$img_e = (empty($img)) ? FALSE : TRUE;
				?>
				<?php if ($cur == _sg('Blog')->getBigPostsCount() + 1) echo '<div class="small-posts-wrap">'; ?>
				<?php if ($cur > _sg('Blog')->getBigPostsCount()) echo '<div class="small-post">'; ?>
				<div class="inner<?php if ($cur <= _sg('Blog')->getBigPostsCount()) echo '  clearfix'; ?>">
                	<div class="inner-t">
                   		<div class="heading bott-15">
           					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
       					</div>
						<?php if ($img_e) { ?>
							<div class="proj-img bott-15">
								<a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="prettyPhoto zoom" title="<?php //the_title(); ?>"></a><a href="<?php the_permalink(); ?>"></a><?php echo $img; ?><i></i>
							</div>
						<?php } ?>
						<a href="<?php the_permalink(); ?>#comments" class="col1-12">
							<span><?php the_time('d'); ?></span>
							<span class="post-date"><?php the_time('M'); ?></span>
							<span class="num-comm"><?php echo sg_comments_count(); ?></span>
						</a>
						<div class="post">
							<p class="auth-cat"><?php _e('Posted by', SG_TDN); ?>&nbsp;<strong><?php the_author_posts_link(); ?></strong>&nbsp;<?php _e('in', SG_TDN); ?>&nbsp;<?php sg_the_category(); ?><img class="ml-10" src="<?php echo get_template_directory_uri(); ?>/images/pencil.gif" alt=""></p>
                    		<?php
								$txt = sg_text_trim(get_the_excerpt(), $txt_size);
								echo apply_filters('the_excerpt', $txt);
								if (substr(trim($txt), -5) == '[...]') {
							?>
							<a href="<?php the_permalink(); ?>" class="button"><span><?php _e('Read more', SG_TDN); ?><img src="<?php echo get_template_directory_uri(); ?>/images/arr.gif" alt=""></span></a>
							<?php } ?>
                    	</div>
                	</div>
            	</div>
				<div class="shady bott-27"></div>
				<?php if ($cur > _sg('Blog')->getBigPostsCount()) echo '</div>'; ?>
			<?php endwhile; ?>
			<?php if ($cur > _sg('Blog')->getBigPostsCount()) echo '</div>'; ?>
		</div>
	<?php } else {	
		echo sg_message(__('Blog is empty', SG_TDN));
	} ?>
	<?php sg_pagination($wp_query->max_num_pages); ?>
</div>
<div class="col1-4 sidebar omega">
	<?php
		if ($sb == SG_Module::USE_DEFAULT) {
			sg_right_sidebar();
		} else {
			if (!dynamic_sidebar($sb)) {
				sg_empty_sidebar(_sg('Sidebars')->getSidebarName($sb));
			}
		}
	?>
</div>
<?php get_footer(); ?>