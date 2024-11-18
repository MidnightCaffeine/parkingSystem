<?php
require_once 'lib/php/database_handler/connection.php';
session_start();

// Set the current page for session tracking
$_SESSION['page'] = 'System';
include_once 'lib/php/user_check.php';
include_once 'lib/php/only_admin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include external head components (meta, styles, etc.) -->
    <?php require_once 'assets/components/head.php'; ?>
</head>

<body>
    <!-- Include navigation bars -->
    <?php
    require_once 'assets/components/navigation.php';
    require_once 'assets/components/side_navigation.php';
    ?>

    <main id="main" class="main">
        <section class="section dashboard">
            <h3>Parking Slots</h3>
            <div class="row">
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="filter">
                            <a class="icon" id="motorcycle_edit"><i class="bi bi-pencil-square"></i></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Motorcycle</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="ri-motorbike-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="motorcycle_slot_text"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="filter">
                            <a class="icon" id="tricycle_edit"><i class="bi bi-pencil-square"></i></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Tricycle</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-minecart-loaded"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="tricycle_slot_text"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="filter">
                            <a class="icon" id="car_edit"><i class="bi bi-pencil-square"></i></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Car</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bxs-car'></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="car_slot_text"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>


    <?php
    require_once 'assets/components/footer.php';
    require_once 'assets/components/main_scripts.php';
    require_once 'lib/php/components/modals.php';
    ?>

    <script>
        $(document).ready(function () {

            var fetch = 'fetch';

            $.ajax({
                url: "lib/php/system/parking_slots.php",
                method: "POST",
                data: {
                    fetch,
                },
                dataType: "json",
                success: function (data) {
                    $("#motorcycle_slot_text").text(data.motorcycle_slot);
                    $("#tricycle_slot_text").text(data.tricycle_slot);
                    $("#car_slot_text").text(data.car_slot);
                },
            });

            // Save QR code as login
            $('#motorcycle_edit').click(function () {
                $("#motorcycle_modal").modal("show");
                var parking_id = 3;

                $.ajax({
                    url: "lib/php/system/parking_slots.php",
                    method: "POST",
                    data: {
                        parking_id,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#motorcycle_slot").val(data.slot_count);
                        $("#motorcycle_slot_id").val(parking_id);
                        $("#description").text(data.description);
                    },
                });
            });

            $('#tricycle_edit').click(function () {
                $("#tricycle_modal").modal("show");
                var parking_id = 5;

                $.ajax({
                    url: "lib/php/system/parking_slots.php",
                    method: "POST",
                    data: {
                        parking_id,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#tricycle_slot").val(data.slot_count);
                        $("#tricycle_slot_id").val(parking_id);
                        $("#tricycle_description").text(data.description);
                    },
                });
            });

            $('#car_edit').click(function () {
                $("#car_modal").modal("show");
                var parking_id = 4;

                $.ajax({
                    url: "lib/php/system/parking_slots.php",
                    method: "POST",
                    data: {
                        parking_id,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#car_slot").val(data.slot_count);
                        $("#car_slot_id").val(parking_id);
                        $("#car_description").text(data.description);
                    },
                });
            });

            $("#car_form").submit(function (event) {
                event.preventDefault();

                var slot_id = $("#car_slot_id").val();
                var slot = $("#car_slot").val();
                var save = $("#edit_info").val();

                $.ajax({
                    url: "lib/php/system/parking_slots.php",
                    method: "POST",
                    data: {
                        slot_id,
                        slot,
                        save
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#car_modal").modal("hide");
                        Swal.fire({
                            title: "Changes Saved!",
                            text: "Parking Slot Has Been Updated",
                            icon: "success",
                            showConfirmButton: true,
                        });
                        $.ajax({
                            url: "lib/php/system/parking_slots.php",
                            method: "POST",
                            data: {
                                fetch,
                            },
                            dataType: "json",
                            success: function (data) {
                                $("#motorcycle_slot_text").text(data.motorcycle_slot);
                                $("#tricycle_slot_text").text(data.tricycle_slot);
                                $("#car_slot_text").text(data.car_slot);
                            },
                        });
                    },
                });
            });

            $("#motorcycle_form").submit(function (event) {
                event.preventDefault();

                var slot_id = $("#motorcycle_slot_id").val();
                var slot = $("#motorcycle_slot").val();
                var save = $("#edit_info").val();

                $.ajax({
                    url: "lib/php/system/parking_slots.php",
                    method: "POST",
                    data: {
                        slot_id,
                        slot,
                        save
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#motorcycle_modal").modal("hide");
                        Swal.fire({
                            title: "Changes Saved!",
                            text: "Parking Slot Has Been Updated",
                            icon: "success",
                            showConfirmButton: true,
                        });
                        $.ajax({
                            url: "lib/php/system/parking_slots.php",
                            method: "POST",
                            data: {
                                fetch,
                            },
                            dataType: "json",
                            success: function (data) {
                                $("#motorcycle_slot_text").text(data.motorcycle_slot);
                                $("#tricycle_slot_text").text(data.tricycle_slot);
                                $("#car_slot_text").text(data.car_slot);
                            },
                        });
                    },
                });
            });

            $("#tricycle_form").submit(function (event) {
                event.preventDefault();

                var slot_id = $("#tricycle_slot_id").val();
                var slot = $("#tricycle_slot").val();
                var save = $("#edit_info").val();

                $.ajax({
                    url: "lib/php/system/parking_slots.php",
                    method: "POST",
                    data: {
                        slot_id,
                        slot,
                        save
                    },
                    dataType: "json",
                    success: function (data) {
                        $("#tricycle_modal").modal("hide");
                        Swal.fire({
                            title: "Changes Saved!",
                            text: "Parking Slot Has Been Updated",
                            icon: "success",
                            showConfirmButton: true,
                        });
                        $.ajax({
                            url: "lib/php/system/parking_slots.php",
                            method: "POST",
                            data: {
                                fetch,
                            },
                            dataType: "json",
                            success: function (data) {
                                $("#motorcycle_slot_text").text(data.motorcycle_slot);
                                $("#tricycle_slot_text").text(data.tricycle_slot);
                                $("#car_slot_text").text(data.car_slot);
                            },
                        });
                    },
                });
            });

        });
    </script>
</body>

</html>