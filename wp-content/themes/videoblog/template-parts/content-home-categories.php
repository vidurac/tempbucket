<?php
/**
 * The template used for displaying featured categories on the Front Page.
 *
 * @package Videoblog
 */
?>

<?php
	
	$x = 0;
	$max = 5;
	
	while ($x < $max) { 
		$x++;

		$array_categories[$x]['id'] = get_theme_mod( 'videoblog_featured_category_' . $x, 0 );
		$array_categories[$x]['color'] = get_theme_mod( 'videoblog_featured_category_color_' . $x, 'black' );

	}
	
	foreach ( $array_categories as $array_category ) {
	
		if ( $array_category['id'] == 0 ) {
			continue;
		}
		
		$custom_loop = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 4,
			'order'          => 'DESC',
			'orderby'        => 'date',
			'cat' 		 	 => absint($array_category['id'])
		) );
	
		?>

		<?php if ( $custom_loop->have_posts() ) : $i = 0; ?>
		
			<div class="widget clearfix">
			
				<div class="ilovewp-featured-category">
				
					<p class="widget-title<?php if ( $array_category['color'] != 'black' ) { echo ' title-' . esc_attr($array_category['color']); } ?>"><a href="<?php echo esc_url( get_category_link($array_category['id']) ); ?>" title="<?php echo esc_attr( get_cat_name($array_category['id'])); ?>"><?php echo esc_html( get_cat_name($array_category['id']) ); ?></a></p>
					
					<ul class="ilovewp-posts ilovewp-posts-archive clearfix">
					
					<?php while ( $custom_loop->have_posts() ) : $custom_loop->the_post(); $i++; ?>

						<?php $classes = array('ilovewp-post','ilovewp-post-archive','ilovewp-post-'.$i, 'clearfix'); ?>
						
						<li <?php post_class($classes); ?>>
						
							<article id="post-<?php the_ID(); ?>">
							
								<?php if ( has_post_thumbnail() ) : ?>
								<div class="post-cover-wrapper">
									<div class="post-cover">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail(); ?>
										</a>
									</div><!-- .post-cover -->
								</div><!-- .post-cover-wrapper -->
								<?php endif; ?>
							
								<div class="post-preview">
									<span class="post-meta-category"><?php the_category(esc_html_x( ', ', 'Used on archive and post pages to separate multiple categories.', 'videoblog' )); ?></span>
									<?php the_title( sprintf( '<h2 class="title-post"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
									<p class="post-meta">
										<span class="posted-on"><span class="genericon genericon-time"></span> <time class="entry-date published" datetime="<?php echo get_the_date('c'); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'videoblog' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></a></time></span>
									</p><!-- .post-meta -->
								</div><!-- .post-preview -->
							
							</article><!-- #post-<?php the_ID(); ?> -->
						
						</li><!-- .ilovewp-post .ilovewp-post-archive .clearfix -->
						
						<?php if ( $i == 4) { $i = 0; } ?>
					
					<?php endwhile; ?>
					
					</ul><!-- .ilovewp-posts .ilovewp-posts-archive -->
					
				</div><!-- .ilovewp-featured-category -->
			
			</div><!-- .widget -->
		
			<?php wp_reset_postdata(); ?>
		
		<?php else : ?>
		
			 <?php if ( current_user_can( 'publish_posts' ) && is_customize_preview() ) : ?>
		
			<div class="widget clearfix">
			
				<p class="widget-title"><?php _e('Featured Category Not Configured Yet','videoblog'); ?></p>
				
			</div><!-- .widget -->
		
			<?php endif; ?>
		
		<?php endif; ?>
		
		<?php

	} // end foreach