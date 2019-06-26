<?php
/**
 * @package IsiatotopTest
 *
 * Isiatotop test class.
 */
class IsiatotopTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		/**
		* Plugin configuration array
		*/
		$base_config          = [
			'plugin_dir' => plugin_dir_path( get_home_path() . 'wp-content/plugins/isiatotop/isiatotop.php' ), // Get current plugin directory.
			'slug'       => 'isiatotop', // Plugin slug for text domain, settings, prefixes etc.
			'url'        => untrailingslashit( plugins_url( '/', get_home_path() . 'wp-content/plugins/isiatotop/isiatotop.php' ) ), // Plugin url.
			'version'    => '1.0.0', // Plugin version.
		];
		$this->class_instance = new \AM\Isiatotop\Plugin( $base_config );

	}

	public function test_styles_are_enqueued() {
		$is_action_registered = has_action( 'wp_enqueue_scripts', array( $this->class_instance, 'load_public_styles' ) );
		$this->assertInternalType( 'int', $is_action_registered );
	}

	public function test_scripts_are_enqueued() {
		$is_action_registered = has_action( 'wp_enqueue_scripts', array( $this->class_instance, 'load_public_scripts' ) );
		$this->assertInternalType( 'int', $is_action_registered );
	}

	public function test_filter_contains_plugin_support_link() {
		$is_filter_registered = has_filter( 'plugin_row_meta', array( $this->class_instance, 'plugin_support_link' ) );
		$this->assertInternalType( 'int', $is_filter_registered );
		$links_array = $this->class_instance->plugin_support_link( array(), 'isiatotop.php' );
		$this->assertInternalType( 'array', $links_array );
		$this->assertArrayHasKey( 'support', $links_array );
	}


	public function test_config_array() {
		$this->assertInternalType( 'object', $this->class_instance->config );
		$this->assertEquals( 'http://example.org/wp-content/plugins/isiatotop/assets/public/css/', $this->class_instance->config->frontend_url->style );
	}

	public function test_assets_override_directory_exists() {
		$assets_dir = get_stylesheet_directory() . '/config-' . $this->class_instance->slug . '/';
		$this->assertFalse( $this->class_instance->assets_override_directory_exists() );
		mkdir( $assets_dir, 0755 );
		$this->assertTrue( $this->class_instance->assets_override_directory_exists() );
		rmdir( $assets_dir );
	}

	public function test_text_domain_is_loaded() {
		$this->markTestSkipped( 'must be revisited.' );
		$text_domain_loaded = is_textdomain_loaded( $this->class_instance->config->text_domain );
		$this->assertTrue( $text_domain_loaded );
	}

}
