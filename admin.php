<?php
header("Content-Type:text/html;charset=UTF-8");

session_start();

include "config.php";
include "functions.php";

$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
$db = mysqli_select_db($connect,DB_NAME);


$user = check_user();

if($user) {

    if ( !can($user['id_role'],array('VIEW_ADMIN')) ) {
        $acc = "ACCESS DENIDED";
        include "login.php";
        exit();
    }

    $msg = confirm_actual();

    if ( $msg ) {
        $_SESSION['a_msg'] = "Устаревших объявлений:".$msg;
    }

    if ( can($user['id_role'],array('EDIT_US')) ) {
        $edit_us = TRUE;
    }

    if ( can($user['id_role'],array('ADD_CAT')) ) {
        $add_cat = TRUE;
    }

    if ( can($user['id_role'],array('EDIT_US')) ) {
        $edit_mess = TRUE;
    }

    $categories = get_categories();
    $razd = get_razdel();

    $action = clear_str($_GET['action']);

    if (!$action) {
        $action = "admin_home";
    }

    if(file_exists(ACTIONS.$action.".php")) {
        include ACTIONS.$action.".php";
    } else {
        include ACTIONS."admin_home.php";
    }

    include TEMPLATE."admin/index.php";
}
else {
    include "login.php";
}

?>