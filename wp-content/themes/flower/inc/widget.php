<?php
/*
 * Adds Foo_Widget widget.
 */

function register_product_category() {
    register_widget( 'TFS_product_cate' );
}
add_action( 'widgets_init', 'register_product_category' );



/**
 * Product Categories Widget
 *
 * @author 		WooThemes
 * @category 	Widgets
 * @package 	flower/Widgets
 * @version 	2.1.0
 * @extends 	WC_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class TFS_product_cate extends WP_Widget {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'product_home', // Base ID
			__( 'Product Home Block', 'flower' ), // Name
			array( 'description' => __( 'Show product of a category on block home page', 'flower' ), ) // Args
		);
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$categoryID   = empty( $instance['categoryID'] ) ? '' : apply_filters( 'widget_categoryID', $instance['categoryID'] );
		$title        = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$number_post  = empty( $instance['number_post'] ) ? '' : apply_filters( 'widget_number_post', $instance['number_post'] );
		$class_custom = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_style', $instance['class_custom'] );

		$banner1 = empty( $instance['banner1'] ) ? '' : apply_filters( 'widget_style', $instance['banner1'] );
		$banner1_link = empty( $instance['banner1_link'] ) ? '' : apply_filters( 'widget_style', $instance['banner1_link'] );
		$banner2 = empty( $instance['banner2'] ) ? '' : apply_filters( 'widget_style', $instance['banner2'] );
		$banner2_link = empty( $instance['banner2_link'] ) ? '' : apply_filters( 'widget_style', $instance['banner2_link'] );
		$banner3 = empty( $instance['banner3'] ) ? '' : apply_filters( 'widget_style', $instance['banner3'] );
		$banner3_link = empty( $instance['banner3_link'] ) ? '' : apply_filters( 'widget_style', $instance['banner3_link'] );

		$query_args = array(
		    'posts_per_page' => $number_post,
    		'post_status' 	 => 'publish',
    		'post_type' 	 => 'product',
    		'no_found_rows'  => 1,
		    'tax_query'     => array(
		        array(
		            'taxonomy'  => 'product_cat',
		            'field'     => 'id', 
		            'terms'     => $categoryID
		        )
		    )
		);

		$r = new WP_Query( $query_args );
			echo $before_widget;
			if($class_custom == 'block-green') {
				$icon1_1 = 'icon1';
				$icon1_2 = 'icon2';
			} elseif($class_custom == 'block-pure') {
				$icon1_1 = 'icon5';
				$icon1_2 = 'icon6';
			} else {
				$icon1_1 = 'icon3';
				$icon1_2 = 'icon4';
			}
		 ?>
			<div class="box-products image-rez">
				<div class="box-product-left">
					<div class="block-other">
					  	<div class="block-title <?php echo $class_custom; ?>">
							<div class="title">
									<?php 
										if($title) {
											echo $title; 	
										} else {
											$tern_name = get_term_by('id', $categoryID, 'product_cat');
											echo $tern_name->name;
										}
										
									?>
							</div>
						  	<ul class="list-icon">
							  <li><img alt="" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $icon1_1; ?>.gif"></li>
							  <li class="line"><img alt="" src="images/line-green.gif"></li>
							  <li><img alt="" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $icon1_2; ?>.gif"></li>
						  	</ul>
						</div><!-- end block-title -->
						<div class="banner"><a href="<?php echo $banner1_link; ?>"><img alt="" src="<?php bloginfo('template_directory'); ?>/<?php echo $banner1; ?>"></div>
						<div class="block-content-logo">
							<a href="<?php echo $banner2_link; ?>"><img alt="" src="<?php bloginfo('template_directory'); ?>/<?php echo $banner2; ?>"></a>
							<a href="<?php echo $banner3_link; ?>"><img alt="" src="<?php bloginfo('template_directory'); ?>/<?php echo $banner2; ?>"></a>
						</div>
					</div>
				</div>
			  <div class="box-product-right">
				<div class="img-big">
					<?php
							 $category_thumbnail = get_woocommerce_term_meta($categoryID, 'thumbnail_id', true);
							  $image = wp_get_attachment_url($category_thumbnail);
							  echo '<img class="absolute category-image" src="'.$image.'">';
					?>
				</div><!--end img-big -->
				<div class="box-list">
					<ul>
						<?php

							while ( $r->have_posts()) : $r->the_post();
								 global $product; 
								 //var_dump($product);
								 	global $wp_query;
										
								 ?>
								<li>
									<div class="product-img">
										<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
											<?php echo $product->get_image( array( 122, 105 )); ?>
										</a>
									</div>
									<h2 class="product-name">
										<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
											<?php echo $product->get_title(); ?>
										</a>
									</h2>
									<?php 
										$sku = get_post_meta( $product->id , '_sku', true );
									?>
									<div class="type">Mã SP: <?php echo $sku; ?></div>
								</li>
								<?php
							endwhile;
						?>
					</ul>
				</div>
			  </div>
			</div>

			<?php
			echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['number_post']  = strip_tags( $new_instance['number_post'] );
		$instance['categoryID']   = strip_tags( $new_instance['categoryID'] );
		$instance['class_custom'] = strip_tags( $new_instance['class_custom'] );

		$instance['banner1']        = strip_tags( $new_instance['banner1'] );
		$instance['banner1_link']  = strip_tags( $new_instance['banner1_link'] );
		$instance['banner2']   = strip_tags( $new_instance['banner2'] );
		$instance['banner2_link'] = strip_tags( $new_instance['banner2_link'] );
		$instance['banner3']   = strip_tags( $new_instance['banner3'] );
		$instance['banner3_link'] = strip_tags( $new_instance['banner3_link'] );

		return $instance;
	}

	function form( $instance ) {
		$instance     = wp_parse_args( (array) $instance, array( 'title' => '', 'number_post' => '6', 'length_excerpt' => '15', 'categoryID' => '', 'class_custom' => '', 'banner1' => '', 'banner1_link' => '', 'banner2' => '', 'banner2_link' => '', 'banner3' => '', 'banner3_link' => '' ) );
		$title        = strip_tags( $instance['title'] );
		$number_post  = strip_tags( $instance['number_post'] );
		$categoryID   = strip_tags( $instance['categoryID'] );
		$class_custom = strip_tags( $instance['class_custom'] );
		$banner1  = strip_tags( $instance['banner1'] );
		$banner1_link  = strip_tags( $instance['banner1_link'] );
		$banner2  = strip_tags( $instance['banner2'] );
		$banner2_link  = strip_tags( $instance['banner2_link'] );
		$banner3  = strip_tags( $instance['banner3'] );
		$banner3_link  = strip_tags( $instance['banner3_link'] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo _e( 'Title Widget: ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_post' ); ?>"><?php echo _e( 'Number Post: ', 'flower' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'number_post' ); ?>" name="<?php echo $this->get_field_name( 'number_post' ); ?>" value="<?php echo esc_attr( $number_post ); ?>">
		</p>


		<p>
			<label for="<?php echo $this->get_field_id( 'categoryID' ); ?>"><?php echo _e( 'Select Category ', 'flower' ) ?>
				<select name="<?php echo $this->get_field_name( 'categoryID' ); ?>" id="<?php echo $this->get_field_id( 'categoryID' ); ?>" style="width:170px">
					<?php $categories = get_terms('product_cat');

					foreach ( $categories as $cat ) {
						if ( $categoryID == $cat->term_id ) {
							$selected = ' selected="selected"';
						} else {
							$selected = '';
						}
						$opt = '<option value="' . $cat->term_id . '"' . $selected . '>' . $cat->name . '</option>';
						echo $opt;
					}
					?>
				</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'class_custom' ); ?>"><?php echo _e( 'Select Css Class: ', 'flower' ) ?></label>
				<select name="<?php echo $this->get_field_name( 'class_custom' ); ?>" id="<?php echo $this->get_field_id( 'class_custom' ); ?>" style="width:170px">
					<?php $style_css = array('block-green' => 'Style 1', 'block-green-light' => 'Style 2', 'block-pure' => 'Style 3');

					foreach ( $style_css as $key => $stl ) {
						if ( $class_custom == $key ) {
							$selected = ' selected="selected"';
						} else {
							$selected = '';
						}
						$opt = '<option value="'.$key.'"' . $selected . '>' . $stl . '</option>';
						echo $opt;
					}
					?>
				</select>
		</p>

		<?php
		/*Banner*/
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'banner1' ); ?>"><?php echo _e( 'Banner 1: ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'banner1' ); ?>" name="<?php echo $this->get_field_name( 'banner1' ); ?>" value="<?php echo esc_attr( $banner1 ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'banner1_link' ); ?>"><?php echo _e( 'Banner1 link : ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'banner1_link' ); ?>" name="<?php echo $this->get_field_name( 'banner1_link' ); ?>" value="<?php echo esc_attr( $banner1_link ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'banner2' ); ?>"><?php echo _e( 'Banner 2: ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'banner2' ); ?>" name="<?php echo $this->get_field_name( 'banner2' ); ?>" value="<?php echo esc_attr( $banner2 ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'banner2_link' ); ?>"><?php echo _e( 'Banner 2 link : ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'banner2_link' ); ?>" name="<?php echo $this->get_field_name( 'banner2_link' ); ?>" value="<?php echo esc_attr( $banner2_link ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'banner3' ); ?>"><?php echo _e( 'Banner 3 : ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'banner3' ); ?>" name="<?php echo $this->get_field_name( 'banner3' ); ?>" value="<?php echo esc_attr( $banner3 ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'banner3_link' ); ?>"><?php echo _e( 'Banner 3 link : ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'banner3_link' ); ?>" name="<?php echo $this->get_field_name( 'banner3_link' ); ?>" value="<?php echo esc_attr( $banner3_link ); ?>">
		</p>

	<?php
	}
}

