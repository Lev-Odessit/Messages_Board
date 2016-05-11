<?php 

if ( $_GET ) {

	if ( $_GET['page'] ) {
		$page = (int)$_GET['page'];
		if ( !$page ) {
			$page = 1;
		}
	}
	else {
		$page = 1;
	}

	$count_mess = count_s_mess($_GET);
	$text = get_search($_GET,$page,PERPAGE);
	$navigation = get_navigation($page,$count_mess,PERPAGE);

	$url = "";

	foreach ( $_GET as $key => $value ) {
		if ( $key != 'page' ) {
			$url .= $key."=".$value."&";
		}
	}
}

	if ( is_array($text) ) {
		$text = small_text($text);
	}
	else {
		if ( $text != FALSE ) {
			$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Ничего не найдено</div>';
		}
		else {
			$msg = "Ничего не найдено";
			$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
		}
	}

	$content = render(TEMPLATE."search.tpl",array(
										"text" 		 => $text,
										"navigation" => $navigation,
										"id_r" 		 =>	$id_r,
										"name_razd"	 => $name_razd,
										"url"		 => $url,
										"msg"		 => $msg
										));

?>