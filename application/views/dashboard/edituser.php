<?php foreach ($userValue as $data) {
    
} ?>

        
<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('home') ?>">Dashboard</a></li>
                <li class="active">edit user</li>
            </ol>

            <h1>Edit User</h1>
        </div>

        <div class="container">

            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4>Edit : <?php echo $data->name; ?></h4>
                    <div class="options">   
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                </div>
                <div class="panel-body collapse in">
                    <form action="<?php echo base_url('home/editUser') . '/' . $data->id; ?>" class="form-horizontal row-border" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="User Name" value="<?php echo $data->name; ?>">
                                <?php echo form_error('name', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" placeholder="User Email" value="<?php echo $data->email; ?>">
                                <?php echo form_error('email', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Password</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="password" placeholder="Keep Blank If Do not Want to Change">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type</label>
                            <div class="col-sm-6">
                                <select class="form-control" placeholder="Dropdown" name="type">
                                     <option value="">Please Slelect:</option>
                                    <option value="1" <?php if ($data->type == 1) echo 'selected="selected"'; ?>>Admin</options>
                                    <option value="2" <?php if ($data->type == 2) echo 'selected="selected"'; ?>>Editor</options>
                                    <option value="3" <?php if ($data->type == 3) echo 'selected="selected"'; ?>>Author</options>
                                </select>
                                <?php echo form_error('type', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-6">
                                <select class="form-control" placeholder="Dropdown" name="status">
                                     <option value="">Please Slelect:</option>
                                    <option value="1" <?php if ($data->status == 1) echo 'selected="selected"'; ?>>Active</options>
                                    <option value="0" <?php if ($data->status == 0) echo 'selected="selected"'; ?>>Inactive</options>
                                </select>
                                <?php echo form_error('status', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="btn-toolbar">
                                        <button class="btn-primary btn">Update</button>
                                        <a href="<?php echo base_url('home/userlist') ?>" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>


            <!-- Colorpicker Modal -->
        </div> <!-- container -->

    </div> <!--wrap -->
</div> <!-- page-content -->
<?php if (isset($successMsg)) { ?>
    <script>
        jSuccess('<?php echo $successMsg; ?>');

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>



