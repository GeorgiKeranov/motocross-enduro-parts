<?php

add_action( 'widgets_init', 'crb_load_custom_widgets' );
function crb_load_custom_widgets() {
	register_widget( 'Product_Categories_Widget' );
}

class Product_Categories_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'product_categories_widget', 
			__( 'Категории продукти', 'crb' ),
			array( 'description' => __( 'Категории продукти без "Uncategorized" категория.', 'crb' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		$title = esc_html( $instance['title'] );

		$product_categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'exclude' => 16
		) );

		if ( empty( $product_categories ) ) {
			return;
		}

		echo $args['before_widget'];
		
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>

		<ul class="product-categories">
			<?php foreach ( $product_categories as $category ) : ?>
				<li class="porduct__category">
					<a href="<?php echo $category->term_id ?>"><?php echo esc_html( $category->name ) ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = '';

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заглавие:', 'crb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<?php 
	}
} 
