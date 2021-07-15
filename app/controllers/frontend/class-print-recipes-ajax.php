<?php

namespace Keto_Recipes\App\Controllers\Frontend;

use Keto_Recipes;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Recipes_Ajax')) {
	class Print_Recipes_Ajax extends Base_Controller
	{
		public function register_hook_callbacks()
		{
			add_action('wp_enqueue_scripts', array($this, 'ajax_search_enqueues'));
			add_action('wp_ajax_keto_load_search_results', array($this, 'load_search_results'));
			add_action('wp_ajax_nopriv_keto_load_search_results', array($this, 'load_search_results'));
		}

		public function ajax_search_enqueues()
		{
			wp_localize_script(Keto_Recipes::PLUGIN_ID . '_javascript', 'ketoAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
		}

		public function load_search_results()
		{
		    $atts = array();
		    
			if(isset($_POST['query']) && !empty($_POST['query'])){
			    $atts['query'] = $_POST['query'];
			}
			
			if(isset($_POST['categories']) && !empty($_POST['categories'])){
                $atts['categories'] = $_POST['categories'];
			}
			
			if(isset($_POST['cuisines']) && !empty($_POST['cuisines'])){
                $atts['cuisines'] = $_POST['cuisines'];
			}
			
			if(isset($_POST['flags']) && !empty($_POST['flags'])){
			    $atts['flags'] = $_POST['flags'];
			}
			
			if(isset($_POST['orderBy']) && !empty($_POST['orderBy'])){
			    $atts['orderBy'] = $_POST['orderBy'];
			}
			
			echo $this->get_view()->display_cards([
				'fetched_recipes' => $this->get_model()->fetch_recipes_ajax($atts)
			]);
			
			wp_die();
		}
	}
}
