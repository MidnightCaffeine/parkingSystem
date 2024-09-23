<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col col-sm-9">
                <h2>Parking log</h2>
            </div>
            <div class="col col-sm-3">
                <input type="text" id="daterange_textbox" class="form-control" readonly />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-striped table-bordered" id="parking_table">
                <thead>
                    <tr>
                        <th>Parking #</th>
                        <th>Name</th>
                        <th>Plate Number</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Vehicle Type</th>
                        <th>Parking Date</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        fetch_data();

        function fetch_data(start_date = '', end_date = '') {
            var dataTable = $('#parking_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "lib/php/parking/fetch_parking_list.php",
                    type: "POST",
                    data: { action: 'fetch', start_date: start_date, end_date: end_date }
                }
            });
        }

        $('#daterange_textbox').daterangepicker({
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

            $('#parking_table').DataTable().destroy();

            fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

        });

    });

</script>