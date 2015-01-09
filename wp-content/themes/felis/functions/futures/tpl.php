<?php

require_once TEMPLATEPATH . '/functions/futures/core.php';

function sg_the_category($echo = TRUE)
{
	$categories = get_the_terms(NULL, 'category');
	if (! $categories)
		$categories = array();

	$categories = array_values($categories);
	$categories = apply_filters('get_the_categories', $categories);
	
	if (!empty($categories)) {
		$category = $categories[0];
		$category_link = get_category_link($category->term_id);
		if (!$echo)	return '<a href="' . $category_link . '" class="clr-link">' . $category->name . '</a>';
		echo '<a href="' . $category_link . '" class="clr-link">' . $category->name . '</a>';
	}
}

function sg_the_portfolio_category($id = false, $echo = TRUE) {
	$categories = get_the_terms($id, 'portfolio_category');
	if (!$categories)
		$categories = array();

	$categories = array_values($categories);
	$cats = array();

	foreach (array_keys($categories) as $key) {
		$cats[] = str_replace(' ', '-', strtolower($categories[$key]->name));
	}
	
	if (!$echo) return implode(' ', $cats);
	echo implode(' ', $cats);
}

function sg_the_title()
{
	$title = get_the_title();
	
	if (is_category()) {
		$title = sprintf(__('%s Category', SG_TDN), single_cat_title());
	} elseif (is_day()) {
		$title = sprintf(__('Archive for %s', SG_TDN), get_the_time('d M, Y'));
	} elseif (is_month()) {
		$title = sprintf(__('Archive for %s', SG_TDN), get_the_time('M, Y'));
	} elseif (is_year()) {
		$title = sprintf(__('Archive for %s', SG_TDN), get_the_time('Y'));
	} elseif (is_search()) {
		$title = __('Search Results', SG_TDN);
	} elseif (is_author()) {
		$title = __('Author Archive', SG_TDN);
	} elseif (is_archive()) {
		if (sg_term() == 'portfolio') {
			$title = __('Portfolio Archive', SG_TDN);
		} else {
			$title = __('Blog Archive', SG_TDN);
		}
	} elseif (is_attachment()) {
		$title = __('Attachment', SG_TDN);
	} elseif (is_404()) {
		$title = __('404 - File Not Found', SG_TDN);
	} elseif (is_home()) {
		$title = __('Hello!!!', SG_TDN);
	}
	
	echo $title;
}

function sg_the_meta_title()
{
	echo '<title>';
		bloginfo('name');
		echo ' :: ';
		sg_the_title();
	echo '</title>';
}

