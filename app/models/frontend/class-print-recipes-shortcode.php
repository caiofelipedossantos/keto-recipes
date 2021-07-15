<?php

namespace Keto_Recipes\App\Models\Frontend;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Recipes_Shortcode')) {

	class Print_Recipes_Shortcode extends Base_Model
	{

		/**
		 * Fetch recipes
		 *
		 * @param  array $atts Attributes passed to shortcode.
		 * @since 1.0.0
		 * @return \WP_Query Returns found recipes as WP_Query object.
		 */
		public function fetch_recipes($atts)
		{
			$atts = shortcode_atts([
				'number_of_items'	=> 10,
				'pagination'        => 'false',
				'orderby'           => 'date',
				'order'             => 'asc',
				'categories'          => 'all',
				'cuisines'          => 'all',
				'flags'              => 'all',
			], $atts, 'keto_print_recipes');

			$args = [
				'post_type'			=> 'recipe',
				'posts_per_page' 	=> is_numeric($atts['number_of_items']) ? $atts['number_of_items'] : 10,
				'orderby'           => $atts['orderby'],
				'order'             => $atts['order'],
				'nopaging'          => !$atts['pagination'],
			];
			
			if(($atts['categories'] != 'all' && !empty($atts['categories'])) || 
			($atts['cuisines'] != 'all' && !empty($atts['cuisines'])) || 
			($atts['flags'] != 'all' && !empty($atts['flags']))){
			    $args['tax_query'] = array();
			}
			
			if($atts['categories'] != 'all' && !empty($atts['categories'])){
			    array_push($args['tax_query'], array( 
                        'taxonomy' => 'recipe_cat', 
                        'field' => 'slug', 
                        'terms' => explode('|', $atts['categories'])
                    )
                );
			}
			
			if($atts['cuisines'] != 'all' && !empty($atts['cuisines'])){
			    array_push($args['tax_query'], array( 
                        'taxonomy' => 'recipe_cuisine', 
                        'field' => 'slug', 
                        'terms' => explode('|', $atts['cuisines'])
                    )
                );
			}
			
			if($atts['flags'] != 'all' && !empty($atts['flags'])){
			    array_push($args['tax_query'], array( 
                        'taxonomy' => 'recipe_flag', 
                        'field' => 'slug', 
                        'terms' => explode('|', $atts['flags'])
                    )
                );
			}
			
			return  new \WP_Query($args);
		}

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
		
		public function fetch_recipes_ajax($attr){
		    
		    $args['post_type'] = 'recipe';
			$args['post_status'] = 'publish';
			$args['nopaging'] = true;
			
			if(isset($attr['query']) && !empty($attr['query'])){
			    $args['s'] = $attr['query'];
			}
			
			if(isset($attr['orderBy']) && !empty($attr['orderBy'])){
			    switch($attr['orderBy']){
			        case 'date_desc':
			        default:
			            $args['orderby'] = 'date';
			            $args['order']   = 'DESC';
			            break;
			        case 'date_asc':
			            $args['orderby'] = 'date';
			            $args['order']   = 'ASC';
			            break;
			        case 'title_asc':
			            $args['orderby'] = 'title';
			            $args['order']   = 'ASC';
			            break;
			        case 'title_desc':
			            $args['orderby'] = 'title';
			            $args['order']   = 'DESC';
			            break;
			               
			    }
                $args['suppress_filters'] = true;
			}
			
			if(isset($attr['categories']) || isset($attr['cuisines']) || isset($attr['flags'])){
			   $args['tax_query']  = array();
			}
			
			if(isset($attr['categories']) && !empty($attr['categories'])){
			    array_push($args['tax_query'], array( 
                        'taxonomy' => 'recipe_cat', 
                        'field' => 'slug', 
                        'terms' => $attr['categories']
                    )
                );
			}
			
			if(isset($attr['cuisines']) && !empty($attr['cuisines'])){
			    array_push($args['tax_query'], array(
                        'taxonomy' => 'recipe_cuisine', 
                        'field' => 'slug', 
                        'terms' => $attr['cuisines']
                    )
                );
			}
			
			if(isset($attr['flags']) && !empty($attr['flags'])){
			    array_push($args['tax_query'], array(
                        'taxonomy' => 'recipe_flag', 
                        'field' => 'slug', 
                        'terms' => $attr['flags']
                    )
                );
			}
			
			return new \WP_Query($args);
		}
	}
}
