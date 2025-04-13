<?php
/**
 * Malawi Bishops Theme Debugging File
 * 
 * Add this file to your theme directory for better debugging
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for Malawi Bishops Theme Debugging
 */
class Malawi_Bishops_Debug {
    
    /**
     * Singleton instance
     */
    private static $instance = null;
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        // Only run in debug mode
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            return;
        }
        
        // Add actions
        add_action('admin_footer', array($this, 'display_admin_debug_info'));
        add_action('wp_footer', array($this, 'display_frontend_debug_info'));
        
        // Log theme activation
        add_action('after_switch_theme', array($this, 'log_theme_activation'));
        
        // Check for required files
        $this->check_required_files();
        
        // Check stylesheets
        add_action('wp_enqueue_scripts', array($this, 'check_stylesheets'), 999);
    }
    
    /**
     * Log message to debug.log
     */
    public function log($message) {
        if (!defined('WP_DEBUG_LOG') || !WP_DEBUG_LOG) {
            return;
        }
        
        if (is_array($message) || is_object($message)) {
            error_log('[Malawi Bishops Theme] ' . print_r($message, true));
        } else {
            error_log('[Malawi Bishops Theme] ' . $message);
        }
    }
    
    /**
     * Check if required files exist
     */
    public function check_required_files() {
        $required_files = array(
            'assets/css/hero-slider.css',
            'assets/css/scroll-progress.css',
            'assets/css/bishops-grid.css',
            'assets/css/single-page.css',
            'assets/css/mobile-optimizations.css',
            'assets/css/responsive.css',
            'assets/css/scrolling-text.css',
            'assets/js/navigation.js',
            'assets/js/hero-slider.js',
            'assets/js/scroll-progress.js',
            'assets/js/header.js',
            'inc/template-functions.php',
            'inc/template-functions-extended.php',
            'inc/template-tags.php',
            'inc/customizer.php',
            'inc/customizer-additions.php',
            'inc/widgets.php'
        );
        
        foreach ($required_files as $file) {
            $file_path = get_template_directory() . '/' . $file;
            if (!file_exists($file_path)) {
                $this->log('Required file missing: ' . $file);
                
                if (strpos($file, 'css') !== false || strpos($file, 'js') !== false) {
                    $this->create_empty_file($file_path);
                }
            }
        }
    }
    
    /**
     * Create empty file to prevent 404 errors
     */
    private function create_empty_file($file_path) {
        $dir = dirname($file_path);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $handle = @fopen($file_path, 'w');
        if ($handle) {
            fwrite($handle, "/* Auto-created empty file */\n");
            fclose($handle);
            $this->log('Created empty file: ' . $file_path);
        }
    }
    
    /**
     * Check stylesheets for errors
     */
    public function check_stylesheets() {
        global $wp_styles;
        
        if (!is_object($wp_styles)) {
            return;
        }
        
        $theme_styles = array();
        foreach ($wp_styles->registered as $handle => $style) {
            if (strpos($handle, 'malawi-bishops') === 0) {
                $theme_styles[$handle] = $style->src;
            }
        }
        
        $this->log('Registered theme styles: ' . print_r($theme_styles, true));
    }
    
    /**
     * Display debug info in admin footer
     */
    public function display_admin_debug_info() {
        echo '<!-- Malawi Bishops Theme Debug Info -->';
        echo '<!-- Theme Version: ' . esc_html(MALAWI_BISHOPS_VERSION) . ' -->';
        echo '<!-- PHP Version: ' . esc_html(phpversion()) . ' -->';
        echo '<!-- WordPress Version: ' . esc_html(get_bloginfo('version')) . ' -->';
    }
    
    /**
     * Display debug info in frontend footer
     */
    public function display_frontend_debug_info() {
        echo '<!-- Malawi Bishops Theme Debug Info -->';
        echo '<!-- Theme Version: ' . esc_html(MALAWI_BISHOPS_VERSION) . ' -->';
        
        global $wp_scripts, $wp_styles;
        
        echo '<!-- Loaded Scripts: ' . count($wp_scripts->done) . ' -->';
        echo '<!-- Loaded Styles: ' . count($wp_styles->done) . ' -->';
    }
    
    /**
     * Log theme activation
     */
    public function log_theme_activation() {
        $this->log('Theme activated: Malawi Bishops Theme version ' . MALAWI_BISHOPS_VERSION);
    }
}

// Initialize the debugging class
Malawi_Bishops_Debug::get_instance();

/**
 * Helper function to log debug messages
 */
function malawi_bishops_debug($message) {
    Malawi_Bishops_Debug::get_instance()->log($message);
}
