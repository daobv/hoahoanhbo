<?php
/*
 * Adds Foo_Widget widget.
 */
WooCommerce::include_widgets() ;


class Slider_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'slider_widget', // Base ID
			__( 'Slider Widget Meta', 'flower' ), // Name
			array( 'description' => __( 'Create slideshow for home page', 'flower' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$slider_id           = empty( $instance['slider_id'] ) ? '115' : apply_filters( 'widget_slider_id', $instance['slider_id'] );
		?>
		<div class="slide-home">
			<div class="container">
				<div class="slide-show">
		<?php
     	echo $args['before_widget'];
		if ( ! empty( $slider_id ) ) {
			echo $args['before_title'] .do_shortcode('[metaslider id="'.$slider_id.'"]'). $args['after_title'];
		}
		
		?>

		<?php echo $args['after_widget']; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
     	 $slider_id = ! empty( $instance['slider_id'] ) ? $instance['slider_id'] : __( '115', 'flower' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'slider_id' ); ?>"><?php _e( 'Meta Slider ID', 'flower' ) ?>:
				<input class="widefat" id="<?php echo $this->get_field_id( 'slider_id' ); ?>" name="<?php echo $this->get_field_name( 'slider_id' ); ?>" type="text" value="<?php echo esc_attr( $slider_id ); ?>" />
			</label>
		</p>	
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['slider_id']       = strip_tags( $new_instance['slider_id'] );
		
		return $instance;
	}

} 

// register Slider_widget widget
function register_slider_widget() {
    register_widget( 'Slider_widget' );
}
add_action( 'widgets_init', 'register_slider_widget' );

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
			'slider_widgetxxxx', // Base ID
			__( 'AAAA XXX', 'flower' ), // Name
			array( 'description' => __( 'afdsf afs sdfs fsfwsfa', 'flower' ), ) // Args
		);
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$categoryID   = empty( $instance['categoryID'] ) ? '' : apply_filters( 'widget_categoryID', $instance['categoryID'] );
		$title        = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$number_post  = empty( $instance['number_post'] ) ? '' : apply_filters( 'widget_number_post', $instance['number_post'] );
		$class_custom = empty( $instance['class_custom'] ) ? '' : apply_filters( 'widget_style', $instance['class_custom'] );

		$query_args = array(
    		'posts_per_page' => $number,
    		'post_status' 	 => 'publish',
    		'post_type' 	 => 'product',
    		'no_found_rows'  => 1
    	);

    	$query_args['meta_query'] = array();

    	if ( empty( $instance['show_hidden'] ) ) {
			$query_args['meta_query'][] = WC()->query->visibility_meta_query();
			$query_args['post_parent']  = 0;
		}

		if ( ! empty( $instance['hide_free'] ) ) {
    		$query_args['meta_query'][] = array(
			    'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL',
			);
    	}

	    $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
	    $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

    	switch ( $show ) {
    		case 'featured' :
    			$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
    			break;
    		case 'onsale' :
    			$product_ids_on_sale = wc_get_product_ids_on_sale();
				$product_ids_on_sale[] = 0;
				$query_args['post__in'] = $product_ids_on_sale;
    			break;
    	}

    	switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
    			$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
    			$query_args['orderby']  = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
    			$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby']  = 'date';
    	}

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<ul class="product_list_widget">';

			while ( $r->have_posts()) {
				$r->the_post();
				wc_get_template( 'content-widget-product.php', array( 'show_rating' => $show_rating ) );
			}

			echo '</ul>';

			echo $after_widget;
		}

		wp_reset_postdata();

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['number_post']  = strip_tags( $new_instance['number_post'] );
		$instance['categoryID']   = strip_tags( $new_instance['categoryID'] );
		$instance['class_custom'] = strip_tags( $new_instance['class_custom'] );

		return $instance;
	}

	function form( $instance ) {
		$instance     = wp_parse_args( (array) $instance, array( 'title' => '', 'number_post' => '6', 'length_excerpt' => '15', 'categoryID' => '', 'class_custom' => '' ) );
		$title        = strip_tags( $instance['title'] );
		$number_post  = strip_tags( $instance['number_post'] );
		$categoryID   = strip_tags( $instance['categoryID'] );
		$class_custom = strip_tags( $instance['class_custom'] );
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
					} ?>
				</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'class_custom' ); ?>"><?php echo _e( 'Css Class: ', 'flower' ) ?></label>
			<input type="text" class="widefat" size="3" id="<?php echo $this->get_field_id( 'class_custom' ); ?>" name="<?php echo $this->get_field_name( 'class_custom' ); ?>" value="<?php echo esc_attr( $class_custom ); ?>">
		</p>


	<?php
	}


	
}
