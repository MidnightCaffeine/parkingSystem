<?php
require_once 'lib/php/database_handler/connection.php';
session_start();
$_SESSION['page'] = "Users";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'assets/components/head.php'; ?>
</head>

<body>
    <?php

    include_once 'assets/components/navigation.php';
    include_once 'assets/components/side_navigation.php';

    ?>
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-9">
                            <h2>Users</h2>
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
                                    <th>Vehicle Type</th>
                                    <th>Department</th>
                                    <th>Section</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>


        </section>
    </main>

    <?php

    include_once 'assets/components/footer.php';
    include_once 'assets/components/main_scripts.php';
    include_once 'lib/php/components/modals.php';
    ?>
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

                if ($("#edit_info").is(":checked")) {
                    $('#edit_info').prop('checked', false);
                    $("#edit_form").hide();
                    $("#view_info").show();
                }

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

                        $("#name").text(data.name);
                        $("#year_section").text(data.year_section);
                        $("#dept").text(data.department);
                        $("#vehicle").text(data.vehicle);
                        $("#plate_num").text(data.mv_file);
                        $("#body_num").text(data.body_number);
                    },
                });
            });


            $("#edit_info").change(function () {
                if ($("#edit_info").is(":checked")) {
                    $("#edit_form").show();
                    $("#view_info").hide();
                } else {
                    $("#edit_form").hide();
                    $("#view_info").show();
                }
            });

            $(document).on("click", ".delete_user", function () {
                var user_id = $(this).attr("id");

                Swal.fire({
                    title: "Decline this user?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, decline!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "lib/php/user/delete_user.php",
                            method: "POST",
                            data: {
                                user_id,
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: "Declined!",
                                    text: "User has been declined",
                                    icon: "success",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                });
                                $("#user_table").DataTable().ajax.reload();
                            },
                        });
                    }
                });
            });

            $(document).on("click", ".approve", function () {
                var user_id = $(this).attr("id");
                var approve = true;

                Swal.fire({
                    title: "Authenticate this user?",
                    text: "All informations are matched?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, approve!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "lib/php/user/update_user.php",
                            method: "POST",
                            data: {
                                user_id,
                                approve,
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: "Approved!",
                                    text: "User has been approved!",
                                    icon: "success",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                });
                                $("#user_table").DataTable().ajax.reload();
                            },
                        });
                    }
                });
            });

            $("#registration_form").submit(function (event) {
                event.preventDefault();

                var firstname = $("#firstname").val();
                var lastname = $("#lastname").val();
                var middlename = $("#middlename").val();
                var department = $("#department").val();
                var year_group = $("#year_group").val();
                var section = $("#section").val();
                var mv_file = $("#mv_file").val();
                var body_number = $("#body_number").val();
                var vehicle_type = $("#vehicle_type").val();
                var user_id = $("#user_id").val();
                var edit_info = $("#edit_info").val();


                $.ajax({
                    url: "lib/php/user/update_user.php",
                    method: "POST",
                    data: {
                        firstname,
                        lastname,
                        middlename,
                        department,
                        year_group,
                        section,
                        mv_file,
                        body_number,
                        vehicle_type,
                        user_id,
                        edit_info,
                    },
                    success: function (data) {
                        Swal.fire({
                            title: "Successful!",
                            text: "User information has been updated!",
                            icon: "success",
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        });
                        $("#user_table").DataTable().ajax.reload();
                        $("#user_form").modal("hide");
                    },
                });

            });

        });

    </script>

</body>

</html>