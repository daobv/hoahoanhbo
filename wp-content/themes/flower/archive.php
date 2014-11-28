<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package flower
 */

get_header(); ?>

	<div class="navigation page-content">
			<div class="container border-right clearfix">
				<div class="col-main" >
					<div class="top-menu">
						<div class="mod-category">
							<ul>
								<?php
				      				wp_nav_menu( array(
										'theme_location' => 'product_menu',
										'container'      => false,
										'items_wrap'     => '%3$s'
									) );
								?>
							</ul>
						</div>
						<div class="mod-nav">
							<ul>
								<?php
				      				wp_nav_menu( array(
										'theme_location' => 'main_menu',
										'container'      => false,
										'items_wrap'     => '%3$s'
									) );
								?>
							</ul>
						</div>
					</div><!-- top-menu -->

					<?php if ( have_posts() ) : ?>
						<div class="page-news">
							<?php get_breadcrumbs(); ?>
							<div class="product-news">
								<?php /* Start the Loop */ ?>
								<?php while ( have_posts() ) : the_post(); ?>

									<?php
										/* Include the Post-Format-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
										 */
										get_template_part( 'content', get_post_format() );
									?>

								<?php endwhile; ?>
							</div>
						</div>								

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>
	</div>

	<div class="col-right">
		<?php dynamic_sidebar( 'sidebar_right' );  ?>
	</div><!-- end col-right -->

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
