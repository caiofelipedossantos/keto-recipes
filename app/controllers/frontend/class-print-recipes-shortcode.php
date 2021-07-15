<?php

namespace Keto_Recipes\App\Controllers\Frontend;

use Keto_Recipes;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Recipes_Shortcode')) {

	class Print_Recipes_Shortcode extends Base_Controller
	{
		/**
		 * @ignore Blank Method
		 */
		public function  register_hook_callbacks()
		{
			// Enqueue Styles & Scripts.
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

			//Register the 'keto_print_recipes' shortcode.
			add_shortcode('keto_print_recipes', array($this, 'print_recipes_callback'));
		}

		/**
		 * Register the JavaScript and CSS for the frontend area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts()
		{

			wp_enqueue_style(
				Keto_Recipes::PLUGIN_ID . '_frontend',
				Keto_Recipes::get_plugin_url() . 'assets/css/frontend/keto-recipes.css',
				array(),
				Keto_Recipes::PLUGIN_VERSION,
				'all'
			);

			wp_enqueue_script(
				Keto_Recipes::PLUGIN_ID . '_javascript',
				Keto_Recipes::get_plugin_url() . 'assets/js/frontend/keto-recipes.js',
				array('jquery'),
				Keto_Recipes::PLUGIN_VERSION,
				true
			);
		}

		/**
		 * Callback to handle  'keto_print_recipes' shortcode.
		 *
		 * @param array $atts Attributes passed to shortcode
		 * @since 1.0.0
		 * @return string Html to rendered
		 */
		public function print_recipes_callback($atts)
		{   
		    $options['fetched_recipes'] = $this->get_model()->fetch_recipes($atts);
		    
		    if(!empty($atts['search']) && $atts['search'] == "true"){
		        $options['fetched_recipes']     = $this->get_model()->fetch_recipes($atts);
		        $options['fetch_categories']    = $this->get_model()->fetch_categories();
		        $options['fetch_cuisines']      = $this->get_model()->fetch_cuisines();
		        $options['fetch_flags']         = $this->get_model()->fetch_flags();
		        $options['search']              = true;
		        $options['options']             = $atts;
		    }else{
		        $options['search']              = false;
		    }
		    
			return $this->get_view()->display_recipes($options);
		}
	}
}
