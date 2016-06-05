<?php

    if ( $_GET['hash']) {
        $msg = confirm();

        if ( $msg === TRUE ) {
            $msg = "Поздравляем. Ваша учётная запись активирована.";
            $_SESSION['msg'] = '<div class="green">'.$msg.'</div>';
            header("Location:".$_SERVER['PHP_SELF']);
            exit();
        }
        else {
            $_SESSION['msg'] = '<div class="red">'.$msg.'</div>';
            header("Location:".$_SERVER['PHP_SELF']);
            exit();
        }

    }

    $post = (!empty($_POST)) ? true : false;

	if ( $post ) {

		$msg = registration($_POST);

		if ($msg === TRUE) {
            $msg = "Вы успешно зарегестрировались на сайте. И для подтверждения регистрации Вам на почту отправлено письмо с инструкциями.";
			$_SESSION['msg'] = '<div class="green">'.$msg.'</div>';
            header("Location:".$_SERVER['PHP_SELF']);
            exit();
		}
		else {
            $_SESSION['msg'] = '<div class="red">'.$msg.'</div>';
            header("Location:?action=registration");
            exit();
		}

	}
    $content = render(TEMPLATE."registration.tpl",array());
?>