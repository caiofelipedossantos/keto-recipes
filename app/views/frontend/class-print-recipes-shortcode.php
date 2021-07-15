<?php

namespace Keto_Recipes\App\Views\Frontend;

use Keto_Recipes\Core\View;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Recipes_Shortcode')) {

	class Print_Recipes_Shortcode extends View
	{
		public function display_recipes($args)
		{
			return $this->render_template('frontend/print-recipes-shortcode.php', $args);
		}
		
		public function display_cards($args){
		    return $this->render_template('frontend/partials/recipes-cards.php', $args);
		}
	}
}
