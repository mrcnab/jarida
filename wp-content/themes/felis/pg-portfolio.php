<?php
/* ------------------------------------------------------------------------------------------------------------
	
	Template Name: Portfolio
	
------------------------------------------------------------------------------------------------------------ */
?>
<?php get_header(); ?>
<?php
	$ptitle = get_the_title();
	$l = _sg('Layout')->getLayout();
	$sb = _sg('Sidebars')->getSidebar('content');
	
	$prc = _sg('Portfolio')->getRequiredCategories();
	$args = array(
		'post_type' => 'portfolio',
		'posts_per_page' => _sg('Portfolio')->getPostsCount(),
		'paged' => sg_paged(),
	);
	if (!empty($prc)) $args['post__in'] = get_objects_in_term($prc, 'portfolio_category');
	
	if (isset($_GET['pcategory']) AND $l != 'portfolio_a') {
		$args['post__in'] = get_objects_in_term($_GET['pcategory'], 'portfolio_category');
	}
	
	query_posts($args);
	$max_num_pages = $wp_query->max_num_pages;
?>
<?php if ($l == 'portfolio_a') { ?>
	<div class="wrap720">
		<?php if (have_posts()) { ?>
			<div class="inner clearfix">
				<div class="inner-t">
					<div class="heading">
						<h3><?php echo $ptitle; ?></h3>
					</div>
					<ul class="accordion works1">
						<?php while (have_posts()) : the_post(); ?>
							<li>
								<a class="title" href="#"><strong><?php the_title(); ?></strong><span class="acc-arr"></span></a>
								<ul>
									<li>
										<?php
											$img = get_the_post_thumbnail(null, 'sg_portfolio_big', array('alt' => get_the_title()));
											$img_e = (empty($img)) ? FALSE : TRUE;
										?>
										<?php if ($img_e) { ?>
											<div class="proj-img works1 bott-15">
												<a href="<?php the_permalink(); ?>"></a><?php echo $img; ?><i></i>
											</div>
										<?php } ?>
										<?php
											$txt = sg_text_trim(get_the_excerpt(), 400);
											echo apply_filters('the_excerpt', $txt);
											if (substr(trim($txt), -5) == '[...]') {
										?>
											<a href="<?php the_permalink(); ?>" class="button"><span><?php _e('More', SG_TDN); ?><img src="<?php echo get_template_directory_uri(); ?>/images/arr.gif" alt=""></span></a>
										<?php } ?>
									</li>
								</ul>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
			<div class="shady bott-27"></div>
		<?php } else {
			echo sg_message(__('Portfolio is empty', SG_TDN));
		} ?>
		<?php sg_pagination($max_num_pages); ?>
	</div>
	<div class="col1-4 sidebar omega">
		<?php
			if ($sb == SG_Module::USE_DEFAULT) {
				sg_right_sidebar2();
			} else {
				if (!dynamic_sidebar($sb)) {
					sg_empty_sidebar(_sg('Sidebars')->getSidebarName($sb));
				}
			}
		?>
	</div>
<?php } else { ?>
	<?php if (have_posts()) { ?>
		<?php
			$cur = 0;
			$prj = array();
		?>
		<div id="works2-container">
			<?php if ($l == 'portfolio_3a') { ?>
				<div id="big-showcase">
					<div class="inner clearfix">
						<div class="works2-nav">
							<div class="col1-3">
								<span class="works2-close"></span>
							</div>
							<div id="sg-portfolio-prev-next" class="col2-3 omega">
								<span class="works2-prev"></span>
								<span class="works2-next"></span>
							</div>
						</div>
						<div class="inner-t">
							<script type="text/javascript">sg_big_portfolio_imgs = new Array();</script>
							<ul>
								<?php while (have_posts()) : the_post(); ?>
									<li class="portf-<?php echo ++$cur; ?>">
										<div class="col1-3">
											<div class="heading">
												<h3><?php the_title(); ?></h3>
											</div>
											<?php
												$txt = sg_text_trim(get_the_excerpt(), 450);
												echo apply_filters('the_excerpt', $txt);
												if (substr(trim($txt), -5) == '[...]') {
											?>
												<a href="<?php the_permalink(); ?>" class="button"><span><?php _e('More', SG_TDN); ?><img src="<?php echo get_template_directory_uri(); ?>/images/arr.gif" alt=""></span></a>
											<?php } ?>
										</div>
										<div class="col2-3 omega add-imgs">
											<?php
												$img = get_the_post_thumbnail(null, 'sg_portfolio_big2', array('alt' => get_the_title(), 'title' => '#htmlcaption'));
												$img_e = (empty($img)) ? FALSE : TRUE;
											?>
											<?php if (_sg('PortfolioPost', TRUE)->showSlider(get_the_ID())) { ?>
												<script type="text/javascript">sg_big_portfolio_imgs['<?php echo $cur; ?>'] = '<div class="portfolio-slider"><?php echo $img; _sg('PortfolioPost', TRUE)->eSlider(get_the_ID()); ?></div>';</script>
											<?php } elseif ($img_e) { ?>
												<script type="text/javascript">sg_big_portfolio_imgs['<?php echo $cur; ?>'] = '<div class="portfolio-img"><?php echo $img; ?></div>';</script>
											<?php } ?>
										</div>
									</li>
									<?php
										$prj[$cur] = array();
										$prj[$cur]['id'] = get_the_ID();

										if ($img_e) {
											$prj[$cur]['html'] = '<div class="proj-img works2">';
												$prj[$cur]['html'] .= '<a class="more-info" href="#"></a>' . get_the_post_thumbnail(NULL, 'sg_portfolio', array('alt' => get_the_title(), 'class' => 'l-w')) . '<i></i>';
											$prj[$cur]['html'] .= '</div>';
										}

										$prj[$cur]['html'] .= '<div class="descr">';
											$prj[$cur]['html'] .= '<h5><a href="' . get_permalink() . '">' . sg_text_trim(get_the_title(), 30) . '</a></h5>';
											$prj[$cur]['html'] .= apply_filters('the_excerpt', sg_text_trim(get_the_excerpt(), 35));
										$prj[$cur]['html'] .= '</div>';
									?>
								<?php endwhile; ?>
							</ul>
							<script type="text/javascript">sg_last_portfolio_id = <?php echo $cur; ?>;</script>
						</div>
					</div>
					<div class="shady bott-27"></div>
				</div>
				<?php } else {
					while (have_posts()) : the_post();
						$prj[++$cur] = array();
						$prj[$cur]['id'] = get_the_ID();

						$img = get_the_post_thumbnail(NULL, 'sg_portfolio', array('alt' => get_the_title(), 'class' => 'l-w'));
						$img_e = (empty($img)) ? FALSE : TRUE;

						if ($img_e) {
							$prj[$cur]['html'] = '<div class="proj-img">';
								$prj[$cur]['html'] .= '<a href="' . wp_get_attachment_url(get_post_thumbnail_id()) . '" class="prettyPhoto zoom" title=""></a><a class="more-info-href" href="' . get_permalink() . '"></a>' . $img . '<i></i>';
							$prj[$cur]['html'] .= '</div>';
						}

						$prj[$cur]['html'] .= '<div class="descr">';
							$prj[$cur]['html'] .= '<h5><a href="' . get_permalink() . '">' . sg_text_trim(get_the_title(), 30) . '</a></h5>';
							$prj[$cur]['html'] .= apply_filters('the_excerpt', sg_text_trim(get_the_excerpt(), 35));
						$prj[$cur]['html'] .= '</div>';
					endwhile;
				} ?>
            <?php
				wp_reset_query();
				$tags = get_terms('portfolio_category');
				$topt = array();

				foreach ($tags as $tag) {
					if (empty($prc)) {
						$topt[$tag->term_id] = $tag->name;
					} elseif (in_array($tag->term_id, $prc)) {
						$topt[$tag->term_id] = $tag->name;
					}
				}
				
				$pcurr = 0;
				if (isset($_GET['pcategory']) AND array_key_exists($_GET['pcategory'], $topt)) $pcurr = $_GET['pcategory'];
				$purl = get_permalink(get_the_ID());
				$purlsep = (strpos($purl, '?') > 0) ? '&' : '?';
			?>
            <ul class="portfolio-filter filter">
            	<li class="all-projects<?php echo ($pcurr == 0 ? ' curr' : ''); ?>"><a href="<?php echo $purl; ?>"><?php _e('All works', SG_TDN) ?></a></li>
				<?php
					foreach ($topt as $id => $name) {
						echo '<li class="' . str_replace(' ', '-', strtolower($name)) . ($pcurr == $id ? ' curr' : '') . '"><a href="' . $purl . $purlsep . 'pcategory=' . $id . '">' . $name . '</a></li>';
					}
				?>
            </ul>
			
			<div class="inner clearfix">
                <div class="inner-t">
                    <div id="works2">
						<?php foreach ($prj as $id => $prj_opt) { ?>
							<div class="col1-3" data-id="<?php echo $id; ?>" data-type="<?php sg_the_portfolio_category($prj_opt['id']); ?>">
								<div class="item-holder">
									<?php echo $prj_opt['html']; ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="shady bott-27"></div>
	<?php } else {
		echo sg_message(__('Portfolio is empty', SG_TDN));
	} ?>
	<?php sg_pagination($max_num_pages); ?>
<?php } ?>
<?php get_footer(); ?>