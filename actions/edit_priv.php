<?php

if ( !$user && can($user['id_role'],array('EDIT_US')) ) {
    $text = "ACCESS DENIED";
    $content = render(TEMPLATE."admin/error.tpl",array());
}

$roles = get_roles();
$priv = get_priv();

if ( $_POST ) {
    $msg = edit_role_priv($_POST);

    if ( $msg === TRUE ) {
        $_SESSION['msg'] = "USER update";
    }
    else {
        $_SESSION['msg'] = $msg;
    }

    header("Location:admin.php?action=edit_priv");
    exit();
}

$content = render(TEMPLATE."admin/edit_priv.tpl",array(
    'roles'      => $roles,
    'priv'       => $priv
));

?>