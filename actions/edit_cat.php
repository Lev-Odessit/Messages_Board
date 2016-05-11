<?php
if(!$user && !can($user['id_role'],array("ADD_CAT"))) {
    $text = "ACCESS DENIED";
    $content = render(TEMPLATE.'admin/error.tpl',array(
                                                'text' => $text
                                            ));
}

$do = 'add';

if ( $_GET['do'] ) {
    $do = clear_str($_GET['do']);
}

if ( $_GET['id'] ) {
    $id_cat = (int)$_GET['id'];
}

if ( $do === 'edit' ) {
    if ( $id_cat ) {
        $cat = get_cat($id_cat);
    }
}

if ( $do == 'delete' ) {
    if ( $id_cat ) {
        $child = get_child($id_cat);
        if ( $child == 0 ) {
            $msg = delete_cat($id_cat);
            if ( $msg ===TRUE ) {
                $_SESSION['msg'] = "Категория была удалена";
            }
            else {
                $_SESSION['msg'] = $msg;
            }
            header("Location:admin.php?action=edit_cat");
            exit();
        }
        else {
            $_SESSION['msg'] = "Удалите дочерние категории";
            $do = 'add';
        }
    }
}

if ( $_POST ) {
    if ( $do == 'add' ) {
        $msg = add_category($_POST);

        if ( $msg === TRUE ) {
            $_SESSION['msg'] = "Категория добавлена";
        }
        else {
            $_SESSION['msg'] = $msg;
        }
        header("Location:admin.php?action=edit_cat");
        exit();
    }
    elseif ( $do = 'edit' ) {
        if ( $id_cat ) {
            $msg = edit_category( $_POST );

            if ( $msg === TRUE ) {
                $_SESSION['msg'] = "Категория была изменена";
            }
            else {
                $_SESSION['msg'] = $msg;
            }
            header("Location:admin.php?action=edit_cat");
            exit();
        }
    }
}

$content = render(TEMPLATE."admin/edit_cat.tpl", array(
                                                    'categories'    => $categories,
                                                    'do'            => $do,
                                                    'cat'           => $cat
                                                ));

?>