<?php
namespace Keto_Recipes\Includes;

use Keto_Recipes as Keto_Recipes;

if ( ! class_exists( 'Dependency_Loader' ) ) {

	/**
	 * Includes all methods required for loading Plugin Dependencies
	 *
	 * @since      1.0.0
	 * @package    Keto_Recipes
	 * @subpackage Keto_Recipes/includes
	 * @author     Your Name <email@example.com>
	 */
	class Dependency_Loader {

		/**
		 * Loads all Plugin dependencies
		 *
		 * Converts Class parameter passed to the method into the file path & then
		 * `require_once` that path. It works with Class as well as with Traits.
		 *
		 * @param string $class Class need to be loaded.
		 * @since    1.0.0
		 */
		public function load_dependencies( $class ) {
			$parts = explode( '\\', $class );

			// Run this autoloader for classes related to this plugin only.
			if ( 'Keto_Recipes' !== $parts[0] ) {
				return;
			}

			// Remove 'Keto_Recipes' from parts.
			array_shift( $parts );

			$parts = array_map(
				function ( $part ) {
					return str_replace( '_', '-', strtolower( $part ) );
				}, $parts
			);

			$class_file_name = '/class-' . array_pop( $parts ) . '.php';

			$file_path = Keto_Recipes::get_plugin_path() . implode( '/', $parts ) . $class_file_name;

			if ( \file_exists( $file_path ) ) {
				require_once( $file_path );
				return;
			}

			$trait_file_name = '/trait-' . array_pop( $parts ) . '.php';

			$file_path = Keto_Recipes::get_plugin_path() . implode( '/', $parts ) . $trait_file_name;

			if ( \file_exists( $file_path ) ) {
				require_once( $file_path );
			}
		}

		/**
		 * Load All Registry Class Files
		 *
		 * @since    1.0.0
		 * @return void
		 */
		protected function load_registries() {
			require_once( Keto_Recipes::get_plugin_path() . 'core/registry/trait-base-registry.php' );
			require_once( Keto_Recipes::get_plugin_path() . 'core/registry/class-controller.php' );
			require_once( Keto_Recipes::get_plugin_path() . 'core/registry/class-model.php' );
		}

		/**
		 * Load Core MVC Classes
		 *
		 * @since    1.0.0
		 * @return void
		 */
		protected function load_core() {
			$this->load_registries();
			foreach ( glob( Keto_Recipes::get_plugin_path() . 'core/*.php' ) as $path ) {
				require_once $path;
			}
		}

		/**
		 * Method responsible to call all the dependencies
		 *
		 * @since 1.0.01
		 */
		protected function autoload_dependencies() {
			$this->load_core();
			spl_autoload_register( array( $this, 'load_dependencies' ) );
		}
	}

}
