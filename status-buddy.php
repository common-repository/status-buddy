<?php

/**
 * @link              http://stackoverflow.com/users/1713495/maulik-kanani
 * @since             1.0.0
 * @package           Status_Buddy
 *
 * @wordpress-plugin
 * Plugin Name:       Status Buddy
 * Plugin URI:        https://github.com/maulikkanani
 * Description:       This is a plugin which is used for display current status of Buddypress member.
 * Version:           1.0.0
 * Author:            Maulik Kanani
 * Author URI:        http://stackoverflow.com/users/1713495/maulik-kanani
 * License:           GPL-2.0+
 * Requires at least: WordPress 2.9.1 / BuddyPress 1.2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       status-buddy
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-status-buddy-activator.php
 */
function activate_status_buddy()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-status-buddy-activator.php';
    Status_Buddy_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-status-buddy-deactivator.php
 */
function deactivate_status_buddy()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-status-buddy-deactivator.php';
    Status_Buddy_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_status_buddy');
register_deactivation_hook(__FILE__, 'deactivate_status_buddy');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-status-buddy.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_status_buddy()
{

    $plugin = new Status_Buddy();
    $plugin->run();

}
run_status_buddy();

function pr($data = array(), $exti = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exti != false) {
        exit;
    }

}
