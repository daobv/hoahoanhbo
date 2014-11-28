<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
			<?php get_breadcrumbs(); ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; // end of the loop. ?>
		</div>

		<div class="col-right">
		<?php dynamic_sidebar( 'sidebar_right' );  ?>
	</div><!-- end col-right -->
	</div><!-- #container -->
</div><!-- #navigation -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
