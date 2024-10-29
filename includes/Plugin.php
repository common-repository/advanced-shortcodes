<?php

namespace AdvancedShortcodes;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * The main plugin class.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes
 */
class Plugin {

	/**
	 * Plugin file path.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $file;

	/**
	 * Plugin version.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	protected $version = '1.0.0';

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since 1.0.0
	 */
	public static $instance;

	/**
	 * Gets the single instance of the class.
	 * This method is used to create a new instance of the class.
	 *
	 * @param string $file The plugin file path.
	 * @param string $version The plugin version.
	 *
	 * @since 1.0.0
	 * @return static
	 */
	final public static function create( $file, $version = '1.0.0' ) {
		if ( null === self::$instance ) {
			self::$instance = new static( $file, $version );
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @param string $file The plugin file path.
	 * @param string $version The plugin version.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $file, $version ) {
		$this->file    = $file;
		$this->version = $version;
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define plugin constants.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function define_constants() {
		// Define the plugin version.
		if ( ! defined( 'ASCODES_VERSION' ) ) {
			define( 'ASCODES_VERSION', $this->version );
		}

		// Define the plugin file.
		if ( ! defined( 'ASCODES_FILE' ) ) {
			define( 'ASCODES_FILE', $this->file );
		}

		// Define the plugin path.
		if ( ! defined( 'ASCODES_PATH' ) ) {
			define( 'ASCODES_PATH', plugin_dir_path( ASCODES_FILE ) );
		}

		// Define the plugin URL.
		if ( ! defined( 'ASCODES_URL' ) ) {
			define( 'ASCODES_URL', plugin_dir_url( ASCODES_FILE ) );
		}

		// Define the plugin assets path.
		if ( ! defined( 'ASCODES_ASSETS_PATH' ) ) {
			define( 'ASCODES_ASSETS_PATH', ASCODES_PATH . 'assets/' );
		}

		// Define the plugin assets URL.
		if ( ! defined( 'ASCODES_ASSETS_URL' ) ) {
			define( 'ASCODES_ASSETS_URL', ASCODES_URL . 'assets/' );
		}
	}

	/**
	 * Include required files.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function includes() {
		require_once __DIR__ . '/functions.php';
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function init_hooks() {
		register_activation_hook( ASCODES_FILE, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'admin_notices', array( $this, 'display_flash_notices' ), 12 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Plugin activation hook.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function activate() {
		update_option( 'ascodes_version', ASCODES_VERSION );
		update_option( 'ascodes_shortcode_title', 'yes' );
		update_option( 'ascodes_shortcode_sub_title', 'yes' );
		update_option( 'ascodes_shortcode_content', 'yes' );
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'advanced-shortcodes', false, dirname( plugin_basename( ASCODES_FILE ) ) . '/languages/' );
	}

	/**
	 * Add a flash notice.
	 *
	 * @param string  $notice Notice message.
	 * @param string  $type This can be "info", "warning", "error" or "success", "success" as default.
	 * @param boolean $dismissible Whether the notice is-dismissible or not.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_flash_notice( $notice = '', $type = 'success', $dismissible = true ) {
		$notices          = get_option( 'ascodes_flash_notices', array() );
		$dismissible_text = ( $dismissible ) ? 'is-dismissible' : '';

		// Add new notice.
		array_push(
			$notices,
			array(
				'notice'      => wp_kses_post( $notice ),
				'type'        => sanitize_key( $type ),
				'dismissible' => $dismissible_text,
			)
		);

		// Update the notices array.
		update_option( 'ascodes_flash_notices', $notices );
	}

	/**
	 * Display flash notices after that, remove the option to prevent notices being displayed forever.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display_flash_notices() {
		$notices = get_option( 'ascodes_flash_notices', array() );

		foreach ( $notices as $notice ) {
			echo wp_kses_post(
				sprintf(
					'<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
					esc_attr( $notice['type'] ),
					esc_attr( $notice['dismissible'] ),
					esc_html( $notice['notice'] ),
				)
			);
		}

		// Reset options to prevent notices being displayed forever.
		if ( ! empty( $notices ) ) {
			delete_option( 'ascodes_flash_notices', array() );
		}
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'ascodes-frontend', ASCODES_ASSETS_URL . 'css/ascodes-frontend.css', array(), ASCODES_VERSION );
		}
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init() {
		new PostTypes();
		new Controllers\Shortcodes();

		if ( is_admin() ) {
			new Admin\Admin();
			new Admin\Actions();
		}
	}
}