function sg_breadcrumbs()
{
	global $post;
	$sep = '<img class="separator" alt="" src="' . get_template_directory_uri() . '/images/breadcramp-arr.gif" />';
	$front = get_option('page_on_front');
	$bpages = array();
	$ppages = array();
	
	echo '<div class="breadcramp float-l">';
	echo '<p>' . __('You are here:', SG_TDN) . '</p>';
	echo '<span>';
		echo '<a href="' . home_url() . '">' . __('Home', SG_TDN) . '</a>';
		
		if (is_page() && $post->post_parent) {
			$anc = get_post_ancestors($post->ID);
			$anc = array_reverse($anc);
			foreach ($anc as $ancestor) {
				if ($ancestor != $front) {
					echo $sep . '<a href="'.get_permalink($ancestor).'">'.get_the_title($ancestor).'</a>';
				}
			}
		}
		
		if (is_archive() OR is_author() OR is_date() OR is_single()) {
			$get_posts = new WP_Query;
			$pages = $get_posts->query('post_type=page&posts_per_page=-1');
			foreach ($pages as $page) {
				$post_custom = get_post_custom($page->ID);
				if ($post_custom['_wp_page_template'][0] == 'pg-blog.php') {
					$bpages[] = $page->ID;
				}
				if ($post_custom['_wp_page_template'][0] == 'pg-portfolio.php') {
					$ppages[] = $page->ID;
				}
			}
		}
		
		if (sg_term() == 'portfolio') {
			if (isset($ppages[0]) AND $ppages[0] != $front) {
				echo $sep . '<a href="'.get_permalink($ppages[0]).'">'.get_the_title($ppages[0]).'</a>';
			} elseif (isset($bpages[1]) AND $bpages[1] != $front) {
				echo $sep . '<a href="'.get_permalink($ppages[1]).'">'.get_the_title($ppages[1]).'</a>';
			}
		} elseif (is_archive() OR is_author() OR is_date()) {
			if (isset($bpages[0]) AND $bpages[0] != $front) {
				echo $sep . '<a href="'.get_permalink($bpages[0]).'">'.get_the_title($bpages[0]).'</a>';
			} elseif (isset($bpages[1]) AND $bpages[1] != $front) {
				echo $sep . '<a href="'.get_permalink($bpages[1]).'">'.get_the_title($bpages[1]).'</a>';
			}
		}
		
		if (is_single()) {
			if(get_post_type() == 'post') {
				if (isset($bpages[0]) AND $bpages[0] != $front) {
					echo $sep . '<a href="'.get_permalink($bpages[0]).'">'.get_the_title($bpages[0]).'</a>';
				} elseif (isset($bpages[1]) AND $bpages[1] != $front) {
					echo $sep . '<a href="'.get_permalink($bpages[1]).'">'.get_the_title($bpages[1]).'</a>';
				}
				echo $sep;
				sg_the_category();
			} elseif (get_post_type() == 'portfolio') {
				if (isset($ppages[0]) AND $ppages[0] != $front) {
					echo $sep . '<a href="'.get_permalink($ppages[0]).'">'.get_the_title($ppages[0]).'</a>';
				} elseif (isset($ppages[1]) AND $ppages[1] != $front) {
					echo $sep . '<a href="'.get_permalink($ppages[1]).'">'.get_the_title($ppages[1]).'</a>';
				}
			}
		}
		
		echo $sep;
		sg_the_title();
	echo '</span>';
	echo '</div>';
}

function sg_right_sidebar()
{
	$opt1 = array(
			'before_widget' => '<div id="dr-categories" class="widget_categories bott-27">',
			'after_widget' => '</div>',
			'before_title' => '<div class="heading"><h5>',
			'after_title' => '</h5></div>'
		);
	$opt2 = array(
			'before_widget' => '<div id="dr-archives" class="widget_archive bott-27">',
			'after_widget' => '</div>',
			'before_title' => '<div class="heading"><h5>',
			'after_title' => '</h5></div>'
		);
	$opt3 = array(
			'before_widget' => '<div id="dr-tag_cloud" class="widget_tag_cloud bott-27">',
			'after_widget' => '</div>',
			'before_title' => '<div class="heading"><h5>',
			'after_title' => '</h5></div>'
		);

	the_widget('WP_Widget_Categories', '', $opt1);
	the_widget('WP_Widget_Archives', '', $opt2);
	the_widget('WP_Widget_Tag_Cloud', '', $opt3);
}

function sg_right_sidebar2()
{
	$opt1 = array(
			'before_widget' => '<div id="dr-portfolio-categories" class="widget_portfolio_categories bott-27">',
			'after_widget' => '</div>',
			'before_title' => '<div class="heading"><h5>',
			'after_title' => '</h5></div>'
		);
	$opt2 = array(
			'before_widget' => '<div id="dr-portfolio-tag_cloud" class="widget_portfolio_tag_cloud bott-27">',
			'after_widget' => '</div>',
			'before_title' => '<div class="heading"><h5>',
			'after_title' => '</h5></div>'
		);

	the_widget('SG_Widget_Portfolio_Categories', '', $opt1);
	the_widget('SG_Widget_Portfolio_Tag_Cloud', '', $opt2);
}

