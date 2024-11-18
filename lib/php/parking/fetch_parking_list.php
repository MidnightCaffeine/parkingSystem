<?php

require_once '../database_handler/connection.php';
$count = 1;

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {
        $order_column = array('parking_id', 'user_id', 'parking_date');

        $main_query = "
        SELECT * FROM parking_log 
        ";

        // Default to today's date filter if no other filters provided
        $search_query = 'WHERE parking_date = "' . date('Y-m-d') . '" ';

        // Date range filtering
        if (isset($_POST["start_date"], $_POST["end_date"]) && !empty($_POST["start_date"]) && !empty($_POST["end_date"])) {
            // Convert input dates to Y-m-d format to ensure consistency
            $start_date = date('Y-m-d', strtotime($_POST["start_date"]));
            $end_date = date('Y-m-d', strtotime($_POST["end_date"]));
            $search_query = 'WHERE parking_date >= "' . $start_date . '" AND parking_date <= "' . $end_date . '" ';
        }

        // Search across specified columns if search term is provided
        if (isset($_POST["search"]["value"])) {
            $search_query .= 'AND (user_mv_file LIKE "%' . $_POST["search"]["value"] . '%" 
                              OR username LIKE "%' . $_POST["search"]["value"] . '%" 
                              OR parking_date LIKE "%' . $_POST["search"]["value"] . '%" 
                              OR vehicle_type LIKE "%' . $_POST["search"]["value"] . '%")';
        }

        $group_by_query = " GROUP BY parking_date ";

        // Ordering logic
        $order_by_query = "";
        if (isset($_POST["order"])) {
            $order_by_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_by_query = 'ORDER BY parking_date DESC ';
        }

        // Pagination
        $limit_query = '';
        if ($_POST["length"] != -1) {
            $limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        // Prepare and execute statement for filtered data
        $final_query = $main_query . $search_query . $group_by_query . $order_by_query;
        $statement = $pdo->prepare($final_query);
        $statement->execute();
        $filtered_rows = $statement->rowCount();

        // Check for errors or empty result
        if ($filtered_rows === 0) {
            // Output a message if no records match
            echo json_encode(array(
                "draw" => intval($_POST["draw"]),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => array(),
                "message" => "No records found for the specified date range or search criteria."
            ));
            return;
        }

        // Prepare and execute statement for total data count
        $statement = $pdo->prepare($main_query . $group_by_query);
        $statement->execute();
        $total_rows = $statement->rowCount();

        // Fetch data with all filters applied
        $result = $pdo->query($final_query . $limit_query, PDO::FETCH_ASSOC);

        $data = array();

        foreach ($result as $row) {
            $sub_array = array();
            $sub_array[] = $count;
            $sub_array[] = $row['username'];
            $sub_array[] = $row['user_mv_file'];

            $time_in = strtotime($row['time_in']);
            $sub_array[] = date("h:i a", $time_in);

            if ($row['time_out'] != null) {
                $out = strtotime($row['time_out']);
                $time_out = date("h:i a", $out);
            } else {
                $time_out = '';
            }
            $sub_array[] = $time_out; // Placeholder for removed time_out


            // Determine vehicle type
            switch ($row['vehicle_type']) {
                case 1:
                    $vehicle_type = 'Car';
                    break;
                case 2:
                    $vehicle_type = 'Tricycle';
                    break;
                case 3:
                    $vehicle_type = 'Motorcycle';
                    break;
                default:
                    $vehicle_type = 'Unknown';
                    break;
            }
            $sub_array[] = $vehicle_type;

            // Format parking date
            $parking_date = strtotime($row['parking_date']);
            $sub_array[] = date("F d Y", $parking_date);

            $data[] = $sub_array;
            $count++;
        }

        // Output response
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