<?php

namespace Keto_Recipes\App\Models\Frontend;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Filters_Shortcode')) {

	class Print_Filters_Shortcode extends Base_Model
	{

		/**
		 * Fetch categories recipes
		 *
		 * @since 1.0.0
		 * @return \WP_Term Return found categories as WP_Term object. 
		 */
		public function fetch_categories()
		{
			$args = [
				'post_type' => 'recipe',
				'taxonomy' => 'recipe_cat',
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => 0
			];
			return get_categories($args);
		}

		/**
		 * Fetch cuisines recipes
		 *
		 * @since 1.0.0
		 * @return \WP_Term Return found categories as WP_Term object. 
		 */
		public function fetch_cuisines()
		{
			$args = [
				'post_type' => 'recipe',
				'taxonomy' => 'recipe_cuisine',
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => 0
			];
			return get_categories($args);
		}

		/**
		 * Fetch cuisines recipes
		 *
		 * @since 1.0.0
		 * @return \WP_Term Return found categories as WP_Term object. 
		 */
		public function fetch_flags()
		{
			$args = [
				'post_type' => 'recipe',
				'taxonomy' => 'recipe_flag',
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => 0
			];
			return get_categories($args);
		}
	}
}
