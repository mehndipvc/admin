<?php
include("config.php");

// Determine which user type to fetch
if ($_POST['user_type'] == 'Agent') {
    $fetch_user = $obj->fetch("SELECT * FROM users WHERE user_type='Admin'");
} elseif ($_POST['user_type'] == 'CNF') {
    $fetch_user = $obj->fetch("SELECT * FROM users WHERE user_type='Agent'");
} elseif ($_POST['user_type'] == 'Distributor') {
    $fetch_user = $obj->fetch("SELECT * FROM users WHERE user_type='Agent' || user_type='CNF'");
} elseif ($_POST['user_type'] == 'Dealer') {
    $fetch_user = $obj->fetch("SELECT * FROM users WHERE user_type='Agent' OR user_type='Distributor'");
} elseif ($_POST['user_type'] == 'Customer') {
    $fetch_user = $obj->fetch("SELECT * FROM users WHERE user_type='Agent' OR user_type='Distributor' OR user_type='Dealer'");
}

// Start HTML output
$html = '<option value="">---Select Parent---</option>';

// Append each option to the HTML string
foreach ($fetch_user as $_POST_user) {
    $html .= '<option value="' . htmlspecialchars($_POST_user['id']) . '">' . htmlspecialchars($_POST_user['name']) . '</option>';
}

// Output the HTML
echo $html;
?>