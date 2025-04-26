<?php
include('config.php');

function getAscendants($user_id, $db) {
    $ascendants = array();
    $query = "SELECT `parent_id`, `user_id`, `name` FROM `users` WHERE `user_id` = '$user_id'";
    $user = $db->arr($query);

    if (!empty($user)) {
        while ($user['parent_id'] != '0' && $user['parent_id'] != null) {
            $ascendants[] = array(
                'parent_id' => $user['parent_id'],
                'user_id' => $user['user_id'],
                'name' => $user['name']
            );

            $parent_query = "SELECT `parent_id`, `user_id`, `name` FROM `users` WHERE `id` = '{$user['parent_id']}'";
            $user = $db->arr($parent_query);

            if (empty($user)) {
                break;
            }
        }

        if (!empty($user)) {
            $ascendants[] = array(
                'parent_id' => $user['parent_id'],
                'user_id' => $user['user_id'],
                'name' => $user['name']
            );
        }
    }

    return $ascendants;
}

require_once 'config.php';

$user_id = 17042;

$ascendants = getAscendants($user_id, $obj);

echo "<pre>";
print_r($ascendants);
echo "</pre>";
?>

