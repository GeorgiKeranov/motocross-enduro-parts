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
		$title = '';
		$is_select_menu = false;

		if ( isset( $instance['title'] ) ) {
			$title = esc_html( $instance['title'] );
		}

		if ( isset( $instance['is_select_menu'] ) ) {
			$is_select_menu = $instance['is_select_menu'];
		}

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

		<?php if ( $is_select_menu == 'on' ) : ?>
			<select name="product-categories" class="product-categories-select">
				<option value="" default>Избиране на категория</option>

				<?php foreach ( $product_categories as $category ) : ?>
					<option value="<?php echo $category->term_id ?>"><?php echo esc_html( $category->name ) ?></option>					
				<?php endforeach; ?>
			</select>
		<?php else : ?>
			<ul class="product-categories">
				<?php foreach ( $product_categories as $category ) : ?>
					<li class="porduct__category">
						<a href="<?php echo $category->term_id ?>"><?php echo esc_html( $category->name ) ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = '';
		$is_select_menu = false;

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}

		if ( isset( $instance['is_select_menu'] ) ) {
			$is_select_menu = $instance['is_select_menu'];
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заглавие:', 'crb' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<input class="widefat" id="<?php echo $this->get_field_id( 'is_select_menu' ); ?>" name="<?php echo $this->get_field_name( 'is_select_menu' ); ?>" type="checkbox"<?php echo $is_select_menu == 'on' ? ' checked' : '' ?>/>
			<label for="<?php echo $this->get_field_id( 'is_select_menu' ); ?>">Показване като падащо меню</label>
		</p>
		
		<?php 
	}
} 
