<?php
	if (post_password_required()) {
		echo '<p class="nocomments">' . __('This post is password protected. Enter the password to view comments.', SG_TDN) . '</p>';
		return;
	}
?>

<div id="comments" class="inner-blank clearfix">
	<?php if (have_comments()){ ?>
		<div class="heading">
			<h4><?php comments_number(__('No Responses', SG_TDN), __('One Response', SG_TDN), __('% Responses', SG_TDN));?></h4>
		</div>
		<ul class="comments-list">
			<?php wp_list_comments(array('callback' => 'sg_comment')); ?>
		</ul>
		<?php sg_comments_navigation(); ?>
		<div class="divider"></div>
	<?php } ?>
	<?php sg_comment_form(); ?>
</div>