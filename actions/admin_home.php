<?php

    if ( !$user ) {
        $text = "ACCESS DENIED";
        $content = render(TEMPLATE."admin/error.tpl",array());
    }

    if ( can($user['id_role'],array('MODER_MESS','RETIME_MESS')) ) {

        if ( $_POST ) {
            $id_mess = "";
            foreach ( $_POST['id_mess'] as $item ) {
                if ( (int)$item ) {
                    $id_mess .= $item.",";
                }
            }

            $id_mess = rtrim($id_mess,',');
            $msg = confirm_mess($id_mess);

            if ( $msg ) {
                $_SESSION['msg'] = "Обновлено";
            }
            else {
                $_SESSION['msg'] = $msg;
            }
            header("Location:".$_SERVER['PHP_SELF']);
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

        $count_mess = count_nc_mess();
        $text = get_nc_mess($page,PERPAGE);
        $navigation = get_navigation($page,$count_mess,PERPAGE);
    }

	$content = render(TEMPLATE."admin/admin_home.tpl",array(
                                                'text'       => $text,
                                                'navigation' => $navigation,
                                                'page'       => $page
                                            ));

?>