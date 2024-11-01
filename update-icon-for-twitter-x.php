<?php
/**
* Plugin Name: Update Icon for Twitter X
* Plugin URI:        https://wordpress.org/plugins/update-icon-for-twitter-x
* Description: Transform your website's Twitter icon into the latest stylish X icon effortlessly! 
* Version: 1.0.1
* Author: Narcis Bodea
* License: GPLv2 or later
* Text Domain: update-icon-for-twitter-x
* Requires Plugins: font-awesome
* Author Email: narcisbodea@gmail.com

*/

defined( 'WPINC' ) || die;

if (!function_exists('is_plugin_active')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

function utxi_check_required_plugin() {
    $required_plugin = 'font-awesome/index.php'; // Path to the required plugin


    if (!is_plugin_active($required_plugin)) {
        add_action('admin_notices', 'utxi_show_admin_notice');
    }
}

function utxi_show_admin_notice() {
    $plugin_slug = 'font-awesome'; // Slug of the required plugin
    $plugin_file = 'font-awesome/index.php'; // Path to the required plugin

    // Check if the plugin is installed
    if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
        $activation_url = wp_nonce_url('plugins.php?action=activate&plugin=' . $plugin_file, 'activate-plugin_' . $plugin_file);
        // translators: %s are opening and closing <a> tags respectively.
        $message = sprintf(__('The required Font Awesome plugin is not activated. <a href="%s">Click here to activate the required plugin.</a>', 'utxi-textdomain'), $activation_url);
    } else {
        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $plugin_slug), 'install-plugin_' . $plugin_slug);             // translators: %s are opening and closing <a> tags respectively.
        // translators: %s are opening and closing <a> tags respectively.
        $message = sprintf(__('The required Font Awesome plugin is not installed. <a href="%s">Click here to install the required plugin.</a>', 'utxi-textdomain'), $install_url);
    }

    echo '<div class="notice notice-error"><p>' . wp_kses_post($message) . '</p></div>';
}

function utxi_add_custom_css() {
    $required_plugin = 'font-awesome/index.php'; 
    if (is_plugin_active($required_plugin)) {
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'update-icon-for-twitter-x.css');
        wp_enqueue_style('utxi-custom-style', plugins_url('update-icon-for-twitter-x.css', __FILE__), array(), $css_version);
    }
}


function utxi_show_donation_notice() {
    $coffee = 'https://buymeacoffee.com/narcisbodea'; 
    $revolut = 'https://revolut.me/nicunatymj'; 
    $paypal = 'https://paypal.me/narcisbodea'; 
    // translators: %s are opening and closing <a> tags respectively.
    $message = sprintf(__('If you find <b>Update Icon for Twitter X</b> plugin useful, please consider making a donation to support its development and to support a development of a plugin to include a lot of other small fixes I found in almost 15 years working with wordpress websites. <a href="%1$s" target="_blank">Click here to donate by paypal.</a> or <a href="%2$s" target="_blank">Click here to donate by revolut.</a> or <a href="%3$s" target="_blank">Click here to buy me a coffee.</a>', 'utxi-textdomain'), $paypal, $revolut, $coffee);
    echo '<div class="notice notice-info"><p>' . wp_kses_post($message) . '</p></div>';
}

add_action('admin_init', 'utxi_check_required_plugin'); // Add CSS to the head of the website
add_action('admin_notices', 'utxi_show_donation_notice'); // Show donation message in admin dashboard
add_action('wp_enqueue_scripts', 'utxi_add_custom_css');
add_action('admin_enqueue_scripts', 'utxi_add_custom_css');


?>
