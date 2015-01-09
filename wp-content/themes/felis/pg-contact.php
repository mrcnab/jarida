<?php
/* ------------------------------------------------------------------------------------------------------------
	
	Template Name: Contact Us
	
------------------------------------------------------------------------------------------------------------ */
?>
<?php get_header(); ?>
<?php
	the_post();
	$sb = _sg('Sidebars')->getSidebar('content');
?>
<div class="wrap720">
	<div class="posts">
		<div class="inner clearfix">
			<div class="inner-t">
				<?php if (_sg('Contact')->showMap()) { ?>
					<?php _sg('Contact')->eMap(); ?>
				<?php } ?>
				<?php wp_reset_query(); the_content();?>
			</div>
		</div>
		<div class="shady bott-27"></div>
	</div>
	<div class="inner-blank clearfix">
		<?php if (_sg('Contact')->showForm()) { ?>
			<div class="heading bg-none">
		        <h4><?php _sg('Contact')->eFormTitle(); ?></h4>
			</div>
			<form id="contact" method="post" action="<?php echo get_template_directory_uri(); ?>/includes/contact-send.php">
				<input type="hidden" name="sg_post_id" value="<?php the_ID(); ?>" />
				<div>
					<label><?php _e('Name', SG_TDN); ?>*</label><input id="name" type="text" aria-required="true" name="sg_ct_name" value="" />
				</div>
				<div>
					<label><?php _e('E-mail', SG_TDN); ?>*</label><input id="email" type="text" aria-required="true" name="sg_ct_email" value="" />
				</div>
				<div>
					<label><?php _e('Website', SG_TDN); ?></label><input id="website" type="text" name="sg_ct_website" value="" />
				</div>
				<div>
					<textarea id="message" name="sg_ct_message" cols="" rows=""></textarea>
				</div>
				<div class="send-wrap">
					<div class="button float-l">
						<input id="send" name="submit" type="submit" value="Send" />
					</div>
					<div class="float-r"><?php _e('* required', SG_TDN); ?></div>
				</div>
			</form>
		<?php } ?>
	</div>
</div>
<div class="col1-4 sidebar omega">
	<?php if (_sg('Contact')->getTitle()) { ?>
		<div class="bott-27">
			<div class="heading">
				<h5><?php echo _sg('Contact')->getTitle(); ?></h5>
			</div>
			<div class="contact-info">
				<div><?php if (_sg('Contact')->getAddress()) { ?>
					<div><?php _e('Address:', SG_TDN); ?></div><p><strong><?php echo _sg('Contact')->getAddress(); ?></strong></p>
				<?php } ?></div>
				<div><?php if (_sg('Contact')->getPhone()) { ?>
					<div><?php _e('Phone:', SG_TDN); ?></div><p><strong><?php echo _sg('Contact')->getPhone(); ?></strong></p>
				<?php } ?></div>
				<div><?php if (_sg('Contact')->getFax()) { ?>
					<div><?php _e('Fax:', SG_TDN); ?></div><p><strong><?php echo _sg('Contact')->getFax(); ?></strong></p>
				<?php } ?></div>
				<div><?php if (_sg('Contact')->getFree()) { ?>
					<div><?php _e('Toll Free:', SG_TDN); ?></div><p><strong><?php echo _sg('Contact')->getFree(); ?></strong></p>
				<?php } ?></div>
			</div>
		</div>
	<?php } ?>
	<?php if ($sb != SG_Module::USE_NONE AND !dynamic_sidebar($sb)) sg_empty_sidebar(_sg('Sidebars')->getSidebarName($sb)); ?>
</div>
<?php get_footer(); ?>