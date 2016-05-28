<div class="right_countainer">
    <div class="title">Add User</div>
    <div class="impbutton">
        <a href="<?php echo base_url('dashboard') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('users/add'); ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Contact Number<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="contact_number" value="<?php echo set_value('contact_number') ?>">
                    <?php echo form_error('contact_number', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Address<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="users_address" value="<?php echo set_value('users_address') ?>">
                    <?php echo form_error('users_address', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Password</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="password" value="<?php echo set_value('password') ?>">
                    <?php echo form_error('password', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Email</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="email" value="<?php echo set_value('email') ?>">
                    <?php echo form_error('email', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Cities<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="city_id" onchange="getAvailabeAreas(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($cityValue as $cityVal) { ?>
                            <option value="<?php echo $cityVal->id; ?>"><?php echo $cityVal->city_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('product_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Area<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" id="my-select" name="area" onchange="getPreferredDist(this.value);">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Preferred Distributor</div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="preferred_distributor" id="dist_opt">
                        <option value="">None</option>

                    </select>
                </div>
            </div>

    </div>

    <div class="edit_box">
        <div class="cont"></div>
        <div class="tab col-lg-6">
            <button class="btn-primary btn" id="submit">Add</button>
        </div>
    </div>
</form>
</div>
</div>
<script>
    function getAvailabeAreas(id)
    {
        var id = id;
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('distributors/getAreaByCityId') ?>",
                data: {postID: id},
                success: function (result) {
                    $("#my-select").find('option').empty();
                    $("#my-select").html(result);
                }
            });
        } else {
            $("#my-select").find('option').empty();
        }
    }
</script>
<script>
    function getPreferredDist(id)
    {
        var id = id;
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('users/getDistributorByArea')?>",
                data: {postID: id},
                success: function (result) {
                    $("#dist_opt").find('option').empty();
                    $("#dist_opt").html(result);
                }
            });
        } else {
            $("#dist_opt").find('option').empty();
            $("#dist_opt").html("<option value=''>None</option>");
        }
    }
</script>
<?php if (isset($successMsg)) { ?>
    <script>
        jSuccess('<?php echo $successMsg; ?>');
        window.location.replace("<?php echo base_url('users'); ?>");

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>