function sg_bottom_sidebar()
{
	$opt1 = array(
		'before_widget' => '<div id="df-sg-contacts" class="contacts col1-4">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '<img src="' . get_template_directory_uri() . '/images/heading-bg-footer.gif" alt=""></h4>'
	);
	$opt2 = array(
		'before_widget' => '<div id="df-recent-posts" class="widget_recent_entries col1-4">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '<img src="' . get_template_directory_uri() . '/images/heading-bg-footer.gif" alt=""></h4>'
	);
	$opt3 = array(
		'before_widget' => '<div id="df-categories" class="widget_categories col1-4">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '<img src="' . get_template_directory_uri() . '/images/heading-bg-footer.gif" alt=""></h4>'
	);
	$opt4 = array(
		'before_widget' => '<div id="df-text" class="widget_text col1-4">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '<img src="' . get_template_directory_uri() . '/images/heading-bg-footer.gif" alt=""></h4>'
	);

	the_widget('SG_Widget_Contact', _sg('HandF')->getContactUsSettings(), $opt1);
	the_widget('WP_Widget_Recent_Posts', NULL, $opt2);
	the_widget('WP_Widget_Categories', NULL, $opt3);
	the_widget('WP_Widget_Text', _sg('HandF')->getImportantSettings(), $opt4);
}

function sg_pagination($max)
{
	if ($max > 1) {
		$paged = sg_paged();
?>
	<div class="portfolio-pagn">
		<span><a href="<?php echo get_pagenum_link(); ?>"<?php echo ($paged == 1) ? ' class="page-active"' : '' ?>>1</a></span>
		<?php 
			echo ($paged > 7) ? '<span><-</span>' : '';
			for ($i = ($paged - 5); $i < ($paged + 6); $i++) {
				if ($i > 1 AND $i < $max) {
		?>
		<span><a href="<?php echo get_pagenum_link($i); ?>"<?php echo ($paged == $i) ? ' class="page-active"' : '' ?>><?php echo $i; ?></a></span>
		<?php
				}
			}
			echo ($paged < ($max - 6)) ? '<span>-></span>' : '';
		?>
		<span><a href="<?php echo get_pagenum_link($max); ?>"<?php echo ($paged == $max) ? ' class="page-active"' : '' ?>><?php echo $max; ?></a></span>
	</div>
<?php
	}
}

function sg_navigation($type)
{
?>
	<span class="float-r page-nav">
	<?php 
		if ($type == 'title') {
			previous_post_link('<span class="prev-pg">%link</span>');
			next_post_link('<span class="next-pg ml-10">%link</span>');
		} elseif ($type == 'yes') {
			if (sg_get_tpl() == 'post|default') {
				$prev = __('Previous post', SG_TDN);
				$next = __('Next post', SG_TDN);
			} elseif (sg_get_tpl() == 'portfolio|default') {
				$prev = __('Previous work', SG_TDN);
				$next = __('Next work', SG_TDN);
			} else {
				$prev = __('Previous page', SG_TDN);
				$next = __('Next page', SG_TDN);
			}
			previous_post_link('<span class="prev-pg">%link</span>', $prev);
			next_post_link('<span class="next-pg ml-10">%link</span>', $next);
		}
	?>
	</span>
<?php
}

function sg_comments_navigation()
{
	if (!get_option('page_comments')) return;
?>
	<div id="pagination-comments">
		<span class="float-r page-nav">
			<?php previous_comments_link('<span id="first-pg">' . __('<- Older Comments', SG_TDN) . '</span>'); ?>
			<?php next_comments_link('<span id="last-pg">' . __('Newer Comments ->', SG_TDN) . '</span>'); ?>
		</span>
	</div>
<?php
}

function sg_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	$autor_url = get_comment_author_url();
	$autor_url = empty($autor_url) ? '#comment-' . get_comment_ID() : $autor_url;
	$autor_url = '<a class="avatar float-l" href="' . $autor_url . '">'. get_avatar($comment, 60) . '</a>';
