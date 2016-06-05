<?php

	if ($_GET['id']) {
		$id_mess = (int)$_GET['id'];
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

    $count_mess = count_mess();
    if ( $count_mess > 0 ) {
        $lastMess = get_mess(FALSE,FALSE,$page,PERPAGE);
    }

    $text = get_v_mess($id_mess);
    $img_s = explode("|", $text['img_s']);

    $content = render(TEMPLATE."view_mess.tpl",array(
    										'text'      => $text,
                                            'lastMess'  => $lastMess,
    										'img_s'     => $img_s
    										));

?>