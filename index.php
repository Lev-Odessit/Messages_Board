<?php
header("Content-Type:text/html;charset=UTF-8");

session_start();

include "config.php";
include "functions.php";

$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
$db = mysqli_select_db($connect,DB_NAME);

$categories = get_categories();
$razd = get_razdel();
$user = check_user();

if($user) {
    $add_mess = can($user['id_role'],array("ADD_MESS"));
}

$action = clear_str($_GET['action']);

if (!$action) {
    $action = "main";
}

if(file_exists(ACTIONS.$action.".php")) {
    include ACTIONS.$action.".php";
} else {
    include ACTIONS."main.php";
}

if ( $action != 'categories' ) {
    $m_action = "section";
}
else {
    $m_action = $action;
}

include TEMPLATE."/index.php";

?>