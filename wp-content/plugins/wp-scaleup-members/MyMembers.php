<?php
class MyMembers {
    private $wpdb;
    private $table_name;
    private $table_prefix;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_prefix = $this->wpdb->prefix; // wp_
        $this->table_name = $this->table_prefix . "scaleup_members_table"; // wp_scaleup_members_table
    }

    // Create DB Table + WordPress Page
    public function callPluginActivationFunctions() {
        $collate = $this->wpdb->get_charset_collate();
        $createCommand = "
            CREATE TABLE `" . $this->table_name . "` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `email` varchar(50) DEFAULT NULL,
            `role` varchar(50) DEFAULT NULL,
            `profile_image` varchar(220) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) " . $collate . "
        ";

        require_once(ABSPATH . "/wp-admin/includes/upgrade.php");
        dbDelta($createCommand);

        // Wp Page
        $page_title = "ScaleUp Members System";
        $page_content = "[wp-member-form]";
        if (!get_page_by_title($page_title)) {
            wp_insert_post(array(
                "post_title" => $page_title,
                "post_content" => $page_content,
                "post_type" => "page",
                "post_status" => "publish"
            ));
        }
    }

    // Drop Table
    public function dropMembersTable() {
        $delete_command = "DROP TABLE IF EXISTS {$this->table_name}";
        $this->wpdb->query($delete_command);
    }

    // Render Member Form Layout
    public function createMembersForm() {
        ob_start();
        include_once WCM_DIR_PATH . "template/member_form.php";
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }

    // Add CSS / JS
    public function addAssetsToPlugin() {
        // Style
        wp_enqueue_style("member-crud-css", WCM_DIR_URL . "assets/style.css");

        // Validation
        wp_enqueue_script("wcm-validation", WCM_DIR_URL . "assets/jquery.validate.min.js", array("jquery"));

        // JS
        wp_enqueue_script("member-crud-js", WCM_DIR_URL . "assets/script.js", array("jquery"), "3.0", true);

        wp_localize_script("member-crud-js", "wcm_object", array(
            "ajax_url" => admin_url("admin-ajax.php")
        ));
    }

    // Process Ajax Request: Add Member Form
    public function handleAddMemberFormData() {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_text_field($_POST['email']);
        $role = sanitize_text_field($_POST['role']);

        $profile_url = "";
        if (isset($_FILES['profile_image']['name'])) {
            $UploadFile = $_FILES['profile_image'];
            $originalFileName = pathinfo($UploadFile['name'], PATHINFO_FILENAME);
            $file_extension = pathinfo($UploadFile['name'], PATHINFO_EXTENSION);
            $newImageName = $originalFileName . "_" . time() . "." . $file_extension;
            $_FILES['profile_image']['name'] = $newImageName;
            
            // wp_handle_upload() requires the 'upload_files' capability check and a nonce for security
            $fileUploaded = wp_handle_upload($_FILES['profile_image'], array("test_form" => false));
            
            if ($fileUploaded && !isset($fileUploaded['error'])) {
                $profile_url = $fileUploaded['url'];
            }
        }

        $this->wpdb->insert($this->table_name, [
            "name" => $name,
            "email" => $email,
            "role" => $role,
            "profile_image" => $profile_url
        ]);

        $member_id = $this->wpdb->insert_id;

        if ($member_id > 0) {
            wp_send_json([
                "status" => 1,
                "message" => "Successfully, member created"
            ]);
        } else {
            wp_send_json([
                "status" => 0,
                "message" => "Failed to save member"
            ]);
        }
    }

    /** Load DB Table Members */
    public function handleLoadMembersData() {
        $members = $this->wpdb->get_results(
            "SELECT * FROM {$this->table_name}",
            ARRAY_A
        );

        wp_send_json([
            "status" => true,
            "message" => "Members Data",
            "members" => $members
        ]);
    }

    // Delete Member Data
    public function handleDeleteMemberData() {
        $member_id = isset($_GET['memId']) ? intval($_GET['memId']) : 0;
        if ($member_id > 0) {
            $memberData = $this->getMemberData($member_id);
            if (!empty($memberData['profile_image'])) {
                $file_path = str_replace(get_site_url() . "/", "", $memberData['profile_image']);
                if (file_exists(ABSPATH . $file_path)) {
                    unlink(ABSPATH . $file_path);
                }
            }
            $this->wpdb->delete($this->table_name, ["id" => $member_id]);
            wp_send_json(["status" => true, "message" => "Member Deleted Successfully"]);
        } else {
            wp_send_json(["status" => false, "message" => "Invalid Member ID"]);
        }
    }

    // Read Single Member Data
    public function handleToGetSingleMemberData() {
        $member_id = isset($_GET['memId']) ? intval($_GET['memId']) : 0;
        if ($member_id > 0) {
            $memberData = $this->getMemberData($member_id);
            if ($memberData) {
                wp_send_json([
                    "status" => true,
                    "message" => "Member Data Found",
                    "data" => $memberData
                ]);
            } else {
                wp_send_json([
                    "status" => false,
                    "message" => "No Member found with this ID"
                ]);
            }
        } else {
            wp_send_json([
                "status" => false,
                "message" => "Please pass a member ID"
            ]);
        }
    }

    // Update Member Data
    public function handleUpdateMemberData() {
        $name = sanitize_text_field($_POST['member_name']);
        $email = sanitize_text_field($_POST['member_email']);
        $role = sanitize_text_field($_POST['member_role']);
        $id = sanitize_text_field($_POST['member_id']);

        $memberData = $this->getMemberData($id);
        $profile_image_url = $memberData['profile_image'] ?? "";

        $profile_file_image = $_FILES['member_profile_image']['name'] ?? "";

        if (!empty($profile_file_image)) {
            if (!empty($profile_image_url)) {
                $file_path = str_replace(get_site_url() . "/", "", $profile_image_url);
                if (file_exists(ABSPATH . $file_path)) {
                    unlink(ABSPATH . $file_path);
                }
            }

            $UploadFile = $_FILES['member_profile_image'];
            $originalFileName = pathinfo($UploadFile['name'], PATHINFO_FILENAME);
            $file_extension = pathinfo($UploadFile['name'], PATHINFO_EXTENSION);
            $newImageName = $originalFileName . "_" . time() . "." . $file_extension;
            $_FILES['member_profile_image']['name'] = $newImageName;

            $fileUploaded = wp_handle_upload($_FILES['member_profile_image'], array("test_form" => false));
            if ($fileUploaded && !isset($fileUploaded['error'])) {
                $profile_image_url = $fileUploaded['url'];
            }
        }

        $this->wpdb->update($this->table_name, [
            "name" => $name,
            "email" => $email,
            "role" => $role,
            "profile_image" => $profile_image_url
        ], ["id" => $id]);

        wp_send_json([
            "status" => true,
            "message" => "Member Updated successfully"
        ]);
    }

    // Get member Data
    private function getMemberData($member_id) {
        return $this->wpdb->get_row(
            $this->wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $member_id),
            ARRAY_A
        );
    }
}