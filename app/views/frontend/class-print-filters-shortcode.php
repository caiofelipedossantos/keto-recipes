<?php

namespace Keto_Recipes\App\Views\Frontend;

use Keto_Recipes\Core\View;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Filters_Shortcode')) {

	class Print_Filters_Shortcode extends View
	{
		public function display_filters($args)
		{
			return $this->render_template('frontend/print-filters-shortcode.php', $args);
		}
	}
}
