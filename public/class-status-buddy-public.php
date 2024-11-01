<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://stackoverflow.com/users/1713495/maulik-kanani
 * @since      1.0.0
 *
 * @package    Status_Buddy
 * @subpackage Status_Buddy/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Status_Buddy
 * @subpackage Status_Buddy/public
 * @author     Maulik Kanani <kanani.maulikb@gmail.com>
 */
class Status_Buddy_Public
{

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
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Status_Buddy_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Status_Buddy_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/status-buddy-public.css', array(), $this->version, 'all');
        wp_enqueue_style('dashicons');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * An instance of this class should be passed to the run() function
         * defined in Status_Buddy_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Status_Buddy_Loader will then create th erelationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/status-buddy-public.js', array('jquery'), $this->version, false);
        wp_enqueue_script('heartbeat');

    }
    /**
     * Set status of user when user initially login
     *
     * @since    1.0.0
     */
    public function sb_user_login($user_login = false, $user = array())
    {
        $user_id   = $user->data->ID;
        $cur_login = current_time(timestamp, 0);
        update_user_meta($user_id, '_sb_user_ststus', 'online');
        update_user_meta($user_id, '_sb_last_activity', $cur_login);
        return;
    }

    /**
     * Set status of user when user log out
     *
     * @since    1.0.0
     */
    public function sb_user_logout()
    {
        $userinfo = wp_get_current_user();
        update_user_meta($userinfo->ID, '_sb_user_ststus', 'offline');
        return;
    }

    /**
     * Set status of user when user initially login
     *
     * @since    1.0.0
     */
    public function sb_record_user_activity()
    {
        $user_id   = get_current_user_id();
        $cur_login = current_time('timestamp', 0);
        update_user_meta($user_id, '_sb_last_activity', $cur_login);
        return;
    }

    /**
     * Get all offline users
     *
     * @since    1.0.0
     */

    public function sb_user_offline()
    {
        $offline_users = array();
        $args          = array(
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key'     => '_sb_last_activity', //1492597131
                    'value'   => strtotime('-30 minutes'),
                    'compare' => '<=',
                ),
                array(
                    'key'     => '_sb_user_ststus',
                    'value'   => 'offline',
                    'compare' => '=',
                ),
            ),
        );
        $users = get_users($args);

        foreach ($users as $user) {
            update_user_meta($user->ID, '_sb_user_ststus', 'offline');
            $offline_users[] = $user->ID;
        }

        return apply_filters('sb_offline_users', $offline_users);
    }

    /**
     * Get all away users
     *
     * @since    1.0.0
     */

    public function sb_user_away()
    {
        $away_users = array();
        $args       = array(
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    array(
                        'relation' => 'AND',
                        array(
                            'key'     => '_sb_last_activity', //1492597131
                            'value'   => strtotime('-5 minutes'),
                            'compare' => '<=',
                        ),
                        array(
                            'key'     => '_sb_last_activity', //1492597131
                            'value'   => strtotime('-30 minutes'),
                            'compare' => '>',
                        ),
                    ),
                ),
                array(
                    'key'     => '_sb_user_ststus',
                    'value'   => 'away',
                    'compare' => '=',
                ),
            ),
        );
        $users = get_users($args);

        foreach ($users as $user) {
            update_user_meta($user->ID, '_sb_user_ststus', 'away');
            $away_users[] = $user->ID;
        }

        return apply_filters('sb_away_users', $away_users);
    }

    /**
     * Get all onine users
     *
     * @since    1.0.0
     */

    public function sb_user_online()
    {
        $online_users = array();
        $args         = array(
            'meta_query' => array(
                array(
                    'key'     => '_sb_user_ststus',
                    'value'   => 'online',
                    'compare' => '=',
                ),
            ),
        );
        $users = get_users($args);

        foreach ($users as $user) {
            $online_users[] = $user->ID;
        }

        return apply_filters('sb_online_users', $online_users);
    }

    /**
     * Change user status based on activity
     *
     * @since    1.0.0
     */

    public function sb_start_heartbeat($response, $data, $screen_id)
    {

        $user_id = get_current_user_id();
        if ($user_id) {
            $cur_login = current_time(timestamp, 0);
            update_user_meta($user_id, '_sb_user_ststus', 'online');
            update_user_meta($user_id, '_sb_last_activity', $cur_login);
        }
        $away_users               = $this->sb_user_away();
        $offline_users            = $this->sb_user_offline();
        $online_users             = $this->sb_user_online();
        $response['away_users']   = $away_users;
        $response['offline_user'] = $offline_users;
        $response['online_users'] = $online_users;
        return $response;
    }

/**
 * Display user status
 *
 * @since    1.0.0
 */

    public function sb_user_status()
    {

        $user_id = bp_get_member_user_id();
        if (get_user_meta($user_id, '_sb_user_ststus', true) == 'online') {
            $status_color = 'green';
        } else if (get_user_meta($user_id, '_sb_user_ststus', true) == 'away') {
            $status_color = 'orange';
        } else if (get_user_meta($user_id, '_sb_user_ststus', true) == 'offline') {
            $status_color = 'red';
        }

        $user_status = "<span id='sb_user_$user_id' class='dashicons dashicons-marker' style='color:$status_color'></span>";
        return apply_filters('sb_set_status_html', $user_status, $user_id);

    }

/**
 * Display user status before member name
 *
 * @since    1.0.0
 */
    public function sb_member_name_status($memeber)
    {
        $memeber .= " " . $this->sb_user_status();
        return apply_filters('sb_display_member_status', $memeber);

    }

/**
 * Set heartbit settings
 *
 * @since    1.0.0
 */
    public function wp_heartbeat_settings_3242($settings)
    {
        $settings['interval'] = 10; //Anything between 15-60
        return $settings;
    }

}
