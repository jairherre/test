<?php



if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use LMS\Elementor\Widgets\All_Courses;
use LMS\Elementor\Widgets\Lesson_Resources;
use LMS\Elementor\Widgets\Lessons_List;

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class ElementorExt
{

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var ElementorExt The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     * @return ElementorExt An instance of the class.
     */
    public static function instance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct()
    {

        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function i18n()
    {

        load_plugin_textdomain('elementor-test-extension');
    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init()
    {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Add Plugin actions
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
        // add_action('elementor/controls/controls_registered', [$this, 'init_controls']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension'),
            '<strong>' . esc_html__('LMS Plugin', 'lms') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'lms') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'lms'),
            '<strong>' . esc_html__('LMS Plugin Extension', 'lms') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'lms') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    function add_elementor_widget_categories($elements_manager)
    {

        $elements_manager->add_category(
            'lms-category',
            [
                'title' => __('LMS widgets', 'lms'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'lms'),
            '<strong>' . esc_html__('LMS Plugin', 'lms') . '</strong>',
            '<strong>' . esc_html__('PHP', 'lms') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init_widgets()
    {

        require_once( __DIR__ . '/elementor/widget-abstract.php' );

		// Include Widget files
		require_once( __DIR__ . '/elementor/widget-all-courses.php' );
		require_once( __DIR__ . '/elementor/widget-lessons-list.php' );

		// require_once( __DIR__ . '/elementor/widget-course-title.php' );
		// require_once( __DIR__ . '/elementor/widget-course-content.php' );
		// require_once( __DIR__ . '/elementor/widget-lesson-title.php' );
		// require_once( __DIR__ . '/elementor/widget-lesson-content.php' );
		// require_once( __DIR__ . '/elementor/widget-lesson-excerpt.php' );
		require_once( __DIR__ . '/elementor/widget-lesson-resources.php' );
		require_once( __DIR__ . '/elementor/widget-navigation.php' );
		require_once( __DIR__ . '/elementor/widget-progress.php' );
		// require_once( __DIR__ . '/elementor/widget-user-courses.php' );
		require_once( __DIR__ . '/elementor/widget-video.php' );
		require_once( __DIR__ . '/elementor/widget-button.php' );

        // Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new All_Courses());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Lessons_List());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Lesson_Resources());

		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Course_Title());
        // \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Title_Widget());
        // \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Excerpt_Widget());
        // \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Content_Widget());
        // \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Course_Content_Widget());

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Button_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Video_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Progress_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor_Navigation_Widget());
    }
}

ElementorExt::instance();
