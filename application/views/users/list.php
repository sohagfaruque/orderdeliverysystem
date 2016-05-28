<?php $data_all = json_decode($datainfo);
?>
<style>
    span.filterColumn {
    display: block;
    width: 89px;
}

.search_init {
    color: #999;
}
tfoot input, tfoot select {
    color: #444;
    margin: 0.5em 0;
    width: 100%;
}
table.display tfoot th {
    border-top: 1px solid black;
    font-weight: bold;
    padding: 3px 18px 3px 10px;
}
.table-responsive {
    min-height: 0.01%;
    overflow-x: auto;
}
</style>
<div class="right_countainer">
    <div class="title">Manage Users</div>
    <div class="impbutton">
        <a href="<?php echo base_url('users/add') ?>" title="Add New" class="btn btn-primary btn-sm"><i class="icon-search icon-white"></i>Add New</a>
        <a href="<?php echo base_url('dashboard') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box1">
        <div class="listing-page">
            <div class="panel-body table-responsive">


                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatable" id="area">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Contact Number</th>
                            <th>Orders</th>
                            <th>Preferred dist</th>
                            <th>Verified</th>
                            <th>App Version</th>
                            <th>City</th>
                            <th>Area</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_all->data as $key => $dataVal) { ?>
                            <tr class="odd gradeX">
                                <td><?php echo $dataVal->user_id; ?></td>
                                <td><?php echo $dataVal->contact_number; ?></td>
                                <td><?php echo $dataVal->orders; ?></td>
                                <td><?php echo $dataVal->preferred_distributor; ?></td>
                                <td><?php echo $dataVal->sms_verified; ?></td>
                                <td><?php echo $dataVal->app_version; ?></td>
                                <td><?php echo $dataVal->city; ?></td>
                                <td><?php echo $dataVal->area; ?></td>
                                <td><?php echo $dataVal->users_address; ?></td>
                                <td><?php echo $dataVal->status; ?></td>
                                <td><?php echo $dataVal->action; ?></td>
                            </tr>
                        <?php } ?>


                    </tbody>
                    <tfoot>
                        <tr>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>All city</th>
                            <th>All Area</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<!--modal valus-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="<?php echo base_url('assets/img/loading.gif'); ?>">
        </div>
    </div>
</div>

<?php $posturl = base_url() . 'users/getDataList'; ?>
<!--modal view-->
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "pagingType": "full_numbers"
        });
    });
</script>
<script>
    $(document).ready(function () {

        $('.datatable ').on("click", '.view', function () { //any Click on Delete icon
            var postVal = $(this).attr("data-value");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('users/view'); ?>",
                data: {postID: postVal},
                success: function (result) {
                    $('.modal').html(result);
                }
            });

        });
        return false;

    }
    );</script>
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

    $('.datatable').on("click", '.delete', function () { //any Click on Delete icon
        reset();
        var url = $(this).attr('href');
        var selector = $(this);
        alertify.confirm("Are You Sure to Delete?", function (e) {
            if (e) {
                $.post(url, function (data) {
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
<!-- status update start -->
<script type="text/javascript" lang="javascript">
    $(document).ready(function() {
        $('.datatable').on("click", '.update', function() { //any Click on update icon
            var url = $(this).attr('href');
            $.post(url, function(data) {
                if (data == 1) {
                    jSuccess('Information Updated Successfully !!');

                } else {
                    jError('System ERROR : please Contact Developer !');
                }
                 $('.datatable').dataTable().destroy();
            });
            return false;
        });
    });
</script>
<!--column filte-->
<script type='text/javascript' src='<?php echo base_url('assets/customjs') ?>/jquery.dataTables.columnFilter.js'></script> 
<!-- Data Table -->
<script src="<?php echo base_url('assets') ?>/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url('assets') ?>/datatables/DT_bootstrap.js"></script>
<script src="<?php echo base_url('assets') ?>/datatables/jquery.dataTables-conf.js"></script>


<!-- Custom JQuery -->
<script src="<?php echo base_url('assets/customjs') ?>/custom.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.datatable').dataTable()
                .columnFilter({
                    aoColumns: [
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        {type: "select", values: [<?php foreach($allcities as $cityVal){ echo "'".$cityVal->city_name_english."',";}?>]},
                        {type: "select", values: [<?php foreach($allareas as $areaVal){ echo "'".$areaVal->area_name_english."',";}?>]},
                        null,
                        null,
                        null,
                        null
                    ]

                });
    });

</script>