<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/vurghus-minar
 * @since      1.0.0
 *
 * @package    Isiatotop
 * @subpackage Isiatotop/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Isiatotop
 * @subpackage Isiatotop/public
 * @author     Vurghus Minar <vurghus.minar@outlook.com>
 */
class Isiatotop_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	private $stylesheet_directory_exists;

	private $stylesheet_directory_uri;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->stylesheet_directory_exists = $this->stylesheet_directory_exists();
		$this->stylesheet_directory_uri = get_stylesheet_directory_uri() . '/config-isiaToTop/';

	}

	/**
	 * Determines whether config-isiaToTop directory exists within theme or child theme directory.
	 *
	 * @since    1.0.0
	 */
	private function stylesheet_directory_exists() {

		$config_directory = get_stylesheet_directory() . '/config-isiaToTop';

		if(file_exists($config_directory)){
			return true;
		} else {
			return false;
		}
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Isiatotop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Isiatotop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		/**
		 * If config-isiaToTop directory exists, enqueue css from that directory
		 */
		if ($this->stylesheet_directory_exists) {
			wp_enqueue_style( $this->plugin_name, $this->stylesheet_directory_uri . 'css/isiaToTop.min.css', array(), $this->version, 'all' );
		} else {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/isiaToTop.min.css', array(), $this->version, 'all' );
		}


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Isiatotop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Isiatotop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		/**
		 * If config-isiaToTop directory exists, enqueue js from that directory
		 */
		if ($this->stylesheet_directory_exists) {
			wp_enqueue_script( $this->plugin_name . 'isiaToTop_JS', $this->stylesheet_directory_uri . 'js/isiaToTop.min.js', array(), $this->version, true );

			wp_enqueue_script( $this->plugin_name, $this->stylesheet_directory_uri . 'js/isiaToTop.init.js', array( $this->plugin_name . 'isiaToTop_JS' ), $this->version, true );

		} else {
			wp_enqueue_script( $this->plugin_name . 'isiaToTop_JS', plugin_dir_url( __FILE__ ) . 'js/isiaToTop.min.js', array(), $this->version, true );

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/isiaToTop.init.js', array( $this->plugin_name . 'isiaToTop_JS' ), $this->version, true );
		}

	}

}