?>
	<li>
		<?php echo $autor_url; ?>
		<div <?php comment_class('post'); ?> id="comment-<?php comment_ID(); ?>">
			<p><span><strong><?php comment_author_link(); ?></strong></span><img src="<?php echo get_template_directory_uri(); ?>/images/auth-arr.gif" alt=""><?php printf(__('%1$s at %2$s', SG_TDN), get_comment_date('F d, Y'), get_comment_time()); ?>&nbsp;<?php edit_comment_link(__('(Edit)', SG_TDN), ' '); ?></p>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', SG_TDN); ?></em><br />
			<?php endif; ?>
			<?php comment_text(); ?>
			<?php 
				$reply_text = '<span>' . __('Reply', SG_TDN) . '<img src="' . get_template_directory_uri() . '/images/repl.png" alt=""></span>';
				$login_text = '<span>' . __('Log in to Reply', SG_TDN) . '<img src="' . get_template_directory_uri() . '/images/repl.png" alt=""></span>';
			?>
			<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => $reply_text, 'login_text' => $login_text))); ?>
		</div>
<?php
}

function sg_comment_form( $args = array(), $post_id = null )
{
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = ! empty( $user->ID ) ? $user->display_name : '';

	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');
	$aria_req_l = ($req ? '*' : '');
	$fields =  array(
		'author' => '<div><label>' . __('Name', SG_TDN) . $aria_req_l . '</label><input id="name" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
		'email'  => '<div><label>' . __('E-mail', SG_TDN) . $aria_req_l . '</label><input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
		'url'    => '<div><label>' . __('Website', SG_TDN) . '</label><input id="website" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>',
	);

	$required_text = '<span class="float-r">' . __('* required', SG_TDN) . '</span>';
	$defaults = array(
		'fields'               => apply_filters('comment_form_default_fields', $fields),
		'comment_field'        => '<div><textarea id="message" name="comment" aria-required="true"></textarea></div>',
		'must_log_in'          => '<p class="must-log-in">' .  sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', SG_TDN), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', SG_TDN), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => ( $req ? $required_text : '' ),
		'id_form'              => 'reply',
		'id_submit'            => 'send',
		'title_reply'          => __('Leave a comment', SG_TDN),
		'title_reply_to'       => __('Leave a Reply to %s', SG_TDN),
		'cancel_reply_link'    => __('(Cancel reply)', SG_TDN),
		'label_submit'         => __('Post Comment', SG_TDN),
	);

	$args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));

	?>
		<?php if ( comments_open() ) : ?>
			<?php do_action('comment_form_before'); ?>
			<div id="respond"<?php echo ((is_user_logged_in()) ? ' class="respond-logged"' : ''); ?>>
				<div class="heading bg-none" id="reply-title">
					<h4><?php comment_form_title($args['title_reply'], $args['title_reply_to']); ?> <small><?php cancel_comment_reply_link($args['cancel_reply_link']); ?></small></h4>
				</div>
				<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action('comment_form_must_log_in_after'); ?>
				<?php else : ?>
					<form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" id="<?php echo esc_attr($args['id_form']); ?>">
						<?php do_action('comment_form_top'); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity); ?>
							<?php do_action('comment_form_logged_in_after', $commenter, $user_identity); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action('comment_form_before_fields');
							foreach ((array) $args['fields'] as $name => $field) {
								echo apply_filters("comment_form_field_{$name}", $field) . "\n";
							}
							do_action('comment_form_after_fields');
							?>
						<?php endif; ?>
						<?php echo apply_filters('comment_form_field_comment', $args['comment_field']); ?>
						<div class="send-wrap">
							<div class="button float-l">
								<input name="submit" type="submit" id="<?php echo esc_attr($args['id_submit']); ?>" value="<?php echo esc_attr($args['label_submit']); ?>" />
							</div>
							<?php echo $args['comment_notes_after']; ?>
							<?php comment_id_fields( $post_id ); ?>
						</div>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php do_action('comment_form_after'); ?>
		<?php else : ?>
			<?php do_action('comment_form_comments_closed'); ?>
		<?php endif; ?>
	<?php
}

