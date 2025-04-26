<?php 
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');

include_once 'config.php'; 

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

$fileName = "user_details" . date('d-m-y') . ".xls"; 
    
// Column names 
$fields = array('user_type','name', 'mobile', 'email', 'address', 'parent','status', 'wallet'); 
    
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 

// Fetch user details data
$fetch_data = $obj->fetch("SELECT user_type, is_admin, password, name, mobile, email, address, parent, user_id, id, parent_id, status, wallet FROM users");

$cnt=0;   
foreach($fetch_data as $fetch_val) {
    $par_id=$fetch_val['parent_id'];
    $sel_data = $obj->arr("SELECT name FROM users WHERE id='$par_id'");
    
    $cnt++;
    $lineData = array(
        $fetch_val['user_type'],
        $fetch_val['name'],
        $fetch_val['mobile'],
        $fetch_val['email'],
        $fetch_val['address'],
        $sel_data['name'],
        $fetch_val['status'],
        $fetch_val['wallet']
    );
    
    // Filter data
    array_walk($lineData, 'filterData'); 
    $excelData .= implode("\t", array_values($lineData)) . "\n";
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 

// Render excel data 
echo $excelData; 

exit;
?>
