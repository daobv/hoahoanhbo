<?php
/**
 * Template Name: Front page
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Theme For Seo consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Theme_For_Seo
 * @since Theme For Seo 1.0
 */

get_header(); 
?>
<div class="page-content">
		<?php dynamic_sidebar( 'slideshow' ); ?>
		<div class="top-page">
			<div class="top-main">
				<div class="slide-bank">
					 <?php logo_slider(); ?>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="main">
				<div class="block-product">
					<?php dynamic_sidebar( 'product_feature' ); ?>
				</div><!-- block-product -->
				<?php dynamic_sidebar( 'sidebar_home' ); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>