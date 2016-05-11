<?php
if(!$user || !can($user['id_role'],array("ADD_MESS"))) {
	$text = "Доступ запрещен";
	$content = render(TEMPLATE."error.tpl",array("text"=>$text));
}
else {
    if ( $_POST ) {
        $msg = add_mess($_POST,$user['user_id']);
        if ( $msg === TRUE ) {
            $_SESSION['msg'] = "Успешно добавлено. Ожидает проверки модератора";
        }
        else {
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';;
        }

        header("Location:?action=add_mess");
        exit();
    }
	$content = render(TEMPLATE."add_mess.tpl",array(
                                                    'categories' => $categories,
                                                    'razd' => $razd,
                                                ));
}
?>