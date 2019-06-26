<?php // phpcs:ignore
/**
 * The plugin's bootstrap.
 *
 * @package           isiaToTop
 * @since             1.0.0
 * @link              https://github.com/vurghus-minar
 */

namespace AM\Isiatotop;

/**
 * Prevent direct access to file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Name: isiaToTop
 * Plugin URI:  https://github.com/vurghus-minar/wp_isiaToTop
 * Description: A versatile and mobile friendly 'scroll to top' plugin based on isiaToTop.
 * Version:     1.0.0
 * Author:      Vurghus Minar <vurghus.minar@outlook.com>
 * Author URI:  https://github.com/vurghus-minar
 * License:     GPL v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: isiatotop
 * Domain Path: /languages
 */

/**
 * The plugin class
 */
class Plugin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object   $instance
	 */
	private static $instance;

	/**
	 * The slug of this plugin.
	 *
	 * @since    1.0.0
	 * @access public
	 * @var      string    $slug
	 */
	public $slug;

	/**
	 * The base URL path (without trailing slash).
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $url    The base URL path of this plugin.
	 */
	private $url;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version
	 */
	private $version;

	/**
	 * The filesystem directory path fo this plugin file.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_dir
	 */
	private $plugin_dir;

	/**
	 * The frontend url that overrides public script and style.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $override_url
	 */
	private $override_url;

	/**
	 * Configuration object
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      object   $config
	 */
	public $config;

	/**
	 * Class constructor.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @param    array $config_array    Array of configuration.
	 */
	public function __construct( $config_array ) {
		$this->slug         = $config_array['slug'];
		$this->url          = $config_array['url'];
		$this->version      = $config_array['version'];
		$this->plugin_dir   = $config_array['plugin_dir'];
		$this->override_url = get_stylesheet_directory_uri() . "/config-$this->slug/";
		$this->config       = $this->get_config();
		$this->load_textdomain();
		add_action( 'wp_enqueue_scripts', array( $this, 'load_public_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_public_scripts' ) );

		add_filter( 'plugin_row_meta', array( $this, 'plugin_support_link' ), 10, 2 );

	}

	/**
	 * Registers all directories associated with the plugin and converts them to an object array.
	 *
	 * @since     1.0.0
	 * @access    private
	 */
	private function get_config() {
		return (object) [
			'language_dir' => $this->plugin_dir . '/languages',
			'text_domain'  => $this->slug,
			'core_url'     => (object) [
				'style'  => $this->url . '/assets/css/',
				'script' => $this->url . '/assets/js/',
			],
			'frontend_url' => (object) [
				'style'           => $this->url . '/assets/public/css/',
				'script'          => $this->url . '/assets/public/js/',
				'style_override'  => $this->override_url . '/css/',
				'script_override' => $this->override_url . '/js/',
			],
		];

	}

	/**
	 * Registers the plugin and returns a single instance of this class
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     array $config    Array of configuation.
	 */
	public static function init( $config ) {
		if ( null === self::$instance ) {
			self::$instance = new self( $config );
		}
	}

	/**
	 * Loads plugin's frontend styles.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function load_public_styles() {

		$custom_style_dir = $this->assets_override_directory_exists() ? $this->config->frontend_url->style_override : $this->config->frontend_url->style;
		wp_enqueue_style( $this->slug, $this->config->core_url->style . 'isiaToTop.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->slug . '-custom', $custom_style_dir . 'custom.css', array( $this->slug ), $this->version, 'all' );

	}

	/**
	 * Loads plugin's frontend scripts.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function load_public_scripts() {

		$custom_script_dir = $this->assets_override_directory_exists() ? $this->config->frontend_url->script_override : $this->config->frontend_url->script;
		wp_enqueue_script( $this->slug, $this->config->core_url->script . 'isiaToTop.min.js', array(), $this->version, true );
		wp_enqueue_script( $this->slug . '-init', $custom_script_dir . 'init.js', array( $this->slug ), $this->version, true );

	}

	/**
	 * Determines whether config-plugin directory exists in theme or child theme directory.
	 *
	 * @since    1.0.0
	 * @access    public
	 */
	public function assets_override_directory_exists() {
		if ( file_exists( get_stylesheet_directory() . "/config-$this->slug/" ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since     1.0.0
	 * @access    public
	 */
	public function load_textdomain() {

		load_plugin_textdomain(
			$this->config->text_domain,
			false,
			$this->config->language_dir
		);

	}

	/**
	 * Add link to the  list of links to display on the plugins page.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @param    array  $links    Array of existing links.
	 * @param    string $file    Name of plugin file.
	 */
	public function plugin_support_link( $links, $file ) {

		if ( strpos( $file, basename( __FILE__ ) ) !== false ) {
			$new_links = array(
				'support' => '<a href=https://github.com/vurghus-minar/wp_isiaToTop/issues>' . __( 'Support', $this->config->text_domain ) . '</a>',
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}

}

/**
 * Plugin configuration array
 */
$base_config = [
	'plugin_dir' => plugin_dir_path( __FILE__ ), // Get current plugin directory.
	'slug'       => 'isiatotop', // Plugin slug for text domain, settings, prefixes etc.
	'url'        => untrailingslashit( plugins_url( '/', __FILE__ ) ), // Plugin url.
	'version'    => '1.0.0', // Plugin version.
];

/**
 * Instantiate plugin
 */
\AM\Isiatotop\Plugin::init( $base_config );
