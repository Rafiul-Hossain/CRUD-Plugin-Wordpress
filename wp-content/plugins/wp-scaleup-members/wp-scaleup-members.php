<?php
/**
 * Plugin Name: WP ScaleUp Members
 * Description: This plugin performs CRUD Operations with a ScaleUp Members Table. It also creates a dynamic WordPress page with a shortcode on activation.
 * Version: 1.0
 * * Author: Rafiul Hossain 
 */

if (!defined("ABSPATH")) {
    exit;
}

define("WCM_DIR_PATH", plugin_dir_path(__FILE__));
define("WCM_DIR_URL", plugin_dir_url(__FILE__));

include_once WCM_DIR_PATH . "MyMembers.php";

// Create Class Object
$memberObject = new MyMembers();

// Create DB Table
register_activation_hook(__FILE__, [$memberObject, "callPluginActivationFunctions"]);

// Drop DB Table
//register_deactivation_hook(__FILE__, [$memberObject, "dropMembersTable"]);

// Register Shortcode
add_shortcode("wp-member-form", [$memberObject, "createMembersForm"]);

add_action("wp_enqueue_scripts", [$memberObject, "addAssetsToPlugin"]);

// Process Ajax Request (User is logged in)
add_action("wp_ajax_wcm_add_member", [$memberObject, "handleAddMemberFormData"]);
add_action("wp_ajax_wcm_load_members_data", [$memberObject, "handleLoadMembersData"]);
add_action("wp_ajax_wcm_delete_member", [$memberObject, "handleDeleteMemberData"]);
add_action("wp_ajax_wcm_get_member_data", [$memberObject, "handleToGetSingleMemberData"]);
add_action("wp_ajax_wcm_edit_member", [$memberObject, "handleUpdateMemberData"]);

// User is logged out (No login of WordPress)
// add_action("wp_ajax_nopriv_wcm_add_member", [$memberObject, "handleAddMemberFormData"]);
// add_action("wp_ajax_nopriv_wcm_load_members_data", [$memberObject, "handleLoadMembersData"]);
// add_action("wp_ajax_nopriv_wcm_delete_member", [$memberObject, "handleDeleteMemberData"]);
// add_action("wp_ajax_nopriv_wcm_get_member_data", [$memberObject, "handleToGetSingleMemberData"]);