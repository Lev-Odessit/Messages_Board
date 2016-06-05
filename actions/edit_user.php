<?php
if(!$user && !can($user['id_role'],array("EDIT_US"))) {
    $text = "ACCESS DENIED";
    $content = render(TEMPLATE.'admin/error.tpl',array(
                                                'text' => $text
                                            ));
}
if ($_POST) {
    if ($_POST['delete_user']) {
        if (is_array($_POST['delete_u'])) {
            $id_del = '';
            foreach ($_POST['delete_u'] as $item) {
                $id_del .= $item . ',';
            }
            $id_dell = rtrim($id_del, ',');

            $msg = delete_users($id_dell);

            if ($msg === TRUE) {
                $_SESSION['msg'] = "Users was deleted";
            } else {
                $_SESSION['msg'] = $msg;
            }
        }
        else {
            $_SESSION['msg'] = "Not parameters";
        }
    }
    elseif ($_POST['confirm_user']) {
        $id_user = (int)$_POST['confirm_u'];

        $msg = confirm_users($id_user);

        if ( $msg === TRUE ) {
            $_SESSION['msg'] = "Users is confirm";
        }
        else {
            $_SESSION['msg'] = $msg;
        }
    }
    elseif ( $_POST['edit_roles'] && $_POST['role_id_u'] && $_POST['role_u'] ) {
        $id_user = (int)$_POST['role_id_u'];
        $id_role = (int)$_POST['role_u'];

        $msg = edit_role_user($id_user,$id_role);

        if ( $msg === TRUE ) {
            $_SESSION['msg'] = "Users was updated";
        }
        else {
            $_SESSION['msg'] = $msg;
        }
    }
    header("Location:admin.php?action=edit_user");
    exit();
}

if ( $_GET['page'] ) {
    $page = (int)$_GET['page'];
    if ( !$page ) {
        $page = 1;
    }
} 
else {
    $page = 1;
}

$roles = get_roles();

$count_user = count_users();
if( $count_user ) {
    $text = get_users($page,20);
    $navigation = get_navigation($page,$count_user,20);
}

$content = render(TEMPLATE."admin/edit_user.tpl", array(
                                                    'text'       => $text,
                                                    'navigation' => $navigation,
                                                    'roles'      => $roles,
                                                    'page'       => $page
                                                ));


?>