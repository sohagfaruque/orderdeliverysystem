<?php
foreach ($dataValue as $data) {
    
}
?>
<div class="right_countainer">
    <div class="title">Edit User</div>
    <div class="impbutton">
        <a href="<?php echo base_url('users') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('users/edit') . '/' . $data->id; ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $data->name ?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Contact Number<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="contact_number" value="<?php echo $data->contact_number ?>">
                    <?php echo form_error('contact_number', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Address<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="users_address"value="<?php echo $data->users_address ?>">
                    <?php echo form_error('users_address', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">App Version<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="app_version"value="<?php echo $data->app_version ?>">
                    <?php echo form_error('app_version', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Password</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" placeholder="Keep Blank if you don't want to change" name="password" value="">
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Email</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $data->email ?>">
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Status<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="status">
                        <option value="">Please Select</option>
                        <option value="1"<?php echo $data->status == 1 ? 'selected' : ''; ?>>Active</option>
                        <option value="0"<?php echo $data->status == 0 ? 'selected' : ''; ?>>In active</option>
                    </select>
                    <?php echo form_error('status', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Mobile Verification<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="sms_verified">
                        <option value="">Please Select</option>
                        <option value="1"<?php echo $data->sms_verified == 1 ? 'selected' : ''; ?>>Yes</option>
                        <option value="0"<?php echo $data->sms_verified == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                    <?php echo form_error('sms_verified', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Cities<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="city_id" onchange="getAvailabeAreas(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($cityValue as $cityVal) { ?>
                            <option value="<?php echo $cityVal->id; ?>"<?php echo $cityVal->id == $data->city_id ? 'selected' : ''; ?>><?php echo $cityVal->city_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('city_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Area<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" id="my-select" name="area" onchange="getPreferredDist(this.value);">
                        <option value=""></option>
                        <?php foreach ($areaValue as $areaVal) { ?>
                            <option value="<?php echo $areaVal->id; ?>"<?php echo $areaVal->id == $data->area ? 'selected' : ''; ?>><?php echo $areaVal->area_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('area', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Preferred Distributor</div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="preferred_distributor" id="dist_opt">
                        <option value="">None</option> 
                        <?php if ($preferredDistValue) { ?>
                        <option value="<?php echo $preferredDistValue[0]->dist_id ?>" selected="selected"><?php echo $preferredDistValue[0]->dist_name; ?></option> 
                            <?php
                        } else {
                            if ($getDistByArea) {
                                foreach ($getDistByArea as $distArVal) {
                                    $dist_id = $distArVal['dist_id'];
                                    $dist_name = $distArVal['dist_name'];
                                    ?>
                                    <option value="<?php echo $dist_id; ?>"><?php echo $dist_name; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                                <option value="">No distributor Found</option>
                                <?php
                            }
                        }
                        ?>


                    </select>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont"></div>
                <div class="tab col-lg-6">
                    <button class="btn-primary btn" id="submit">Update</button>
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
                url: "<?php echo base_url('users/getDistributorByArea') ?>",
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