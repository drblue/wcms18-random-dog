<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       thehiveresistance.com
 * @since      1.0.0
 *
 * @package    Wcms18_Random_Dog
 * @subpackage Wcms18_Random_Dog/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wcms18_Random_Dog
 * @subpackage Wcms18_Random_Dog/includes
 * @author     Johan Nordström <jn@thehiveresistance.com>
 */
class Wcms18_Random_Dog {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wcms18_Random_Dog_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WCMS18_RANDOM_DOG_VERSION' ) ) {
			$this->version = WCMS18_RANDOM_DOG_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wcms18-random-dog';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// register widget
		$this->register_widget();

		// register ajax actions
		$this->register_ajax_actions();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wcms18_Random_Dog_Loader. Orchestrates the hooks of the plugin.
	 * - Wcms18_Random_Dog_i18n. Defines internationalization functionality.
	 * - Wcms18_Random_Dog_Admin. Defines all hooks for the admin area.
	 * - Wcms18_Random_Dog_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-random-dog-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-random-dog-i18n.php';

		/**
		 * The class responsible for the widget of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-random-dog-widget.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcms18-random-dog-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcms18-random-dog-public.php';

		$this->loader = new Wcms18_Random_Dog_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wcms18_Random_Dog_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wcms18_Random_Dog_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wcms18_Random_Dog_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wcms18_Random_Dog_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register the widget.
	 *
	 * @since    1.0.0
	 */
	public function register_widget() {
		add_action('widgets_init', function(){
			register_widget('Wcms18_Random_Dog_Widget');
		});
	}

	/**
	 * Register the ajax actions.
	 *
	 * @since    1.0.0
	 */
	public function register_ajax_actions() {
		// register action 'wcms18_random_dog__get'
		add_action('wp_ajax_wcms18_random_dog__get', [
			$this,
			'ajax_wcms18_random_dog__get'
		]);
		add_action('wp_ajax_nopriv_wcms18_random_dog__get', [
			$this,
			'ajax_wcms18_random_dog__get'
		]);
	}

	/**
	 * Respond to ajax action 'wcms18_random_dog__get'.
	 *
	 * @since    1.0.0
	 */
	public function ajax_wcms18_random_dog__get() {
		$response = wp_remote_get('https://random.dog/woof.json');
		if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
			wp_send_json_error([
				'error_code' => wp_remote_retrieve_response_code($response),
				'error_msg' => wp_remote_retrieve_response_message($response),
			]);
		}
		$body = wp_remote_retrieve_body($response);
		$content = json_decode($body);

		// 1. Find out path from URL
		$url_path = parse_url($content->url, PHP_URL_PATH);

		// 2. Find the file extension from the path
		$file_extension = pathinfo($url_path, PATHINFO_EXTENSION);  // JPG

		// 3. If extension is 'mp4' or 'ogv' or 'avi', set type to 'video'
		$video_extensions = ['mp4', 'ogv', 'avi'];

		$file_extension_lowercase = strtolower($file_extension); // jpg

		wp_send_json_success([
			'type' => in_array($file_extension_lowercase, $video_extensions) ? "video" : "image",
			'src' => $content->url,
		]);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wcms18_Random_Dog_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
