<?php
session_start();
require_once '../database_handler/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}

if (isset($_POST['add_vehicle_btn'])) {

    $user_id = $_SESSION['user_id'];
    $vehicle_type = $_POST['add_vehicle_type'];
    $mv_file = $_POST['add_mv_file'];
    $body_number = $_POST['add_body_number'];

    $query = "INSERT INTO vehicles(user_id, mv_file, vehicle_type, body_number) values(:user_id, :mv_file, :vehicle_type, :body_number)";
    $insert = $pdo->prepare($query);
    $insert->bindParam(':user_id', $user_id);
    $insert->bindParam(':mv_file', $mv_file);
    $insert->bindParam(':vehicle_type', $vehicle_type);
    $insert->bindParam(':body_number', $body_number);
    $insert->execute();

    $output["response"] = "success";


    echo json_encode($output);

}

if (isset($_POST['set_vehicle_btn'])) {

    $user_id = $_SESSION['user_id'];
    $default_vehicle = $_POST['default_vehicle'];

    echo $default_vehicle;

    $select = $pdo->prepare(
        "SELECT * FROM vehicles WHERE vehicle_id = '" . $default_vehicle . "' LIMIT 1"
    );
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {

        $mv_file = $row['mv_file'];
        $vehicle_type = $row['vehicle_type'];

        $update = $pdo->prepare("UPDATE users SET mv_file = :mv_file, body_number = :body_number, vehicle_type = :vehicle_type WHERE user_id = :user_id");
        $update->bindparam('mv_file', $mv_file);
        $update->bindparam('body_number', $mv_file);
        $update->bindparam('vehicle_type', $vehicle_type);
        $update->bindparam('user_id', $user_id);
        $update->execute();
        $stats = true;

        $_SESSION['mv_file'] = $row['mv_file'];
        switch ($row['vehicle_type']) {
            case 1:
                $_SESSION['vehicle_type'] = 'Car';
                break;
            case 2:
                $_SESSION['vehicle_type'] = 'Tricycle';
                break;
            case 3:
                $_SESSION['vehicle_type'] = 'Motorcycle';
                break;
        }
        break;
    }

    $output["ou"] = "changed";


    echo json_encode($output);


}
?>

<script>

    var stats = '<?php echo $stats; ?>';
    if (stats == true) {
        Swal.fire({
            icon: "success",
            title: "Vehicle Changed!",
            text: "Refresh the page to see changes!"
        });
    }

</script>