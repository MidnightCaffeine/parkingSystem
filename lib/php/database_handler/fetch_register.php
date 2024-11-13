<?php

require_once 'connection.php';
session_start();
$count = 1;

if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {
        $order_column = array('user_id', 'email', 'created_at');

        // Main query to select all columns from the users table
        $main_query = "
        SELECT * FROM users 
        ";

        // Default search query to only include users with user_status = 0 and user_type = 2
        $search_query = 'WHERE user_status = 0 AND user_type = 2 AND created_at <= "' . date('Y-m-d') . '" AND ';

        // Date range filter (if both start_date and end_date are provided)
        if (isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '') {
            $search_query .= 'created_at >= "' . $_POST["start_date"] . '" AND created_at <= "' . $_POST["end_date"] . '" AND ';
        }

        // General search filter (if a search value is provided)
        if (isset($_POST["search"]["value"])) {
            $search_query .= '(mv_file LIKE "%' . $_POST["search"]["value"] . '%" OR body_number LIKE "%' . $_POST["search"]["value"] . '%" OR created_at LIKE "%' . $_POST["search"]["value"] . '%" OR firstname LIKE "%' . $_POST["search"]["value"] . '%" OR lastname LIKE "%' . $_POST["search"]["value"] . '%" OR middlename LIKE "%' . $_POST["search"]["value"] . '%")';
        }

        // Group by query (if needed)
        $group_by_query = " GROUP BY created_at ";

        // Order by query based on the user's input
        $order_by_query = "";

        if (isset($_POST["order"])) {
            $order_by_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_by_query = 'ORDER BY created_at DESC ';
        }

        // Limit query for pagination
        $limit_query = '';

        if ($_POST["length"] != -1) {
            $limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        // Prepare the statement to count the filtered rows
        $statement = $pdo->prepare($main_query . $search_query . $group_by_query . $order_by_query);
        $statement->execute();
        $filtered_rows = $statement->rowCount();

        // Prepare the statement to count the total rows
        $statement = $pdo->prepare($main_query . $group_by_query);
        $statement->execute();
        $total_rows = $statement->rowCount();

        // Fetch the filtered results
        $result = $pdo->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

        $data = array();
        $count = 0;

        // Loop through the results and format them for DataTables
        foreach ($result as $row) {
            $sub_array = array();
            $sub_array[] = $count;

            // Construct the full name from first, middle, and last names
            $name = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
            $sub_array[] = $name;

            // Add other columns to the sub_array
            $sub_array[] = $row['mv_file'];
            $sub_array[] = $row['body_number'];

            // Determine the vehicle type
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

            // Format the created_at field to a more readable date format
            $created_at = strtotime($row['created_at']);
            $sub_array[] = date("F d Y", $created_at);

            // Add action buttons (view, delete, approve)
            $sub_array[] = '
                <button type="button" id="' . $row['user_id'] . '" class="btn btn-success view_user">
                    <i class="bi bi-eye"></i>
                </button>
                <button type="button" id="' . $row['user_id'] . '" class="btn btn-danger delete_user">
                    <i class="bi bi-trash"></i>
                </button>
                <button type="button" id="' . $row['user_id'] . '" class="btn btn-success approve">
                    <i class="bi bi-clipboard-check"></i> Approve
                </button>
            ';

            $data[] = $sub_array;
            $count++;
        }

        // Prepare the output array for DataTables response
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_rows,
            "recordsFiltered" => $filtered_rows,
            "data" => $data
        );

        // Return the data as a JSON response
        echo json_encode($output);
    }
}
?>
