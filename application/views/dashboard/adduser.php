

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('home') ?>">Dashboard</a></li>
                <li>Form</li>
                <li class="active">add user</li>
            </ol>

            <h1>Add New User</h1>
        </div>

        <div class="container">

            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4>New User Add Form</h4>
                    <div class="options">   
                        <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                    </div>
                </div>
                <div class="panel-body collapse in">
                    <form action="<?php echo base_url('home/adduser') ?>" class="form-horizontal row-border" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="User Name" value="<?php echo set_value('name')?>">
                                <?php echo form_error('name', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Email</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email')?>">
                                <?php echo form_error('email', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <?php echo form_error('password', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Type</label>
                            <div class="col-sm-6">
                                <select class="form-control" placeholder="Dropdown" name="type">
                                     <option value="">Please Slelect:</option>
                                      <option value="1">Admin</option>
                                      <option value="2">Editor</option>
                                      <option value="3">Author</option>
                                </select>
                                <?php echo form_error('type', '<p class="help-inline">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="btn-toolbar">
                                        <button class="btn-primary btn">Submit</button>
                                        <a href="<?php echo base_url('category') ?>" class="btn btn-default">Cancel</a>
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
<?php if(isset($successMsg)){?>
    <script>
jSuccess('<?php echo $successMsg;?>');
 window.location.replace("<?php echo base_url('home/userlist');?>");
			
</script>
<?php }?>
<?php if(isset($errorMsg)){?>
    <script>
jError('<?php echo $errorMsg;?>');
			
</script>
<?php }?>

