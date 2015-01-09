<?php 
	if (isset($_GET['s']) AND empty($_GET['s'])) {
		wp_redirect(home_url()); exit;
	} 
?>
<?php get_header(); ?>
    <div class="block">
		<div class="space6">
			<h1 class="heads space4">Thank you for purchasing Felis WP!</h1>
			<img class="alignleft" src="<?php echo get_template_directory_uri(); ?>/images/scr1.jpg" alt="" />
			<div class="index-right">
				<p class="space4">To enjoy the flexibility and customizability of this theme you need to create a new page which is going to be the homepage. Don't worry if this is the first time you're creating a page to be your homepage using 'Home' template. It's easy, just look on the screenshot! That's all you need to start setting up the theme!</p>
				<hr style="clear:none;">
				<p class="space">Then you have to go to 'Theme Options' and set a global theme settings. Please read the manual to satisfy all your needs.</p>		
			</div>
		</div>
	</div>
<?php get_footer(); ?>