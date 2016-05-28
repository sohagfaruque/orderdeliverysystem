<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/js/dataTables/dataTables.css' />
<script src="<?php echo base_url('assets/js/dataTables/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables/dataTables.bootstrap.js'); ?>"></script>	
<script type='text/javascript' src='<?php echo base_url('assets/customjs/demo-modals.js'); ?>'></script> 
<div class="right_countainer">
    <div class="title">Manage Cities</div>
    <div class="impbutton">
        <a href="<?php echo base_url('cities/add')?>" title="Add New" class="btn btn-primary btn-sm"><i class="icon-search icon-white"></i>Add New</a>
        <a href="<?php echo base_url('dashboard')?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box1">
        <div class="listing-page">
            <div class="panel-body table-responsive">

                <table class="table table-striped table-bordered datatable" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <th>Total Area</th>
                            <th>Added Date</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                </table>       
            </div>
        </div>
    </div>
</div>
<!--modal valus-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="<?php echo base_url('assets/img/loading.gif');?>">
        </div>
    </div>
</div>
<?php $posturl = base_url() . 'cities/getDataList'; ?>
<script>
    $(document).ready(function () {
        var dataTable;
        dataTableDrow();
    });

    function dataTableDrow() {
        dataTable = $('.datatable').dataTable(
                {
                    "processing": true,
                    "serverSide": true,
                    "iDisplayLength": 10,
                    "iDisplayStart": <?php echo $this->session->userdata('start') == '' ? 0 : $this->session->userdata('start'); ?>,
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "sPaginationType": "full_numbers",
                    "sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
                    "ajax": {
                        "url": "<?php echo $posturl; ?>",
                        "type": "POST"
                    },
                    "columns": [
                        {"data": "serial"},
                        {"data": "city_name_english"},
                        {"data": "city_name_arabic"},
                        {"data": "total_areas"},
                        {"data": "createdDate"},
                        {"data": "action"}
                    ],
                    "aoColumnDefs": [
                        {"bSortable": false, "aTargets": [0]},
                        {"bSortable": false, "aTargets": [1]},
                        {"bSortable": false, "aTargets": [2]},
                        {"bSortable": false, "aTargets": [3]},
                        {"bSortable": false, "aTargets": [4]},
                        {"bSortable": false, "aTargets": [5]}

                    ]
                }
        );
        return dataTable;
    }
</script>  
<!--modal view-->
<script>
    $(document).ready(function () {

        $('.datatable ').on("click", '.view', function () { //any Click on Delete icon
            var postVal = $(this).attr("data-value");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cities/view'); ?>",
                data: {postID: postVal},
                success: function (result) {
                    $('.modal').html(result);
                }
            });

        });
        return false;

    });
</script>
<script>
    $(document).ready(function () {

        $('.datatable ').on("click", '.areaview', function () { //any Click on Delete icon
            var postVal = $(this).attr("data-value");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cities/areaview'); ?>",
                data: {postID: postVal},
                success: function (result) {
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