function sg_header_css()
{
	wp_register_style('PT-Sans', 'http://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&amp;subset=latin,latin-ext,cyrillic', false);
	wp_register_style('reset-style', get_template_directory_uri() . '/css/reset.css', false);
	wp_register_style('normalize-style', get_template_directory_uri() . '/css/normalize.css', false);
	wp_register_style('theme-style', get_template_directory_uri() . '/css/style.css', false);
	wp_register_style('shortcodes', get_template_directory_uri() . '/css/shortcodes.css', false);
	wp_register_style('ie7-style', get_template_directory_uri() . '/css/ie7.css', false);
	wp_register_style('style', get_stylesheet_uri(), false);
	
	wp_register_style('nivo-slider', get_template_directory_uri() . '/js/nivo/nivo-slider.css', false);
	wp_register_style('prettyPhoto', get_template_directory_uri() . '/js/pretty/prettyPhoto.css', false);
	wp_register_style('tipSwift', get_template_directory_uri() . '/js/tipSwift/tipSwift.css', false);
	wp_register_style('jFlickr', get_template_directory_uri() . '/js/jFlickr/jflickr_css/style.css', false, '0.3');
	
	wp_enqueue_style('PT-Sans');
	wp_enqueue_style('reset-style');
	wp_enqueue_style('normalize-style');
	wp_enqueue_style('theme-style');
	wp_enqueue_style('shortcodes');
	wp_enqueue_style('style');
	
	global $wp_styles;
	$wp_styles->add_data('ie7-style', 'conditional', 'lte IE 7');
	
	wp_enqueue_style('nivo-slider');
	wp_enqueue_style('prettyPhoto');
	wp_enqueue_style('tipSwift');
	wp_enqueue_style('jFlickr');
}

