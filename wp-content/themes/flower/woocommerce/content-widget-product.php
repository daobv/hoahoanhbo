<?php global $product; ?>
<?php
	if(is_home() || is_front_page()) :
		global $post;
?>
<li>
	<a class="product-img" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_image( array( 178, 194 )); ?>
	</a>
	<div class="description">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
	</div>
</li>
<?php
	else:
?>
<li class="block">
	<div class="block-title"> </div>
	<div class="block-content">
		<a class="product-img" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_image(); ?>
		</a>
		<div class="bank">Mã hàng: <?php echo $product->get_sku( ); ?></div>		
		<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
		<div class="action">
			<a class="read-more" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>">Chi tiết</a>
			<a class="shop-cart" href="<?php echo $product->add_to_cart_url( ); ?>">Đặt hàng</a>
		</div>
		<div class="box-more">
			<a href="">Xem thêm</a>|<a href="">Tất cả</a>
		</div>
		
	</div>
</li>
<?php
	endif;
?>