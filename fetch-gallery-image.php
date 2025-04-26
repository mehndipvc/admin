<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

include('config.php');

$columns = ['id', 'filename', 'cat_id', 'user_id'];

try {
    // Log debugging information
    error_log("Starting script");

    // Get total records count
    $totalRecordsQuery = "SELECT COUNT(*) AS total FROM items_images";
    $totalRecordsResult = $obj->fetch($totalRecordsQuery);
    $totalRecords = $totalRecordsResult[0]['total'];

    // Get filtered records count
    $searchValue = $_POST['search']['value'];
    $searchQuery = $searchValue ? "WHERE filename LIKE '%$searchValue%' OR cat_id LIKE '%$searchValue%' OR user_id LIKE '%$searchValue%'" : '';
    $filteredRecordsQuery = "SELECT COUNT(*) AS total FROM items_images $searchQuery";
    $filteredRecordsResult = $obj->fetch($filteredRecordsQuery);
    $filteredRecords = $filteredRecordsResult[0]['total'];

    // Get paginated results
    $start = intval($_POST['start']);
    $length = intval($_POST['length']);
    $orderColumn = $_POST['order'][0]['column'];
    $orderDir = $_POST['order'][0]['dir'];
    $orderBy = $columns[$orderColumn];

    $dataQuery = "SELECT * FROM items_images $searchQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";
    $dataResult = $obj->fetch($dataQuery);
    

    
    $data = [];
    foreach ($dataResult as $row) {
        $cat_id = $row['cat_id'];
        $user_id = $row['user_id'];
        $data_cat = $obj->arr("SELECT category FROM gal_category WHERE id='$cat_id'");
        $cat_name = $data_cat['category'] ?? 'N/A';
        $data_user = $obj->arr("SELECT name FROM users WHERE user_id='$user_id'");
        $user_name = $data_user['name'] ?? 'N/A';
        
        $filenameLink = '<a href="https://app.pvcinterior.in/mlm-app/api/assets/' . htmlspecialchars($row['filename'], ENT_QUOTES, 'UTF-8') . '" target="_blank">Show</a>';

        $data[] = [
            $row['id'],
            $filenameLink,
            $cat_name,
            $user_name
        ];
    }
    

    $response = [
        "draw" => intval($_POST['draw']),
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $data
    ];

    echo json_encode($response);
} catch (Exception $e) {
    // Log any exceptions
    error_log("Exception: " . $e->getMessage());
    echo json_encode(["error" => "An error occurred."]);
}
?>
