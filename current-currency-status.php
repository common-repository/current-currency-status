<?php
/**
 * @package Current currency status
 * @version 1.0
 */
/*
  Plugin Name: Current currency status
  Description: Current currency status is all world current currency.
  Author: ifourtechnolab
  Version: 1.0
  Author URI: http://www.ifourtechnolab.com/
  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: cc-status-plugin
  Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Plugin Url.
 */
define('CC_STATUS_URL', plugin_dir_url(__FILE__));

/**
 * Plugin Path.
 */
define('CC_STATUS_PATH', plugin_dir_path(__FILE__));

/**
 * Current currency status Class.
 */
class Current_currency_status {

    /**
     * Plugin Name.
     * @var string 
     */
    public $name;
    
    /**
     * Plug-in Domain name.
     * @var type 
     */
    public $domain;

    /**
     * Current currency Status menu Page Section
     * @var string 
     */
    public $section;
    
    /**
     * Current currency Status Setting menu Page Configuration option group.
     * @var string 
     */
    public $option;

    /**
     * Current currency Status Documentation link URL.
     */
    const CCS_DOCUMENTATION = 'http://socialsharingapp.ifour-consultancy.net/wordpress/Documentation.txt';
    
    /**
     * Apply All Hook for Current currency Status initialize plugin.
     * @global type $wp_version
     */
    public function __construct() {
        global $wp_version;

        $this->domain = 'cc-status-plugin';
        $this->name =  'Current currency status';
        $this->section = 'ccStatusSection';
        $this->option = 'ccStatusOptions';

        /**
         * plug-in load hook
         */
        add_action( 'plugins_loaded', array($this,'cc_status_plugin_textdomain'));
        
        /**
         * Register All Scripts those are shown in both side when WP loaded
         */
        add_action( 'wp_loaded',array($this, 'register_all_scripts') );
        
        /**
         * Admin Initialize display admin panel fields hook.
         */
        add_action("admin_init", array($this, "ccStatus_display_admin_panel_fields"));
        
        /**
         * Admin-menu hook
         */
        add_action('admin_menu', array($this, 'ccStatus_plugin_setup_menu'));
        
        /**
         * Admin head hook
         */
        add_action( 'admin_head',array($this, 'ccStatus_admin_head'));
        
        /**
         * Admin-side Script call
         */
        add_action('admin_enqueue_scripts', array($this, 'ccStatus_script'));
        
        /**
         * Front-end side Script call
         */
        add_action('wp_enqueue_scripts', array($this, 'ccStatus_front_script'));
        
        /**
         * plug-in configuration link hook. 
         */
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'cc_status_configuration_link'));
        
        /**
         * Short code
         */
        add_shortcode( 'current-currency-status', array( $this, 'current_currency_status_shortcode' ) );
        
    }
    
    public function register_all_scripts() {
        wp_register_script('ccs-money-js',  CC_STATUS_URL . 'assets/js/money.js',array(),'1.0',true);
        $ccStatus = array(
            'apikey' => get_option('ccStatus_apikey'),
            'wrraper' => (is_admin() ? 1:0)
        );
        wp_register_script('ccstatus-js', CC_STATUS_URL . 'assets/js/ccstatus.js',array('jquery','ccs-money-js'),'1.0', true);
	wp_localize_script('ccstatus-js', 'ccStatus', $ccStatus);
    }
    
    public function current_currency_status_shortcode( $atts, $content = "" ) {
        
        /*$atts = shortcode_atts( array(
		'foo' => 'no foo',
		'baz' => 'default baz'
	), $atts, 'current-currency-status' );*/
        
        include CC_STATUS_PATH.'inc/ccs-front-end.php';
        return $content;
    }
    
    public function ccStatus_front_script() {
        wp_enqueue_style( 'ccs-front-end-style', CC_STATUS_URL. 'assets/css/ccs-front-end.css');
        wp_enqueue_script('ccs-money-js');
        wp_enqueue_script('ccstatus-js');
    }
    
    /**
     * Current currency Status Admin head add styling.
     */
    public function ccStatus_admin_head() {
        wp_enqueue_style('ccs-genericons',CC_STATUS_URL. 'assets/css/genericons.css');
    }
    
    /**
     * Load Text Domain of Current currency Status.
     */
    public function cc_status_plugin_textdomain() {
        load_plugin_textdomain( 'cc-status-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    
    /**
     * Add Current currency Status Scripts.
     */
    public function ccStatus_script() {
        wp_enqueue_script('ccs-money-js');
        wp_enqueue_script('ccstatus-js');
    }

    /**
     * Current currency Status plug-in menu configuration
     */
    public function ccStatus_plugin_setup_menu() {

        $title = apply_filters('ccStatus_menu_title', $this->name);
        //$capability = apply_filters('ccStatus_capability', 'edit_others_posts');
        $page = add_menu_page( __($title, 'cc-status-plugin') , __($title, 'cc-status-plugin'), 'manage_options', 'ccstatus', array($this, 'ccStatus_admin_page'), CC_STATUS_URL . "assets/images/ccs16x16.png", 9508);
        add_action('load-' . $page, array($this, 'ccStatus_help_tab'));
    }
    
    /**
     * Current currency Status Admin Panel configuration fields. 
     */
    public function ccStatus_display_admin_panel_fields() {
        add_settings_section($this->section, $this->name . " Settings", null, $this->option);

        add_settings_field("ccStatus_apikey", __("Add openexchangerates API Key", 'cc-status-plugin'), array($this, "display_apikey_setting"), $this->option, $this->section);

        register_setting($this->section, "ccStatus_apikey");
    }

    /**
     * Current currency Status configuration link create in plug-in manager list callback function.
     * @param array $links
     * @return array $links
     */
    public function cc_status_configuration_link($links) {
        $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=ccstatus')) . '">Configure</a>';
        return $links;
    }
    
    /**
     * Current currency Status Admin Page.
     */
    public function ccStatus_admin_page() {
        if(!current_user_can('manage_options')){
            wp_die('You do not have suggicient permission to access this page.');
        }
        include CC_STATUS_PATH.'inc/ccs-admin-layout.php';
    }

    /**
     * Current currency Status Help tab in top of Screen inside the Setting page callback function.
     */
    public function ccStatus_help_tab() {
        get_current_screen()->add_help_tab(array(
            'id' => 'documentation',
            'title' => __('Documentation', 'cc-status-plugin'),
            'content' => "<p><a href='".self::CCS_DOCUMENTATION."' target='blank'>".$this->name."</a></p>"
            )
        );
    }

    /**
     * Current currency Status deactivation callback function.
     */
    public function ccStatus_deactivation_hook() {
        if (function_exists('update_option')) {
            update_option('ccStatus_apikey', NULL);
        }
    }

    /**
     * Current currency Status un-install callback function.
     */
    public function ccStatus_uninstall_hook() {
        if (current_user_can('delete_plugins')) {
            delete_option('ccStatus_apikey');
        }
    }
}

 $ccStatus = new Current_currency_status();

register_deactivation_hook(__FILE__, array('Current_currency_status', 'ccStatus_deactivation_hook'));

register_uninstall_hook(__FILE__, array('Current_currency_status', 'ccStatus_uninstall_hook'));
?>