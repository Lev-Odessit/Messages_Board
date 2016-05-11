<?php

    if ( $_GET['hash']) {
        $confirm = confirm();

        if ( $confirm === TRUE ) {
            $msg = "Поздравляем. Ваша учётная запись активирована.";
            $_SESSION['msg'] = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
            header("Location:".$_SERVER['PHP_SELF']);
            exit();
        }
        else {
            $_SESSION['msg'] = $msg;
            header("Location:".$_SERVER['PHP_SELF']);
            exit();
        }

    }

    $post = (!empty($_POST)) ? true : false;

	if ( $post ) {

		$msg = registration($_POST);

		if ($msg === TRUE) {
            $msg = "Вы успешно зарегестрировались на сайте. И для подтверждения регистрации Вам на почту отправлено письмо с инструкциями.";
			$_SESSION['msg'] = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
            header("Location:".$_SERVER['PHP_SELF']);
            exit();
		}
		else {
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
            header("Location:?action=registration");
            exit();
		}

	}
    $content = render(TEMPLATE."registration.tpl",array("title" => 'hello'));
?>