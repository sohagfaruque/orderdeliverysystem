<?php
foreach ($dataValue as $data) {
    
}
?>
<div class="right_countainer">
    <div class="title">General settings</div>
    <div class="impbutton">
        <a href="<?php echo base_url('dashboard') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('generalsettings') ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">User Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $data->name ?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Email<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $data->email ?>">
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Password</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" placeholder="Keep Blank if you don't want to change" name="password" value="">
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">App Version<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="app_version" value="<?php echo $versionValue[0]->app_version; ?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Phone Verification<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="status">
                        <option value="">Please Select</option>
                        <option value="1"<?php echo $verificationValue[0]->status == 1 ? 'selected' : ''; ?>>Active</option>
                        <option value="0"<?php echo $verificationValue[0]->status == 0 ? 'selected' : ''; ?>>In active</option>
                    </select>
                    <?php echo form_error('status', '<p class="alert alert-danger">', '</p>'); ?>
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
<?php if (isset($successMsg)) { ?>
    <script>
        jSuccess('<?php echo $successMsg; ?>');
        window.location.replace("<?php echo base_url('generalsettings'); ?>");

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>