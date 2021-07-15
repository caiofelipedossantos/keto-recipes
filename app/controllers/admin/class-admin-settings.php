<?php

namespace Keto_Recipes\App\Controllers\Admin;

use Keto_Recipes\App\Controllers\Admin\Base_Controller;
use Keto_Recipes as Keto_Recipes;

if (!class_exists(__NAMESPACE__ . '\\' . 'Admin_Settings')) {

	/**
	 * Controller class that implements Plugin Admin Settings configurations
	 *
	 * @since      1.0.0
	 * @package    Keto_Recipes
	 * @subpackage Keto_Recipes/controllers/admin
	 */
	class Admin_Settings extends Base_Controller
	{

		/**
		 * Holds suffix for dynamic add_action called on settings page.
		 *
		 * @var string
		 * @since 1.0.0
		 */
		private static $hook_suffix = 'settings_page_' . Keto_Recipes::PLUGIN_ID;

		/**
		 * Slug of the Settings Page
		 *
		 * @since    1.0.0
		 */
		const SETTINGS_PAGE_SLUG = Keto_Recipes::PLUGIN_ID;

		/**
		 * Capability required to access settings page
		 *
		 * @since 1.0.0
		 */
		const REQUIRED_CAPABILITY = 'manage_options';

		/**
		 * Register callbacks for actions and filters
		 *
		 * @since    1.0.0
		 */
		public function register_hook_callbacks()
		{
			// Create Menu.
			add_action('admin_menu', array($this, 'plugin_menu'));

			// Enqueue Styles & Scripts.
			add_action('admin_print_scripts-' . static::$hook_suffix, array($this, 'enqueue_scripts'));
			add_action('admin_print_styles-' . static::$hook_suffix, array($this, 'enqueue_styles'));

			// Register Fields.
			add_action('load-' . static::$hook_suffix, array($this, 'register_fields'));

			// Register Settings.
			add_action('admin_init', array($this->get_model(), 'register_settings'));

			// Settings Link on Plugin's Page.
			add_filter(
				'plugin_action_links_' . Keto_Recipes::PLUGIN_ID . '/' . Keto_Recipes::PLUGIN_ID . '.php',
				array($this, 'add_plugin_action_links')
			);
		}

		/**
		 * Create menu for Plugin inside Settings menu
		 *
		 * @since    1.0.0
		 */
		public function plugin_menu()
		{
			// @codingStandardsIgnoreStart.
			static::$hook_suffix = add_options_page(
				__(Keto_Recipes::PLUGIN_NAME, Keto_Recipes::PLUGIN_ID),        // Page Title.
				__(Keto_Recipes::PLUGIN_NAME, Keto_Recipes::PLUGIN_ID),        // Menu Title.
				static::REQUIRED_CAPABILITY,           // Capability.
				static::SETTINGS_PAGE_SLUG,             // Menu URL.
				array($this, 'markup_settings_page') // Callback.
			);
			// @codingStandardsIgnoreEnd.
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts()
		{

			/**
			 * This function is provided for demonstration purposes only.
			 */

			wp_enqueue_script(
				Keto_Recipes::PLUGIN_ID . '_admin-js',
				Keto_Recipes::get_plugin_url() . 'assets/js/admin/keto-recipes.js',
				array('jquery'),
				Keto_Recipes::PLUGIN_VERSION,
				true
			);
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles()
		{

			/**
			 * This function is provided for demonstration purposes only.
			 */

			wp_enqueue_style(
				Keto_Recipes::PLUGIN_ID . '_admin-css',
				Keto_Recipes::get_plugin_url() . 'assets/css/admin/keto-recipes.css',
				array(),
				Keto_Recipes::PLUGIN_VERSION,
				'all'
			);
		}

		/**
		 * Creates the markup for the Settings page
		 *
		 * @since    1.0.0
		 */
		public function markup_settings_page()
		{
			if (current_user_can(static::REQUIRED_CAPABILITY)) {
				$this->view->admin_settings_page(
					array(
						'page_title'    => Keto_Recipes::PLUGIN_NAME,
						'settings_name' => $this->get_model()->get_plugin_settings_option_key(),
						'slug'	=> Keto_Recipes::PLUGIN_ID,
						'active' => isset($_GET['tab']) ? $_GET['tab'] : 'search',
						'tabs'	=> array(
							[
								'tab' 		=> 'search',
								'title' 	=> 'Search'
							]
						)
					)
				);
			} else {
				wp_die(__('Access denied.')); // WPCS: XSS OK.
			}
		}

		/**
		 * Registers settings sections and fields
		 *
		 * @since    1.0.0
		 */
		public function register_fields()
		{

			// Add Settings Page Section.
			add_settings_section(
				'keto_recipes_section',                    // Section ID.
				__('Settings', Keto_Recipes::PLUGIN_ID), // Section Title.
				array($this, 'markup_section_headers'), // Section Callback.
				static::SETTINGS_PAGE_SLUG                 // Page URL.
			);

			// Add Settings Page Field.
			add_settings_field(
				'keto_recipes_field',                                // Field ID.
				__('Keto Recipes Field:', Keto_Recipes::PLUGIN_ID), // Field Title.
				array($this, 'markup_fields'),                    // Field Callback.
				static::SETTINGS_PAGE_SLUG,                          // Page.
				'keto_recipes_section',                              // Section ID.
				array(                                              // Field args.
					'id'        => 'keto_recipes_field',
					'label_for' => 'keto_recipes_field',
				)
			);
		}

		/**
		 * Adds the section introduction text to the Settings page
		 *
		 * @param array $section Array containing information Section Id, Section
		 *                       Title & Section Callback.
		 *
		 * @since    1.0.0
		 */
		public function markup_section_headers($section)
		{
			$this->view->section_headers(
				array(
					'section'      => $section,
					'text_example' => __('This is a text example for section header', Keto_Recipes::PLUGIN_ID),
				)
			);
		}

		/**
		 * Delivers the markup for settings fields
		 *
		 * @param array $field_args Field arguments passed in `add_settings_field`
		 *                          function.
		 *
		 * @since    1.0.0
		 */
		public function markup_fields($field_args)
		{
			$field_id = $field_args['id'];
			$settings_value = $this->get_model()->get_setting($field_id);
			$this->view->markup_fields(
				array(
					'field_id'       => esc_attr($field_id),
					'settings_name'  => $this->get_model()->get_plugin_settings_option_key(),
					'settings_value' => !empty($settings_value) ? esc_attr($settings_value) : '',
				)
			);
		}

		/**
		 * Adds links to the plugin's action link section on the Plugins page
		 *
		 * @param array $links The links currently mapped to the plugin.
		 * @return array
		 *
		 * @since    1.0.0
		 */
		public function add_plugin_action_links($links)
		{
			$settings_link = '<a href="options-general.php?page=' . static::SETTINGS_PAGE_SLUG . '">' . __('Settings', Keto_Recipes::PLUGIN_ID) . '</a>';
			array_unshift($links, $settings_link);

			return $links;
		}
	}
}
