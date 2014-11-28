<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package flower
 */
?>
	<div class="wapp-footer">
		<div class="footer-top">
			<div class="container clearfix">
				
				<?php 
					dynamic_sidebar( 'footer_sidebar' ); 
				?>								
				
			</div>
		</div>
		<div class="footer-cen">
			<div class="footer">
				<ul>
					<?php
	      				wp_nav_menu( array(
							'theme_location' => 'footer_menu',
							'container'      => false,
							'items_wrap'     => '%3$s'
						) );
					?>
				</ul>
			</div>
		</div>
		<div class="footer-bot">
			<div class="footer-bot-inner">
				<?php dynamic_sidebar( 'footer_text' ); ?>
			</div>
		</div>
	</div>
<?php wp_footer(); ?>

</body>
</html>
