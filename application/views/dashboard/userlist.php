<script src="<?php echo base_url('assets/js/dataTables/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables/dataTables.bootstrap.js'); ?>"></script>	
<script type='text/javascript' src='<?php echo base_url('assets/demo/demo-modals.js'); ?>'></script> 
<style>
    .dataTables_length{
        width: 78%;
        float: left;
    }
    .dataTables_filter{
        width: 21%;
        float: right;
    }
    .text-align-none{
        text-align: left;
    }
    .pagination {
        height: 36px;
        margin: 19px 168px;
    }

</style>

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li class='active'><a href="<?php echo base_url('home') ?>">Dashboard</a></li>
            </ol>

            <h1>Users</h1>
        </div>


        <div class="container">
            <div class="row">        
                <div class="col-md-12">
                    <div class="panel panel-grape">
                        <div class="panel-heading">
                            All Users
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Create Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>       
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->
<!--modal valus-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form class="" name="contact" style="margin: 0 0 20px;">
                    <label class="label" for="name">Your Name</label><br>
                    <input type="text" name="name" class="input-xlarge"><br>
                    <label class="label" for="email">Your E-mail</label><br>
                    <input type="email" name="email" class="input-xlarge"><br>
                    <label class="label" for="message">Enter a Message</label><br>
                    <textarea name="message" class="input-xlarge"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="#">Apply</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!--end modal-->
<?php $posturl = base_url() . 'home/getUserList'; ?>
<script>
    $(document).ready(function() {
        var dataTable;
        dataTableDrow();
    });

    function dataTableDrow() {
        //alert('s');
        dataTable = $('.datatable').dataTable(
                {
                    "processing": true,
                    "serverSide": true,
                    "iDisplayLength": 10,
                    "iDisplayStart": 0,
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "sPaginationType": "full_numbers",
                    "ajax": {
                        "url": "<?php echo $posturl; ?>",
                        "type": "POST"
                    },
                    "columns": [
                        {"data": "serial"},
                        {"data": "name"},
                        {"data": "email"},
                        {"data": "type"},
                        {"data": "status"},
                        {"data": "Cdate"},
                        {"data": "action"}
                    ],
                    "aoColumnDefs": [
                         {"bSortable": false, "aTargets": [0]},
                        {"bSortable": true, "aTargets": [1]},
                        {"bSortable": false, "aTargets": [2]},
                        {"bSortable": false, "aTargets": [3]},
                        {"bSortable": false, "aTargets": [4]},
                        {"bSortable": false, "aTargets": [5]},
                        {"bSortable": false, "aTargets": [6]}

                    ]
                }
        );
        return dataTable;
    }
</script>   
<!-- status update start -->
<script type="text/javascript" lang="javascript">
    $(document).ready(function() {
        $('#dataTable').on("click", '.update', function() { //any Click on update icon
            var url = $(this).attr('href');
            $.post(url, function(data) {
                if (data == 1) {
                    jSuccess('Information Updated Successfully !!');

                } else {
                    jError('System ERROR : please Contact Developer !');
                }
                dataTable.fnDraw();
            });
            return false;
        });
    });
</script>
<!--modal view-->
<script>
    $(document).ready(function() {
        $('.datatable ').on("click", '.view', function() { //any Click on Delete icon
            var userid = $(this).attr("data-value");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('home/userView'); ?>",
                data: {userid: userid},
                success: function(result) {
                    $('.modal').html(result);
                }
            });

        });
        return false;

    });
</script>

<script>
    function reset() {
        alertify.set({
            labels: {
                ok: "OK",
                cancel: "Cancel"
            },
            delay: 5000,
            buttonReverse: false,
            buttonFocus: "ok"
        });
    }

    $('#dataTable').on("click", '.delete', function() { //any Click on Delete icon
        reset();
        var url = $(this).attr('href');
        var selector = $(this);
        alertify.confirm("Are You Sure to Delete?", function(e) {
            if (e) {
                $.post(url, function(data) {
                    if (data == 1) {
                        $(selector).closest("tr").empty();
                        alertify.success("Information Deleted.");
                        dataTable.fnDraw();
                    }
                    if (data == 2) {
                        alertify.error("System Error.Please Let Us Know.");
                    }
                });
            } else {
            }
        });
        return false;
    });
</script>