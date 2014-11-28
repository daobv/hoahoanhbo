<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
	<div class="page-content">
		<div class="navigation">
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
				<div class="page-inner">
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action( 'woocommerce_before_main_content' );
					?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php wc_get_template_part( 'content', 'single-product' ); ?>

						<?php endwhile; // end of the loop. ?>

					<?php
						/**
						 * woocommerce_after_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action( 'woocommerce_after_main_content' );
					?></div></div>
				<div class="col-right">
					<?php dynamic_sidebar( 'sidebar_right' );  ?>
				</div>
			</div>
		</div>
	</div>

					<?php
						/**
						 * woocommerce_sidebar hook
						 *
						 * @hooked woocommerce_get_sidebar - 10
						 */
						do_action( 'woocommerce_sidebar' );
					?>

<?php get_footer( 'shop' ); ?>