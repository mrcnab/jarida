<?php
	$sb = _sg('Sidebars')->getSidebar('footer');
	wp_reset_query();
?>
	</section>
    <footer id="footer-wrap">
		<div class="shine">
			<div class="inner-blank clearfix">
				<div class="top-mask"></div>
				<?php 
					if ($sb != SG_Module::USE_NONE) {
						if ($sb == SG_Module::USE_DEFAULT) {
							sg_bottom_sidebar();
						} else {
							if (!dynamic_sidebar($sb)) {
								sg_empty_sidebar(_sg('Sidebars')->getSidebarName($sb));
							}
						}
					}
				?>
			</div>
			<div class="copyr-top"></div>
			<div class="copyr-spacer">
				<div class="inner-blank clearfix">
					<a href="#" class="totop" title="To top"></a>
					<span class="float-l"><?php _sg('HandF')->eCopyright(); ?></span>
					<?php _sg('HandF')->eSocial(); ?>
				</div>
			</div>
		</div>
    </footer>
<?php sg_footer_js(); ?>
<?php wp_footer(); ?>
<?php _sg('General')->eAnalyticsCode(); ?>
<!-- Shared on http://www.MafiaShare.net --></body>
</html>