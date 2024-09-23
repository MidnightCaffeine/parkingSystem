<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=parking_system", "root", "");

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {
        $order_column = array('parking_id', 'user_id', 'parking_date');

        $main_query = "
		SELECT * FROM parking_log 
		";

        $search_query = 'WHERE parking_date <= "' . date('Y-m-d') . '" AND ';

        if (isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '') {
            $search_query .= 'parking_date >= "' . $_POST["start_date"] . '" AND parking_date <= "' . $_POST["end_date"] . '" AND ';
        }

        if (isset($_POST["search"]["value"])) {
            $search_query .= '(parking_id LIKE "%' . $_POST["search"]["value"] . '%" OR user_id LIKE "%' . $_POST["search"]["value"] . '%" OR parking_date LIKE "%' . $_POST["search"]["value"] . '%")';
        }



        $group_by_query = " GROUP BY parking_date ";

        $order_by_query = "";

        if (isset($_POST["order"])) {
            $order_by_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_by_query = 'ORDER BY parking_date DESC ';
        }

        $limit_query = '';

        if ($_POST["length"] != -1) {
            $limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $statement = $connect->prepare($main_query . $search_query . $group_by_query . $order_by_query);

        $statement->execute();

        $filtered_rows = $statement->rowCount();

        $statement = $connect->prepare($main_query . $group_by_query);

        $statement->execute();

        $total_rows = $statement->rowCount();

        $result = $connect->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

        $data = array();

        foreach ($result as $row) {
            $count = 1;
            $sub_array = array();
            $sub_array[] = $count;
            $sub_array[] = $row['username'];
            $sub_array[] = $row['user_mv_file'];
            $sub_array[] = $row['time_in'];
            $sub_array[] = $row['time_out'];

            switch ($row['vehicle_type']) {
                case 1:
                    $vehicle_type = 'Car';
                    break;
                case 2:

                    $vehicle_type = 'Tricycle';
                    break;
                case 3:
                    $vehicle_type = 'Motorcyle';
                    break;
            }

            $sub_array[] = $vehicle_type;
            $sub_array[] = $row['parking_date'];

            $data[] = $sub_array;
            $count++;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $filtered_rows,
            "data" => $data
        );

        echo json_encode($output);
    }
}

?>