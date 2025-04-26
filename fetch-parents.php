<?php
include('config.php');

$user_id=$_POST['id'];

$ascendants = array();
$query = "SELECT `parent_id`, `user_id`, `name`,`user_type` FROM `users` WHERE `user_id` = '$user_id'";
$user = $obj->arr($query);

$paId=$user['parent_id'];
if($paId){
    $query = "SELECT `parent_id`, `user_id`, `name`,`user_type` FROM `users` WHERE `id` = '$paId'";
    $user = $obj->arr($query);
    
    if (!empty($user)) {
        while ($user['parent_id'] != '0' && $user['parent_id'] != null) {
            $ascendants[] = array(
                'parent_id' => $user['parent_id'],
                'user_id' => $user['user_id'],
                'name' => $user['name'],
                'user_type' => $user['user_type']
            );
    
            $parent_query = "SELECT `parent_id`, `user_id`, `name`,`user_type` FROM `users` WHERE `id` = '{$user['parent_id']}'";
            $user = $obj->arr($parent_query);
    
            if (empty($user)) {
                break;
            }
        }
    
        if (!empty($user)) {
            $ascendants[] = array(
                'parent_id' => $user['parent_id'],
                'user_id' => $user['user_id'],
                'name' => $user['name'],
                'user_type' => $user['user_type']
            );
        }
    }
}

if(!empty($ascendants)){
    echo json_encode(array('status'=>200,'data'=>$ascendants));
}else{
    echo json_encode(['status'=>201,'data'=>'']);
}

?>