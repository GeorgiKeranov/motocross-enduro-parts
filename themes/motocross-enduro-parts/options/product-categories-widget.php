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
			<select name="product-categories" class="product-categories-select js-category-mobile-get-products-ajax">
				<option value="" default>Избиране на категория</option>

				<?php foreach ( $product_categories as $category ) : ?>
					<option value="<?php echo $category->term_id ?>"><?php echo esc_html( $category->name ) ?></option>					
				<?php endforeach; ?>
			</select>
		<?php else :
			$shop_page_permalink = '';

			$shop_page_id = wc_get_page_id( 'shop' );
			if ( !empty( $shop_page_id ) ) {
				$shop_page_permalink = get_permalink( $shop_page_id );
			}

			$is_shop = is_shop();
			$selected_category = !empty( $_GET['category'] ) ? $_GET['category'] : 0;
			?>
			
			<ul class="product-categories js-category-desktop-get-products-ajax">
				<li<?php echo empty( $selected_category ) && $is_shop ? ' class="current-cat"' : '' ?>>
					<a href="<?php echo $shop_page_permalink ?>" data-category-id="">Всички категории</a>
				</li>

				<?php foreach ( $product_categories as $category ) : ?>
					<li<?php echo $selected_category == $category->term_id ? ' class="current-cat"' : '' ?>>
						<a href="<?php echo $shop_page_permalink . '?category=' . $category->term_id ?>" data-category-id="<?php echo $category->term_id ?>"><?php echo esc_html( $category->name ) ?></a>
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
