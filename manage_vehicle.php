<?php
require_once 'lib/php/database_handler/connection.php';
session_start();

// Set the current page for session tracking
$_SESSION['page'] = 'Manage Vehicle';

include_once 'lib/php/user_check.php';

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
         <h3 class="mb-3">Vehicle List</h3>
         <form id="set_vehicle" action="" method="post">
            <div class="container mt-2 mb-5">
               <!-- Flex container with gap between items -->
               <div class="d-flex justify-content-center gap-3 align-items-center">

                  <!-- First Flex: Select with floating label -->
                  <div class="form-floating w-100 w-md-50">
                     <select class="form-select" id="default_vehicle" aria-label="Floating label select example">

                     </select>
                     <label for="default_vehicle">Default Vehicle</label>
                  </div>

                  <!-- Second Flex: Submit Button -->
                  <div>
                     <button type="submit" name="set_vehicle_btn" id="set_vehicle_btn"
                        class="btn btn-primary px-4 py-2">Submit</button>
                  </div>

               </div>
            </div>
         </form>

         <a role="button" class="btn btn-primary mb-3" data-target="#add_vehicle" data-bs-toggle="modal"
            href="#add_vehicle"><i class="bi bi-plus-circle"></i> Add Vehicle</a>

         <table class="table">
            <thead>
               <tr>
                  <th scope="col">Vehicle Type</th>
                  <th scope="col">MV File</th>
                  <th scope="col">Body Number</th>
                  <th scope="col">Status</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $select = $pdo->prepare("SELECT * FROM vehicles WHERE user_id = " . $_SESSION['user_id']);
               $select->execute();
               while ($row = $select->fetch(PDO::FETCH_ASSOC)) {

                  switch ($row["vehicle_type"]) {
                     case 1:
                        $vehicle_type = 'Car';
                        break;
                     case 2:
                        $vehicle_type = 'Tricycle';
                        break;
                     case 3:
                        $vehicle_type = 'Motorcycle';
                        break;
                  }
                  ?>
                  <tr>
                     <td><?php echo $vehicle_type; ?></td>
                     <td><?php echo $row["mv_file"]; ?></td>
                     <td><?php echo $row["body_number"]; ?></td>
                     <td><?php echo $row["status"]; ?></td>
                     <?php
               }
               ?>
            </tbody>
         </table>
      </section>
   </main>

   <!-- Include scripts and footer -->
   <script type="text/javascript" src="assets/js/html5-qrcode.min.js"></script>
   <?php
   require_once 'assets/components/footer.php';
   require_once 'assets/components/main_scripts.php';
   require_once 'lib/php/components/modals.php';
   ?>
   <script>
      $(document).ready(function () {

         $("#add_vehicle_form").submit(function (event) {
            event.preventDefault();

            var add_vehicle_type = $("#add_vehicle_type").val();
            var add_mv_file = $("#add_mv_file").val();
            var add_body_number = $("#add_body_number").val();
            var add_vehicle_btn = $("#add_vehicle_btn").val();

            $.ajax({
               url: "lib/php/user/add_vehicle.php",
               method: "POST",
               data: {
                  add_vehicle_type,
                  add_mv_file,
                  add_body_number,
                  add_vehicle_btn
               },
               dataType: "json",
               success: function (data) {

                  $("#add_vehicle").modal("hide");

                  Swal.fire({
                     icon: "success",
                     title: "Vehicle has been added!",
                     text: "Refresh the page to see changes!"
                  });

               },
            });

         });


         $.ajax({
            url: 'lib/php/user/fetch_vehicle.php', // The PHP script that fetches data
            type: 'GET',
            success: function (data) {
               // Populate the dropdown with the options returned by PHP
               $('#default_vehicle').html(data);
            },
            error: function () {
               alert("Error loading data");
            }
         });

         $("#set_vehicle").submit(function (event) {
            event.preventDefault();

            var default_vehicle = $("#default_vehicle").val();
            var set_vehicle_btn = $("#set_vehicle_btn").val();

            $.ajax({
               url: "lib/php/user/add_vehicle.php",
               method: "POST",
               data: {
                  default_vehicle,
                  set_vehicle_btn,
               },
               dataType: "json",
               success: function (data) {

                  Swal.fire({
                     icon: "success",
                     title: "Vehicle Changed!",
                     text: "Refresh the page to see changes!"
                  });

               },
            });

         });

      });
   </script>
</body>

</html>