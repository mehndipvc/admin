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

$fileName = "product_details" . date('d-m-y') . ".xls"; 
    
    // Column names 
    $fields = array('slno', 'category', 'product', 'status'); 
    
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 

    $fetch_data = $obj->fetch("SELECT id,name FROM category");
 
    $cnt=0;   
    foreach($fetch_data as $fetch_val)
    {
        $cid=$fetch_val['id'];
        $fetch_product = $obj->fetch("SELECT status,name FROM items WHERE cat_id='$cid'");
        foreach($fetch_product as $val){
            $cnt++;
            $lineData = array($cnt,$fetch_val['name'],$val['name'],$val['status']);
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n";
        }
        
    }

// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 

// Render excel data 
echo $excelData; 

exit;

?>
