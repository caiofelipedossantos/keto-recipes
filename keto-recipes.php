<?php

/**
 * Main Plugin File
 *
 * @link              http://ketorecipes.fit
 * @since             1.0.0
 * @package           Keto_Recipes
 *
 * @wordpress-plugin
 * Plugin Name:       Keto Recipes
 * Plugin URI:        https://devapps.com.br/plugins/ketorecipes
 * Description:       Plugin responsible for providing new features for the theme.
 * Version:           1.0.0
 * Author:            Caio Felipe
 * Author URI:        http://devapps.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       keto-recipes
 * Domain Path:       /languages
 * 
 * GitHub Plugin URI: polares552/keto-recipes
 * GitHub Plugin URI: https://github.com/polares552/keto-recipes
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Creates/Maintains the object of Requirements Checker Class
 *
 * @return \Keto_Recipes\Includes\Requirements_Checker
 * @since 1.0.0
 */
function plugin_requirements_checker()
{
	static $requirements_checker = null;

	if (null === $requirements_checker) {
		require_once plugin_dir_path(__FILE__) . 'includes/class-requirements-checker.php';
		$requirements_conf = apply_filters('keto_recipes_minimum_requirements', include_once(plugin_dir_path(__FILE__) . 'requirements-config.php'));
		$requirements_checker = new Keto_Recipes\Includes\Requirements_Checker($requirements_conf);
	}

	return $requirements_checker;
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_keto_recipes()
{

	// If Plugins Requirements are not met.
	if (!plugin_requirements_checker()->requirements_met()) {
		add_action('admin_notices', array(plugin_requirements_checker(), 'show_requirements_errors'));

		// Deactivate plugin immediately if requirements are not met.
		require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		deactivate_plugins(plugin_basename(__FILE__));

		return;
	}

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and frontend-facing site hooks.
	 */
	require_once plugin_dir_path(__FILE__) . 'includes/class-keto-recipes.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	$router_class_name = apply_filters('keto_recipes_router_class_name', '\Keto_Recipes\Core\Router');
	$routes = apply_filters('keto_recipes_routes_file', plugin_dir_path(__FILE__) . 'routes.php');
	$GLOBALS['keto_recipes'] = new Keto_Recipes($router_class_name, $routes);

	register_activation_hook(__FILE__, array(new Keto_Recipes\App\Activator(), 'activate'));
	register_deactivation_hook(__FILE__, array(new Keto_Recipes\App\Deactivator(), 'deactivate'));
}

run_keto_recipes();
