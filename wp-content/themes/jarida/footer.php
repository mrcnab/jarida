		<div class="clear"></div>
	</div><!-- .container /-->
	
	<?php tie_banner('banner_bottom' , '<div class="ads-bottom">' , '</div>' ); ?>
	</div><!-- .container -->

	<?php get_sidebar( 'footer' ); ?>				
	<div class="clear"></div>
	<div class="footer-bottom">
		<div class="container">
			<?php tie_get_social( 'yes' , 'flat' , 'ttip' , true ); ?>
			<div class="alignleft">
				<?php echo htmlspecialchars_decode(tie_get_option( 'footer_one' )) ?>
			</div>
		</div><!-- .Container -->
	</div><!-- .Footer bottom -->
	
</div><!-- .Wrapper -->
<?php if( tie_get_option('footer_top') ): ?>
	<div id="topcontrol"><?php _e('Scroll To Top' , 'tie'); ?></div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>