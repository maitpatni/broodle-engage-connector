<?php
/**
 * Uninstall script for Broodle Engage Connector
 * Clean up all plugin data on uninstall
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) || WP_UNINSTALL_PLUGIN !== plugin_basename( __FILE__ ) ) {
    exit;
}

// Delete options
delete_option( 'broodle_engage_settings' );
delete_option( 'broodle_engage_api_credentials' );
delete_option( 'broodle_engage_last_delayed_check' );
delete_option( 'broodle_engage_db_version' );

// Delete transients
delete_transient( 'broodle_engage_api_call_count' );
delete_transient( 'broodle_engage_api_reset_time' );
delete_transient( 'broodle_engage_rate_limit_info' );

// Delete notification logs table
global $wpdb;
$table_name = $wpdb->prefix . 'broodle_engage_notifications';
$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

// Delete order meta for all orders
$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key IN ('_broodle_engage_last_status', '_broodle_engage_notification_sent')" );

// Clear scheduled cron events
wp_clear_scheduled_hook( 'broodle_engage_send_delayed_notification' );
