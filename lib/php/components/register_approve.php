<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col col-sm-9">
                <h2>User Application</h2>
            </div>
            <div class="col col-sm-3">
                <input type="text" id="daterange" class="form-control" readonly />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-striped table-bordered" id="user_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Plate Number</th>
                        <th>Body Number</th>
                        <th>Vehicle Type</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        $("#edit_form").hide();

        fetch_user();

        function fetch_user(start_date = '', end_date = '') {
            var dataTable = $('#user_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "lib/php/database_handler/fetch_register.php",
                    type: "POST",
                    data: { action: 'fetch', start_date: start_date, end_date: end_date }
                }
            });
        }

        $('#daterange').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            format: 'YYYY-MM-DD'
        }, function (start, end) {

            $('#user_table').DataTable().destroy();

            fetch_user(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

        });


        $(document).on("click", ".view_user", function () {
            var user_id = $(this).attr("id");

            $.ajax({
                url: "lib/php/user/fetch_user.php",
                method: "POST",
                data: {
                    user_id,
                },
                dataType: "json",
                success: function (data) {
                    $("#user_form").modal("show");

                    $("#user_id").val(user_id);
                    $("#title").text(data.user_name);
                    $("#firstname").val(data.firstname);
                    $("#lastname").val(data.lastname);
                    $("#middlename").val(data.middlename);
                    $("#department").val(data.department);
                    $("#year_group").val(data.year_group);
                    $("#section").val(data.section);
                    $("#mv_file").val(data.mv_file);
                    $("#body_number").val(data.body_number);
                    $("#vehicle_type").val(data.vehicle_type);
                },
            });
        });


        $("#edit_info").change(function () {
            if ($("#edit_info").is(":checked")) {
                $("#edit_form").show();
            } else {
                $("#edit_form").hide();
            }
        });

    });

</script>