<?php

require_once 'connection.php';
$count = 1;


if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {
        $order_column = array('user_id', 'email', 'created_at');

        $main_query = "
		SELECT * FROM users 
		";

        $search_query = 'WHERE created_at <= "' . date('Y-m-d') . '" AND ';

        if (isset($_POST["start_date"], $_POST["end_date"]) && $_POST["start_date"] != '' && $_POST["end_date"] != '') {
            $search_query .= 'created_at >= "' . $_POST["start_date"] . '" AND created_at <= "' . $_POST["end_date"] . '" AND ';
        }

        if (isset($_POST["search"]["value"])) {
            $search_query .= '(user_id LIKE "%' . $_POST["search"]["value"] . '%" OR email LIKE "%' . $_POST["search"]["value"] . '%" OR created_at LIKE "%' . $_POST["search"]["value"] . '%")';
        }



        $group_by_query = " GROUP BY created_at ";

        $order_by_query = "";

        if (isset($_POST["order"])) {
            $order_by_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $order_by_query = 'ORDER BY created_at DESC ';
        }

        $limit_query = '';

        if ($_POST["length"] != -1) {
            $limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $statement = $pdo->prepare($main_query . $search_query . $group_by_query . $order_by_query);

        $statement->execute();

        $filtered_rows = $statement->rowCount();

        $statement = $pdo->prepare($main_query . $group_by_query);

        $statement->execute();

        $total_rows = $statement->rowCount();

        $result = $pdo->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

        $data = array();

        foreach ($result as $row) {

            if ($row['status'] == 0) {

                $sub_array = array();
                $sub_array[] = $count;

                $name = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
                $sub_array[] = $name;

                $sub_array[] = $row['mv_file'];
                $sub_array[] = $row['body_number'];

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

                $created_at = strtotime($row['created_at']);
                $sub_array[] = date("F d Y", $created_at);
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
            }

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