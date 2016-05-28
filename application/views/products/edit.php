<?php
foreach ($dataValue as $data) {
    
}
?>
<div class="right_countainer">
    <div class="title">Edit Product</div>
    <div class="impbutton">
        <a href="<?php echo base_url('products') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('products/edit') . '/' . $data->id; ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $data->name ?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
             <div class="edit_box">
                <div class="cont">Quantity<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="quantity">
                        <option value="">Please Select</option>
                        <?php for ($i = 1; $i < 200; $i++) { ?>
                            <option value="<?php echo $i; ?>"<?php echo $data->quantity== $i?'selected':'';?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('quantity', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Price<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="price" value="<?php echo $data->price ?>">
                    <?php echo form_error('price', '<p class="alert alert-danger">', '</p>'); ?>
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
        window.location.replace("<?php echo base_url('products'); ?>");

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>