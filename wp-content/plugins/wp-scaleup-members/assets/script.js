jQuery(document).ready(function () {
    console.log("Welcome to ScaleUp Members CRUD Plugin");

    // Add Form Validation
    jQuery("#frm_add_member").validate();

    // Form Submit
    jQuery("#frm_add_member").on("submit", function (event) {
        event.preventDefault();
        var formdata = new FormData(this);
        jQuery.ajax({
            url: wcm_object.ajax_url,
            data: formdata,
            method: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });

    // Render Members
    loadMemberData();

    // Delete Function
    jQuery(document).on("click", ".btn_delete_member", function () {
        var memberId = jQuery(this).data("id");
        if (confirm("Are you sure you want to delete this member?")) {
            jQuery.ajax({
                url: wcm_object.ajax_url,
                data: {
                    action: "wcm_delete_member",
                    memId: memberId
                },
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        alert(response.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }
    });

    // Open Add Member Form
    jQuery(document).on("click", "#btn_open_add_member_form", function () {
        jQuery(".add_member_form").removeClass("hide_element");
        jQuery(this).addClass("hide_element");
    });

    // Close Add Member Form
    jQuery(document).on("click", "#btn_close_add_member_form", function () {
        jQuery(".add_member_form").addClass("hide_element");
        jQuery("#btn_open_add_member_form").removeClass("hide_element");
    });

    // Open Edit Layout
    jQuery(document).on("click", ".btn_edit_member", function () {
        jQuery(".edit_member_form").removeClass("hide_element");
        jQuery("#btn_open_add_member_form").addClass("hide_element");
        var memberId = jQuery(this).data("id");
        jQuery.ajax({
            url: wcm_object.ajax_url,
            data: {
                action: "wcm_get_member_data",
                memId: memberId
            },
            method: "GET",
            dataType: "json",
            success: function (response) {
                jQuery("#member_name").val(response?.data?.name);
                jQuery("#member_email").val(response?.data?.email);
                jQuery("#member_role").val(response?.data?.role);
                jQuery("#member_id").val(response?.data?.id);
                jQuery("#member_profile_icon").attr("src", response?.data?.profile_image);
            }
        });
    });

    // Close Edit Layout
    jQuery(document).on("click", "#btn_close_edit_member_form", function () {
        jQuery(".edit_member_form").addClass("hide_element");
        jQuery("#btn_open_add_member_form").removeClass("hide_element");
    });

    // Submit Edit Form
    jQuery(document).on("submit", "#frm_edit_member", function (event) {
        event.preventDefault();
        var formdata = new FormData(this);
        jQuery.ajax({
            url: wcm_object.ajax_url,
            data: formdata,
            method: "POST",
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    alert(response?.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
});

// Load All Members From DB Table
function loadMemberData() {
    jQuery.ajax({
        url: wcm_object.ajax_url,
        data: {
            action: "wcm_load_members_data"
        },
        method: "GET",
        dataType: "json",
        success: function (response) {
            var membersDataHTML = "";
            if (response.members.length > 0) {
                jQuery.each(response.members, function (index, member) {
                    let memberProfileImage = "—";
                    if (member.profile_image) {
                        memberProfileImage = `<img src="${member.profile_image}" height="80px" width="80px" style="border-radius: 50%; object-fit: cover;"/>`;
                    }
                    membersDataHTML += `
                        <tr>
                            <td>${member.id}</td>
                            <td>${member.name}</td>
                            <td>${member.email}</td>
                            <td>${member.role}</td>
                            <td>${memberProfileImage}</td>
                            <td>
                                <button data-id="${member.id}" class="btn_edit_member">Edit</button>
                                <button data-id="${member.id}" class="btn_delete_member">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                membersDataHTML = `<tr><td colspan="6" style="text-align: center;">No members found.</td></tr>`;
            }
            jQuery("#members_data_tbody").html(membersDataHTML);
        }
    });
}