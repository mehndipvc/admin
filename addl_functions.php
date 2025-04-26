<?php
function getIndividualPrice($obj, $user_id, $pro_id, $cat_id, $user_type) {
    // Try to get price for specific product
    $query = "SELECT set_price FROM individual_price 
              WHERE category = '$cat_id' AND product_id = '$pro_id' 
              AND user_type = '$user_type' AND user_id = '$user_id'";
    $price = $obj->arr($query);
    
    // If a specific product price is not set, try for 'All' products
    if (empty($price['set_price'])) {
        $query = "SELECT set_price FROM individual_price 
                  WHERE category = '$cat_id' AND product_id = 'All' 
                  AND user_type = '$user_type' AND user_id = '$user_id'";
        $price = $obj->arr($query);
    }
    
    return $price['set_price'] ?? null;
}

function checkPrice($obj, $user_id, $pro_id, $cat_id, $user_type) {
    // Check for individual price for specific user
    $userExists = $obj->num("SELECT id FROM individual_price WHERE user_type = '$user_type' AND user_id = '$user_id'");
    
    if ($userExists > 0) {
        $price = getIndividualPrice($obj, $user_id, $pro_id, $cat_id, $user_type);
        if ($price !== null) {
            return $price;
        }
    }
    
    // Check for 'All' users
    $allUserExists = $obj->num("SELECT id FROM individual_price WHERE user_type = '$user_type' AND user_id = 'All'");
    
    if ($allUserExists > 0) {
        $price = getIndividualPrice($obj, 'All', $pro_id, $cat_id, $user_type);
        if ($price !== null) {
            return $price;
        }
    }
    
    // Fallback to general product price
    $sel_product = $obj->arr("SELECT price FROM items WHERE id = '$pro_id'");
    return $sel_product['price'] ?? null;
}


// Check Commision
function getIndividualCom($obj, $user_id, $pro_id, $cat_id, $user_type) {
    // Try to get price for specific product
    $query = "SELECT price FROM individual_price 
              WHERE category = '$cat_id' AND product_id = '$pro_id' 
              AND user_type = '$user_type' AND user_id = '$user_id'";
    $price = $obj->arr($query);
    
    // If a specific product price is not set, try for 'All' products
    if (empty($price['price'])) {
        $query = "SELECT price FROM individual_price 
                  WHERE category = '$cat_id' AND product_id = 'All' 
                  AND user_type = '$user_type' AND user_id = '$user_id'";
        $price = $obj->arr($query);
    }
    
    return $price['price'] ?? null;
}


function checkCommsission($obj, $user_id, $pro_id, $cat_id, $user_type) {
    // Check for individual price for specific user
    $userExists = $obj->num("SELECT id FROM individual_price WHERE user_type = '$user_type' AND user_id = '$user_id'");
    
    if ($userExists > 0) {
        $price = getIndividualCom($obj, $user_id, $pro_id, $cat_id, $user_type);
        if ($price !== null) {
            return $price;
        }
    }
    
    // Check for 'All' users
    $allUserExists = $obj->num("SELECT id FROM individual_price WHERE user_type = '$user_type' AND user_id = 'All'");
    
    if ($allUserExists > 0) {
        $price = getIndividualCom($obj, 'All', $pro_id, $cat_id, $user_type);
        if ($price !== null) {
            return $price;
        }
    }
    
    return 0;
}

function getAscendants($user_id, $db) {
    $ascendants = array();
    $query = "SELECT `parent_id`, `user_id`, `name`,`user_type` FROM `users` WHERE `user_id` = '$user_id'";
    $user = $db->arr($query);

    if (!empty($user)) {
        while ($user['parent_id'] != '0' && $user['parent_id'] != null) {
            $ascendants[] = array(
                'parent_id' => $user['parent_id'],
                'user_id' => $user['user_id'],
                'name' => $user['name'],
                'user_type' => $user['user_type']
            );

            $parent_query = "SELECT `parent_id`, `user_id`, `name`,`user_type` FROM `users` WHERE `id` = '{$user['parent_id']}'";
            $user = $db->arr($parent_query);

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

    return $ascendants;
}
?>
