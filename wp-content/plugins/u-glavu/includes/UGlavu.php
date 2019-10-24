<?php

namespace UGlavu\Includes;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://uglavu.com
 * @since      1.0.0
 *
 * @package    U_Glavu
 * @subpackage U_Glavu/includes
 */
use UGlavu\Admin\UGlavuAdmin;
use function UGlavu\getContainer;
use UGlavu\Includes\Admin\Posts\Create\UGlavuAdminPostsCreateOgTags;
use UGlavu\Includes\Admin\Posts\Create\UGlavuAdminPostsCreateScrapeOgTags;
use UGlavu\Includes\Admin\Posts\Listing\UGlavuAdminPostsColumns;
use UGlavu\Includes\Admin\Posts\Listing\UGlavuAdminPostsFilter;
use UGlavu\Includes\Front\UGlavuFrontPostsExcerpt;
use UGlavu\Includes\Front\UGlavuFrontPostsPosts;
use UGlavu\PublicClass\UGlavuPublic;

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
 * @package    U_Glavu
 * @subpackage U_Glavu/includes
 * @author     U Glavu <info@uglavu.com>
 */
class UGlavu
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      UGlavuLoader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * @var \DI\Container
     */
    private $container;


    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->container = getContainer();
        if (defined('U_GLAVU_VERSION')) {
            $this->version = U_GLAVU_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'u-glavu';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - U_Glavu_Loader. Orchestrates the hooks of the plugin.
     * - U_Glavu_i18n. Defines internationalization functionality.
     * - U_Glavu_Admin. Defines all hooks for the admin area.
     * - U_Glavu_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        global $pagenow;

        $this->loader = $this->container->get(UGlavuLoader::class);

        if (is_admin()) {
            if (in_array($pagenow, ['edit.php'])) {
                $this->container->get(UGlavuAdminPostsFilter::class);
                $this->container->get(UGlavuAdminPostsColumns::class);
            }

            if (in_array($pagenow, ['post-new.php'])) {
                $this->container->get(UGlavuAdminPostsCreateOgTags::class);
                $this->container->get(UGlavuAdminPostsCreateScrapeOgTags::class);
            }
        } else {
            $this->container->get(UGlavuFrontPostsExcerpt::class);
            $this->container->get(UGlavuFrontPostsPosts::class);
        }

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the U_Glavu_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new UGlavuI18N();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new UGlavuAdmin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');


        if (is_admin()) {
            $scrapeOgTags = $this->container->get(UGlavuAdminPostsCreateScrapeOgTags::class);

            //ajax action for scraping tags
            $this->loader->add_action('wp_ajax_scrape_fb_og_tags', $scrapeOgTags, 'scrapeFbOgTags');
        }
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new UGlavuPublic($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    UGlavuLoader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