function sg_header_js()
{
?>
	<script type="text/javascript">sg_template_url = "<?php echo get_template_directory_uri(); ?>";</script>
<?php
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.7.1.min.js', false, '1.7.1');
	wp_register_script('sg-jquery-ui', get_template_directory_uri() . '/js/jquery-ui-1.8.16.custom.min.js', false, '1.8.16');
	wp_register_script('jquery.effects.core', get_template_directory_uri() . '/js/jquery.effects.core.js', false);
	wp_register_script('jquery.easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', false, '1.3');
	wp_register_script('jquery.quicksand', get_template_directory_uri() . '/js/quicksand/jquery.quicksand.js', false, '1.2.2');
	wp_register_script('jquery.preloader', get_template_directory_uri() . '/js/jPreloader/jquery.preloader.js', false);
	wp_register_script('jquery.nivo.slider', get_template_directory_uri() . '/js/nivo/jquery.nivo.slider.js', false);
	wp_register_script('jquery.flow', get_template_directory_uri() . '/js/content-slider/jquery.flow.1.2.js', false, '1.2');
	wp_register_script('jquery.prettyPhoto', get_template_directory_uri() . '/js/pretty/jquery.prettyPhoto.js', false);
	wp_register_script('jquery.scrollTo', get_template_directory_uri() . '/js/scrollTo/jquery.scrollTo-min.js', false);
	wp_register_script('jquery.tweet', get_template_directory_uri() . '/js/tweet/jquery.tweet.js', false);
	wp_register_script('jFlickr', get_template_directory_uri() . '/js/jFlickr/jflickr_js/jflickr_0.3_min.js', false, '0.3');
	wp_register_script('tipSwift', get_template_directory_uri() . '/js/tipSwift/tipSwift.js', false);
	wp_register_script('cufon-yui', get_template_directory_uri() . '/js/cufon/cufon-yui.js', false);
	wp_register_script('generated-fonts', get_template_directory_uri() . '/js/cufon/generated-fonts.js', false);
	wp_register_script('felis-form', get_template_directory_uri() . '/js/felis-form.js', false);
	wp_register_script('sg-height', get_template_directory_uri() . '/js/column-height.js', false);
	wp_register_script('sg-maps-api', 'http://maps.google.com/maps/api/js?v=3.5&amp;sensor=false', false);
	wp_register_script('sg-maps-markermanager', get_template_directory_uri() . '/js/maps/vendor/markermanager.js', false);
	wp_register_script('sg-maps-StyledMarker', get_template_directory_uri() . '/js/maps/vendor/StyledMarker.js', false);
	wp_register_script('jquery.metadata', get_template_directory_uri() . '/js/maps/vendor/jquery.metadata.js', false);
	wp_register_script('jquery.jmapping', get_template_directory_uri() . '/js/maps/jquery.jmapping.js', false);
	wp_register_script('sg-custom', get_template_directory_uri() . '/js/custom.js', false);
	wp_register_script('sg-quicksand-run', get_template_directory_uri() . '/js/quicksand/run.js', false);
	wp_register_script('sg-html5', get_template_directory_uri() . '/js/html5.js', false);
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('sg-jquery-ui');
	wp_enqueue_script('jquery.effects.core');
	wp_enqueue_script('jquery.easing');
	wp_enqueue_script('jquery.preloader');
	wp_enqueue_script('jquery.nivo.slider');
	wp_enqueue_script('jquery.flow');
	wp_enqueue_script('jquery.prettyPhoto');
	wp_enqueue_script('jquery.scrollTo');
	wp_enqueue_script('jquery.tweet');
	wp_enqueue_script('jFlickr');
	wp_enqueue_script('tipSwift');
	wp_enqueue_script('cufon-yui');
	wp_enqueue_script('generated-fonts');
	wp_enqueue_script('sg-height');

	if (sg_get_tpl() == 'page|contact') {
		wp_enqueue_script('felis-form');
		wp_enqueue_script('sg-maps-api');
		wp_enqueue_script('sg-maps-markermanager');
		wp_enqueue_script('sg-maps-StyledMarker');
		wp_enqueue_script('jquery.metadata');
		wp_enqueue_script('jquery.jmapping');
	}
	
	if (sg_get_tpl() == 'page|portfolio' AND _sg('Layout')->getLayout() != 'portfolio_a' AND _sg('Portfolio')->getPostsCount() == -1) {
		wp_enqueue_script('jquery.quicksand');
		wp_enqueue_script('sg-quicksand-run');
	}
	
	if (is_singular() AND _sg('Post')->showComments() AND get_option('thread_comments')) {
		wp_enqueue_script('felis-form');
		wp_enqueue_script('comment-reply');
	}
	
	wp_enqueue_script('sg-custom');
	wp_enqueue_script('sg-html5');
}

function sg_footer_js()
{
?>
	<script type="text/javascript">
//<![CDATA[
	Cufon.now();
//]]>
	</script>
<?php
}

function sg_header_meta()
{
	if (_sg('Modules')->enabled('SEO') ) {
		if (!_sg('SEO')->eTitle()) sg_the_meta_title();
		if (sg_get_tpl() == 'post|default' OR sg_get_tpl() == 'portfolio|default') {
			$pt = array();
			$term = (sg_get_tpl() == 'post|default') ? 'post_tag' : 'portfolio_tag';
			$tags = get_the_terms(NULL, $term);
			if (empty($tags)) $tags = array();
			
			foreach ($tags as $id => $tag) {
				$pt[] = $tag->name;
			}
			
			_sg('SEO')->setPostTags($pt);
		}
		_sg('SEO')->eMeta();
	} else {
		sg_the_meta_title();
	}
}