<?php

	if ($_GET['id']) {
		$id_mess = (int)$_GET['id'];
	}

    if ( $user['user_id'] ) {
        if ( check_user($user['user_id'], $id_mess) ) {
            $can = TRUE;
        }
        else {
            $can = FALSE;
        }
    }
    else {
        $can = FALSE;
    }

    $text = get_v_mess($id_mess);
    $img_s = explode("|", $text['img_s']);

    $content = render(TEMPLATE."view_mess.tpl",array(
    										'text' => $text,
    										'img_s' => $img_s
    										)
    				);

?>