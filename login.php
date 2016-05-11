<?php

if ( isset($_POST['login']) && isset($_POST['password']) ) {

    $msg = login($_POST);

    if( $msg === TRUE ) {
        $_SESSION['msg'] = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
        header("Location:".$_SERVER['PHP_SELF']);
    }
    else {
        $_SESSION['msg'] = $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';;
        header("Location:".$_SERVER['PHP_SELF']);
    }

    exit();
}

if ( isset($_GET['logout']) ) {
    $msg = logout();

    if ( $msg === TRUE ) {
        $_SESSION['msg'] = "Вы вышли из системы";
        header("Location:".$_SERVER['PHP_SELF']);
        exit();
    }
}

$content = render(TEMPLATE."login.tpl",array());

?>