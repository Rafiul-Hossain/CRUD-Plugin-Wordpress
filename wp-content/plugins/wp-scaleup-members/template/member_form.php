<div id="wp_scaleup_members_plugin">
    <div class="form-container add_member_form hide_element">
        <button id="btn_close_add_member_form" style="float: right;">Close Form</button>
        <h3>Add Member</h3>
        <form action="javascript:void(0)" id="frm_add_member" enctype="multipart/form-data">
            <input type="hidden" name="action" value="wcm_add_member">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" required name="name" placeholder="Member's Name" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" required name="email" placeholder="Member's Email" id="email">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select required name="role" id="role">
                    <option value="">-- Choose Role --</option>
                    <option value="founder">Founder</option>
                    <option value="manager">Manager</option>
                    <option value="developer">Developer</option>
                    <option value="designer">Designer</option>
                    <option value="marketer">Marketer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file">Profile Image</label>
                <input type="file" name="profile_image" id="file">
            </div>
            <div class="form-group">
                <button id="btn_save_data" type="submit">Save Data</button>
            </div>
        </form>
    </div>

    <div class="form-container edit_member_form hide_element">
        <button id="btn_close_edit_member_form" style="float: right;">Close Form</button>
        <h3>Edit Member</h3>
        <form action="javascript:void(0)" id="frm_edit_member" enctype="multipart/form-data">
            <input type="hidden" name="action" value="wcm_edit_member">
            <input type="hidden" name="member_id" id="member_id">
            <div class="form-group">
                <label for="member_name">Name</label>
                <input type="text" required name="member_name" placeholder="Member's Name" id="member_name">
            </div>
            <div class="form-group">
                <label for="member_email">Email</label>
                <input type="email" required name="member_email" placeholder="Member's Email" id="member_email">
            </div>
            <div class="form-group">
                <label for="member_role">Role</label>
                <select required name="member_role" id="member_role">
                    <option value="">-- Choose Role --</option>
                    <option value="founder">Founder</option>
                    <option value="manager">Manager</option>
                    <option value="developer">Developer</option>
                    <option value="designer">Designer</option>
                    <option value="marketer">Marketer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="member_profile_image">Profile Image</label>
                <input type="file" name="member_profile_image" id="member_file">
                <br>
                <img id="member_profile_icon" style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover; margin-top: 10px;" alt="Profile Image"/>
            </div>
            <div class="form-group">
                <button id="btn_update_data" type="submit">Update Member</button>
            </div>
        </form>
    </div>

    <div class="list-container">
        <button id="btn_open_add_member_form" style="float: right;">Add Member</button>
        <h3>ScaleUp Members</h3>
        <table>
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Profile Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="members_data_tbody"></tbody>
        </table>
    </div>
</div>