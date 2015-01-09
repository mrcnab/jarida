<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post not-found post-listing">
		<h1 class="post-title"><?php _e( 'Not Found', 'tie' ); ?></h1>
		<div class="entry">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'tie' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>

<?php else : ?>
<div class="post-listing">
<?php while ( have_posts() ) : the_post(); ?>
<?php if( tie_get_option( 'blog_display' ) != 'full_thumb' ): ?>
	<article class="item-list">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<p class="post-meta">
			<?php tie_get_time() ?>
			<span class="post-comments"><?php comments_popup_link( __( '0', 'tie' ), __( '1 Comment', 'tie' ), __( '% Comments', 'tie' ) ); ?></span>
			<?php echo tie_views(); ?>
		</p>
		
		<?php if( tie_get_option( 'blog_display' ) == 'content' ): ?>
		<div class="entry">
			<?php the_content( __( 'Read More &raquo;', 'tie' ) ); ?>
		</div>
		<?php else: ?>
			<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php tie_thumb('',300,160); ?>
				<?php tie_get_score( true ); ?>
			</a>
		</div><!-- post-thumbnail /-->
			<?php endif; ?>
		<div class="entry">
			<p><?php tie_excerpt() ?></p>
			<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'tie' ) ?></a>
		</div>
		<?php endif; ?>

		<?php tie_include( 'post-share' ); // Get Share Button template ?>	
	</article><!-- .item-list -->
<?php else: ?>
	<article class="item-list">
		<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>			
		<div class="post-thumbnail single-post-thumb archive-wide-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php tie_thumb('', 620 , 330 ); ?><?php tie_get_score( true ); ?></a>
		</div>
		<?php endif; ?>
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tie' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<p class="post-meta">
			<?php tie_get_time() ?>
			<span class="post-comments"><?php comments_popup_link( __( '0', 'tie' ), __( '1 Comment', 'tie' ), __( '% Comments', 'tie' ) ); ?></span>
			<?php echo tie_views(); ?>
		</p>
		<div class="entry">
			<p><?php tie_excerpt() ?></p>
			<a class="more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More &raquo;', 'tie' ) ?></a>
		</div>
		<?php tie_include( 'post-share' ); // Get Share Button template ?>	
	</article><!-- .item-list -->
<?php endif; ?>
	
<?php endwhile;?>
</div>
<?php endif; ?>