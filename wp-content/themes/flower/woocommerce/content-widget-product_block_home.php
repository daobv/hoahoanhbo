<?php global $product; ?>
<li>
	<div class="product-img">
		<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_image(); ?>
		</a>
	</div>
	<h2 class="product-name">
		<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_title(); ?>
		</a>
	</h2>
	<div class="type">Mã SP: <?php $product->get_sku( ); ?></div>
</li>