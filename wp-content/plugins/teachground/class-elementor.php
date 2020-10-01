<?php
/**
 * Elementor integration class
 *
 * @package TeachGround
 */

namespace TeachGround\Elementor;

use Elementor\Elements_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use TeachGround\Elementor\Widgets\Course_List;
use TeachGround\Elementor\Widgets\Course_Progress;
use TeachGround\Elementor\Widgets\Lesson_Complete_Button;
use TeachGround\Elementor\Widgets\Lesson_Index;
use TeachGround\Elementor\Widgets\Lesson_List;
use TeachGround\Elementor\Widgets\Lesson_Resources;
use TeachGround\Elementor\Widgets\Lesson_Video;

defined( 'ABSPATH' ) || exit;

final class Integration {

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
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
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
    public function __construct() {
        add_action( 'plugins_loaded', [$this, 'init'] );
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
    public function init() {

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
        add_action( 'elementor/elements/categories_registered', [$this, 'register_category'] );
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
            '<strong>' . esc_html__('TeachGround Plugin', 'teachground') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'teachground') . '</strong>'
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
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'teachground'),
            '<strong>' . esc_html__('TeachGround Plugin Extension', 'teachground') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'teachground') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

    public function register_category( Elements_Manager $elements_manager ) {
        $elements_manager->add_category(
            'teachground-category',
            [
                'title' => __( 'TeachGround', 'teachground' ),
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
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'teachground'),
            '<strong>' . esc_html__('TeachGround Plugin', 'teachground') . '</strong>',
            '<strong>' . esc_html__('PHP', 'teachground') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Register elementor widget
	 *
	 * @param Widget_Base $widget
	 * @return void
	 */
	protected function register_widget( Widget_Base $widget ) {
		Plugin::instance()->widgets_manager->register_widget_type( $widget );
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
    public function init_widgets() {

        // Include Widget files
        // require_once(__DIR__ . '/elementor/widgets/title-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/course-title-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/excerpt-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/content-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/course-content-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/resource-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/button-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/video-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/list-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/progress-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/user-list-widget.php');
        // require_once(__DIR__ . '/elementor/widgets/all-courses-widget.php');
		// require_once(__DIR__ . '/elementor/widgets/navigation-widget.php');

		require_once __DIR__ . '/elementor/widget-abstract.php';
		require_once __DIR__ . '/elementor/widget-course-list.php';
		require_once __DIR__ . '/elementor/widget-lesson-resources.php';
		require_once __DIR__ . '/elementor/widget-lesson-list.php';
		require_once __DIR__ . '/elementor/widget-lesson-complete-button.php';
		require_once __DIR__ . '/elementor/widget-lesson-index.php';
		require_once __DIR__ . '/elementor/widget-course-progress.php';
		require_once __DIR__ . '/elementor/widget-lesson-video.php';

        // Register widget
    	// $this->register_widget( new \Elementor_Title_Widget() );
        // $this->register_widget( new \Elementor_Excerpt_Widget() );
        // $this->register_widget( new \Elementor_Content_Widget() );
        // $this->register_widget( new \Elementor_Course_Content_Widget() );
		// $this->register_widget( new \Elementor_Course_Title_Widget() );
		$this->register_widget( new Course_List() );
		$this->register_widget( new Course_Progress() );
		$this->register_widget( new Lesson_List() );
        $this->register_widget( new Lesson_Resources() );
        $this->register_widget( new Lesson_Complete_Button() );
		$this->register_widget( new Lesson_Video() );
		$this->register_widget( new Lesson_Index() );
    }
}

Integration::instance();
