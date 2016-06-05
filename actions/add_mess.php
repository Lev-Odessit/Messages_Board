<?php
if(!$user || !can($user['id_role'],array("ADD_MESS"))) {
	$text = "Доступ запрещен";
	$content = render(TEMPLATE."error.tpl",array("text"=>$text));
}
else {
    if ( $_POST ) {
        $msg = add_mess($_POST,$user['user_id']);
        if ( $msg === TRUE ) {
            $msg = "Успешно добавлено. Ожидает проверки модератора";
            $_SESSION['msg'] = '<div class="green">'.$msg.'</div>';
        }
        else {
            $_SESSION['msg'] = '<div class="red">'.$msg.'</div>';
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