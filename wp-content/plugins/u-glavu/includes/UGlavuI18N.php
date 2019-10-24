<?php

namespace UGlavu\Includes;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://uglavu.com
 * @since      1.0.0
 *
 * @package    U_Glavu
 * @subpackage U_Glavu/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    U_Glavu
 * @subpackage U_Glavu/includes
 * @author     U Glavu <info@uglavu.com>
 */
class UGlavuI18N
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'u-glavu',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }


}
