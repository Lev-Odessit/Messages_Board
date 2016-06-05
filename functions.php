<?php

    function clear_str($str) {
        return trim(strip_tags($str));
    }

    function render($part,$param = array()) {
        extract($param);
        ob_start();

        if(!include($part.".php")) {
            exit('Нет такого шаблона');
        }

        return ob_get_clean();
    }

    function is_valid_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL)
        && preg_match('/@.+\./', $email);
    }

    function registration($post) {

        $login = clear_str($post['reg_login']);
        $password = trim($post['reg_password']);
        $conf_pass = trim($post['reg_password_confirm']);
        $email = clear_str($post['reg_email']);
        $name = clear_str($post['reg_name']);

        if ( !is_valid_email($email) ) {
            $_SESSION['reg']['login'] = $login;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['name'] = $name;
            return "Введёная почта не валидна";
        }

        if($conf_pass == $password) {

            $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
            mysqli_select_db($connect,DB_NAME);

            $sql = "SELECT user_id
                        FROM ".PREF."users
                        WHERE login='$login'";
            $result = mysqli_query($connect,$sql);

            if (mysqli_num_rows($result) > 0) {
                $_SESSION['reg']['email'] = $email;
                $_SESSION['reg']['name'] = $name;
                return "Пользователь с таким логином уже существует";
            }

            $password = md5($password);
            $hash = md5(microtime());

            $query = "INSERT INTO ".PREF."users (
                            login,
                            password,
                            name,
                            hash,
                            email
                            )
                          VALUES (
                            '$login',
                            '$password',
                            '$name',
                            '$hash',
                            '$email'
                          )"
            or die(mysqli_error($connect));

            $result2 = mysqli_query($connect,$query);

            if (!$result2) {
                $_SESSION['reg']['login'] = $login;
                $_SESSION['reg']['email'] = $email;
                $_SESSION['reg']['name'] = $name;
                return "Ошибка при добавлении пользователя в базу данных".mysqli_error($connect);
            }
            else {
                $headers = '';
                $headers = "From: Admin admin@mail.ru";
                $headers = "Content-Type:text/html; charset=UTF-8";

                $tema = "registration";

                $mailStr = file_get_contents('mailString.html');

                $mail_body = "Спасибо за регистрацию на сайте.
                    Ваша ссылка для подтверждения учётной записи: ".SITE_NAME."?action=registration&hash=".$hash;

                mail($email,$tema,$mailStr,$headers);

                return TRUE;

            }
        }
        else {
            $_SESSION['reg']['login'] = $login;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['name'] = $name;
            return "Вы не правильно подтвердили пароль";
        }

    }

    function confirm() {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);

        $new_hash = clear_str($_GET['hash']);

        $query = "UPDATE ".PREF."users SET confirm='1' WHERE hash = '$new_hash'";

        $result = mysqli_query($connect,$query);

        if ( mysqli_affected_rows($connect) == 1) {
            return TRUE;
        } else {
            return 'Неверный код';
        }

    }

    function login($post) {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);

        $login = clear_str($post['login']);
        $password = md5(trim($post['password']));

        $sql = "SELECT user_id,confirm
                FROM ".PREF."users
                WHERE login = '$login'
                AND password = '$password'";

        $result = mysqli_query($connect,$sql);

        if ( !$result || mysqli_num_rows($result) < 1) {
            return "Неправильный логин или пароль";
        }

        if ( mysql_result($result,0,'confirm') === 0 ) {
            return "Пользователь с таким логином ещё не подтверждён";
        }

        $sess = md5(microtime());

        $sql_update = "UPDATE ".PREF."users SET sess='$sess' WHERE login='$login'";

        if ( !mysqli_query($connect,$sql_update)) {
            return "Ошибка авторизации пользователя";
        }

        $_SESSION['sess'] = $sess;

        if ( $post['member'] == 1 ) {
            $time = time() + 10*24+3600;

            setcookie('login',$login,$time);
            setcookie('password',$password,$time);

        }

        return TRUE;
    }

    function logout() {
        unset($_SESSION['sess']);

        setcookie('login','',time()-3600);
        setcookie('password','',time()-3600);

        return TRUE;
    }

    function check_user() {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);

        if( isset($_SESSION['sess'])) {
            $sess = $_SESSION['sess'];

            $sql = "SELECT user_id,name,id_role
                    FROM ".PREF."users
                    WHERE sess='$sess'";

            $result = mysqli_query($connect,$sql);

            if( !$result || mysqli_num_rows($result) < 1 ) {
                return FALSE;
            }

            return mysqli_fetch_assoc($result);
        }

        elseif ( isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
            $login = $_COOKIE['login'];
            $password = $_COOKIE['password'];

            $sql = "SELECT user_id,name,id_role
                    FROM ".PREF."users
                    WHERE login='$login'
                    AND password='$password'
                    AND confirm='1'";
            $result2 = mysqli_query($connect,$sql);

            if(!$result2 || mysqli_num_rows($result2) < 1 ) {
                return FALSE;
            }

            $sess = md5(microtime());

            $sql_update = "UPDATE ".PREF."users SET sess='$sess' WHERE login=$login";

            if ( !mysqli_query($connect,$sql_update) ) {
                return FALSE;
            }

            $_SESSION['sess'] = $sess;

            return mysqli_fetch_assoc($result2);

        }
        else {
            return FALSE;
        }

    }

    function get_password($email) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);

        $email = clear_str($email);

        $sql = "SELECT user_id
                FROM ".PREF."users
                WHERE email = '$email'";

        $result = mysqli_query($connect,$sql);

        if(!$result) {
            return "не возможно сгенерировать новый пароль";
        }

        if(mysqli_num_rows($result) == 1) {
            $str = "234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";

            $pass = '';

            for($i = 0; $i < 6; $i++) {
                $x = mt_rand(0,(strlen($str)-1));

                if($i != 0) {
                    if($pass[strlen($str)-1] == $str[$x]) {
                        $i--;
                        continue;
                    }
                }
                $pass .= $str[$x];
            }

            $md5pass = md5($pass);

            $query = "UPDATE ".PREF."users
                        SET password='$md5pass'
                        WHERE user_id = '".mysql_result($result,0,'user_id')."'";
            $result2 = mysqli_query($connect,$query);

            if(!$result2) {
                return "Не возможно сгенерировать новый пароль";
            }

            $headers = '';
            $headers .= "From: Admin <admin@mail.ru> \r\n";
            $headers .= "Content-Type: text/plain; charset=utf8";

            $subject = 'new password';
            $mail_body = "Ваш новый пароль: ".$pass;

            mail($email,$subject,$mail_body,$headers);

            return TRUE;
        }
        else {
            return "Пользователя с таким потчтовым ящиком нет";
        }
    }

    function can($id,$priv_adm) {
        $priv = getPriv($id);
        if(!$priv) {
            $priv = array();
        }

        $arr = array_intersect($priv_adm,$priv);

        if($arr === $priv_adm) {
            return TRUE;
        }

        return FALSE;

    }

    function getPriv($id) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);

        $sql = "SELECT ".PREF."priv.name AS priv
                    FROM ".PREF."priv
                    LEFT JOIN ".PREF."role_priv
                        ON ".PREF."role_priv.id_priv = ".PREF."priv.id
                    WHERE ".PREF."role_priv.id_role = '$id'";


        $result = mysqli_query($connect,$sql);
        if(!$result) {
            return FALSE;
        }

        for($i = 0; $i < mysqli_num_rows($result);$i++) {
            $row = mysqli_fetch_array($result);
            $arr[] = $row[0];
        }

        return $arr;
    }

    function get_razdel() {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT id,name FROM ".PREF."razd";
        $result = mysqli_query($connect,$sql);

        return get_result($result);
    }

    function get_result($result) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");
        if(!$result) {
            exit(mysqli_error($connect));
        }

        if(mysqli_num_rows($result) == 0) {
            return FALSE;
        }

        $row = array();

        for($i = 0;mysqli_num_rows($result) > $i;$i++) {
            $row[] = mysqli_fetch_array($result,MYSQL_ASSOC);
        }

        return $row;
    }

    function get_categories() {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT id,name,parent_id FROM ".PREF."categories";
        $result = mysqli_query($connect,$sql);

        if(!$result) {
            exit(mysqli_errno($connect));
        }

        if(mysqli_num_rows($result) == 0) {
            return FALSE;
        }

        $categories = array();

        for($i = 0; mysqli_num_rows($result) > $i;$i++) {
            $row = mysqli_fetch_array($result);

            if(!$row['parent_id']) {
                $categories[$row['id']][] = $row['name'];
            }
            else {
                $categories[$row['parent_id']]['next'][$row['id']] = $row['name'];
            }
        }

        return $categories;
    }


    function get_img() {
        $width = 160;
        $height = 80;

        $r = mt_rand(133,255);
        $g = mt_rand(133,255);
        $b = mt_rand(133,255);

        $im = imagecreatetruecolor($width,$height);

        $background = imagecolorallocate($im,$r,$g,$b);

        imagefilledrectangle($im,0,0,$width,$height,$background);

        $black = imagecolorallocate($im,7,7,7);

        for ( $h = mt_rand(1,10); $h < $height; $h = $h + mt_rand(1,10) ) {
            for ( $v = mt_rand(1,30); $v < $width; $v = $v + mt_rand(1,30) ) {

                imagesetpixel($im,$v,$h,$black);
            }
        }

        $str = generate_str();
        $_SESSION['str_cap'] = $str;


        $fonts_p = "fonts/";
        $d = opendir($fonts_p);

        while ( ($file = readdir($d)) != FALSE ) {
                if( $file == "." || $file == ".." ) {
                    continue;
                }
                $fonts[] = $file;
        }

        $x = 20;
        $color = imagecolorallocate($im,7,7,7);
        for ( $i = 0; $i < strlen($str);$i++) {

            $n = mt_rand(0,count($fonts) - 1);
            $font = $fonts_p.$fonts[$n];

            $size = mt_rand(15,35);
            $angle = mt_rand(-30,30);
            $y = mt_rand(40,45);

            imagettftext($im,$size,$angle,$x,$y,$color,$font,$str[$i]);
            $x = $x + $size - 5;
        }

        for ($c = 0; $c < 5; $c++ ) {

            $x1 = mt_rand(0,intval($width*0.1));
            $x2 = mt_rand(intval($width*0.8),$width);

            $y1 = mt_rand(0,intval($height*0.6));
            $y2 = mt_rand(intval($height*0.3),$height);

            imageline($im,$x1,$y1,$x2,$y2,$black);
        }


        header("Content-Type:image/png;");
        imagepng($im);

        imagedestroy($im);

    }

    function generate_str() {

        $str = "23456789abcdegikpqsvxyz";
        $strLength = strlen($str) - 1;

        $str_g = "";

        for ($i = 0; $i < 5; $i++) {
            $x = mt_rand(0,$strLength);

            if ( $i !== 0 ) {
                if ( $str_g[strlen($str_g) - 1] == $str_g[$x] ) {
                    $i--;
                    continue;
                }
            }

            $str_g .= $str[$x];
        }

        return $str_g;
    }

/**
 * @param $post
 * @param $user_id
 * @return bool|string
 */
function add_mess($post, $user_id) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $title = clear_str($post['title']);
        $text = $post['text'];
        $id_categories = (int)($post['id_categories']);
        $id_razd = (int)($post['id_razd']);
        $price = (int)($post['price']);
        $town = clear_str($post['town']);
        $date = time();
        $a_time = (int)($post['time']);
        $time_over = $date + ($a_time*(60*60*24));

        $msg = '';

        if ( empty($title)) {
            $msg .= "Введите заголовок объявления".'<br>';
        }
        if ( empty($text)) {
            $msg .= "Введите текст объявления".'<br>';
        }
        if ( empty($id_razd)) {
            $msg .= "Укажите раздел".'<br>';
        }
        if ( empty($price)) {
            $msg .= "Укажите цену".'<br>';
        }
        if ( !empty($msg)) {
            $_SESSION['div']['title'] = $title;
            $_SESSION['div']['text'] = $text;
            $_SESSION['div']['town'] = $town;
            $_SESSION['div']['price'] = $price;
            return $msg;
        }

        $img_types = array(
            'jpeg' => 'image/jpeg',
            'pjpeg-e' => 'image/pjpeg',
            'png' => 'image/png',
            'x-png' => 'image/x-png',
            'gif' => 'image/gif'
        );

        if ( !empty($_FILES['img']['tmp_name']) ) {

            if ( !empty($_FILES['img']['error']) ) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "Error upload image";
            }

            $type_img = array_search($_FILES['img']['type'],$img_types);
            if ( !$type_img ) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "Wrong type img";
            }

            if ( $_FILES['img']['size'] > (2*1024*1024) ) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "Very big img";
            }

            if ( !move_uploaded_file($_FILES['img']['tmp_name'],FILES.$_FILES['img']['name']) ) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "Error copy image";
            }

            if(!img_resize($_FILES['img']['name'],$type_img)) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "Error to resize image";
            }

            if ( empty($_SESSION['str_cap']) || $_SESSION['str_cap'] !== $post['capcha']) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "WRONG capcha";
            }

            $img = $_FILES['img']['name'];

            $sql = "INSERT INTO ".PREF."post (
                        title,text,img,date,id_user,
                        id_categories,id_razd,town,time_over,price
                    )
                    VALUES(
                        '$title','$text','$img','$date','$user_id',
                        '$id_categories','$id_razd','$town','$time_over','$price'
                    )";

            $result = mysqli_query($connect,$sql);

            if (!$result) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return mysqli_error($connect);
            }

        }
        else {
            $_SESSION['div']['title'] = $title;
            $_SESSION['div']['text'] = $text;
            $_SESSION['div']['town'] = $town;
            $_SESSION['div']['price'] = $price;
            return "Добавьте изображение";
        }

        if ( !empty($_FILES['mini']) ) {
            $id_mess = mysqli_insert_id($connect);

            $img_s = "";

            for( $i = 0; $i < count($_FILES['mini']['tmp_name']); $i++ ) {
                if ( empty($_FILES['mini']['tmp_name'][$i]) ) continue;

                if ( !empty($_FILES['mini']['error'][$i]) ) {
                    $_SESSION['div']['title'] = $title;
                    $_SESSION['div']['text'] = $text;
                    $_SESSION['div']['town'] = $town;
                    $_SESSION['div']['price'] = $price;
                    $msg .= "Error upload image";
                    continue;
                }

                $type_img = array_search($_FILES['mini']['type'][$i],$img_types);
                if ( !$type_img ) {
                    $_SESSION['div']['title'] = $title;
                    $_SESSION['div']['text'] = $text;
                    $_SESSION['div']['town'] = $town;
                    $_SESSION['div']['price'] = $price;
                    $msg = "Wrong type img";
                    continue;
                }

                if ( $_FILES['mini']['size'][$i] > (2*1024*1024) ) {
                    $_SESSION['div']['title'] = $title;
                    $_SESSION['div']['text'] = $text;
                    $_SESSION['div']['town'] = $town;
                    $_SESSION['div']['price'] = $price;
                    $msg = "Very big img";
                    continue;
                }

                $name_img = $id_mess."_".$i;
                $rash = substr($_FILES['mini']['name'][$i],strripos($_FILES['mini']['name'][$i],"."));
                $name_img .= $rash;

                if ( !move_uploaded_file($_FILES['mini']['tmp_name'][$i],FILES.$name_img) ) {
                    $_SESSION['div']['title'] = $title;
                    $_SESSION['div']['text'] = $text;
                    $_SESSION['div']['town'] = $town;
                    $_SESSION['div']['price'] = $price;
                    $msg = "Error copy image";
                    continue;
                }

                if(!img_resize($name_img,$type_img)) {
                    $_SESSION['div']['title'] = $title;
                    $_SESSION['div']['text'] = $text;
                    $_SESSION['div']['town'] = $town;
                    $_SESSION['div']['price'] = $price;
                    return "Error to resize mini image";
                }


                $img_s .= $name_img."|";
            }

            $img_s = rtrim($img_s,"|");

            $sql = "UPDATE ".PREF."post SET img_s = '$img_s' WHERE id = '$id_mess'";

            $result2 = mysqli_query($connect,$sql);
            if( mysqli_affected_rows($connect) ) {
                if( !empty($msg) ) {
                    return $msg;
                }
                return TRUE;
            }
        }
        else {
            return TRUE;
        }
    }

    function img_resize($file_name,$type) {
        switch ($type) {
            case 'jpeg':
            case 'pjpeg':
                $img_id = imagecreatefromjpeg(FILES.$file_name);
                break;
            case 'png':
            case 'x-png':
                $img_id = imagecreatefrompng(FILES.$file_name);
                break;
            case 'gif':
                $img_id = imagecreatefromgif(FILES.$file_name);
                break;
            default:
                break;
        }

        $img_width = imagesx($img_id);
        $img_height = imagesy($img_id);

        $k = round($img_width/IMG_WIDTH,2);

        $img_mini_width = round($img_width/$k);
        $img_mini_height = round($img_height/$k);

        $img_dest_id = imagecreatetruecolor($img_mini_width,$img_mini_height);

        $result = imagecopyresampled($img_dest_id,$img_id,0,0,0,0,$img_mini_width,$img_mini_height,$img_width,$img_height);

        switch ($type) {
            case 'jpeg':
            case 'pjpeg':
                $img = imagejpeg($img_dest_id,MINI.$file_name,100);
                break;
            case 'png':
            case 'x-png':
                $img = imagepng($img_dest_id,MINI.$file_name);
                break;
            case 'gif':
                $img = imagegif($img_dest_id,MINI.$file_name);
                break;
            default:
                break;
        }

        imagedestroy($img_id);
        imagedestroy($img_dest_id);

        if ($img) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    function get_p_mess($user) {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT
                    ".PREF."post.id,
                    ".PREF."post.title,
                    img,text,date,town,price,
                    ".PREF."post.confirm,
                    is_actual,
                    time_over,
                    ".PREF."users.name AS uname,
                    ".PREF."users.email,
                    ".PREF."categories.name AS cat,
                    ".PREF."razd.name AS razd
                FROM ".PREF."post
                LEFT JOIN ".PREF."users ON ".PREF."users.user_id = '$user'
                LEFT JOIN ".PREF."categories ON ".PREF."categories.id = ".PREF."post.id_categories
                LEFT JOIN ".PREF."razd ON ".PREF."razd.id = ".PREF."post.id_razd
                WHERE ".PREF."post.id_user = '$user'
                ORDER by date DESC";
        $result = mysqli_query($connect,$sql);
        return get_result($result);
    }

    function small_text($text) {
        $row = array();
        foreach ( $text as $value ) {
            if ( strlen($value['text']) > 300 ) {
                $value['text'] = substr($value['text'],0,300);
                $value['text'] = substr($value['text'],0,strrpos($value['text']," "))."...";
            }
            $row[] = $value;
        }
        return $row;
    }

    function get_v_mess($id,$can = FALSE) {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT
                    ".PREF."post.id,
                    ".PREF."post.title,
                    img,text,date,town,price,img_s,
                    ".PREF."post.confirm,
                    is_actual,
                    time_over,
                    ".PREF."users.name AS uname,
                    ".PREF."users.email,
                    ".PREF."categories.name AS cat,
                    ".PREF."razd.name AS razd
                FROM ".PREF."post
                LEFT JOIN ".PREF."users ON ".PREF."users.user_id = ".PREF."post.id_user
                LEFT JOIN ".PREF."categories ON ".PREF."categories.id = ".PREF."post.id_categories
                LEFT JOIN ".PREF."razd ON ".PREF."razd.id = ".PREF."post.id_razd
                WHERE ".PREF."post.id = '$id'";

        if ( !$can ) {
            $sql .= " AND ".PREF."post.confirm='1' AND is_actual='1'";
        }

        $result = mysqli_query($connect,$sql);
        $row = get_result($result);

        return $row[0];

    }

    function check_you_mess($user_id,$id_mess) {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT id_user FROM ".PREF."post WHERE id='$id_mess'";

        $result = mysqli_query($connect,$sql);
        $row = get_result($result);

        if ( $row[0]['id_user'] === $user_id ) {
            return TRUE;
        }

        return FALSE;
    }

    function get_e_mess($id_mess) {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT id,title,text,date,id_user,id_categories,id_razd,town,img,time_over,is_actual,price,img_s FROM ".PREF."post WHERE id='$id_mess'";

        $result = mysqli_query($connect,$sql);
        $row = get_result($result);

        return $row[0];
    }

    function edit_mess($post,$id_u) {
    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $id = (int)($post['id']);
        $title = clear_str($post['title']);
        $text = $post['text'];
        $id_categories = (int)($post['id_categories']);
        $id_razd = (int)($post['id_razd']);
        $price = (int)($post['price']);
        $town = clear_str($post['town']);
        $date = time();
        $a_time = (int)($post['time']);
        $time_over = $date + ($a_time*(60*60*24));

        $msg = '';

        if ( empty($_SESSION['str_cap']) || $_SESSION['str_cap'] !== $post['capcha']) {
            return "WRONG capcha";
        }

        unset($_SESSION['str_cap']);

        if ( empty($title)) {
            $msg .= "Введите заголовок";
        }

        if ( empty($text)) {
            $msg .= "Введите текст";
        }
        
        if ( !empty($msg)) {
            return $msg;
        }

        $sql = "UPDATE ".PREF."post SET
        							title='$title',
        							text='$text',
        							town='$town',
        							date='$date',
        							id_user='$id_u',
        							id_categories='$id_categories',
        							id_razd='$id_razd',
        							time_over='$time_over',
        							price='$price',
        							confirm='0',
        							is_actual='1' WHERE id='$id'
        							";

		$result = mysqli_query($connect,$sql);

		if ( !$result ) {
			exit(mysqli_error($connect));
		}

		if ( mysqli_affected_rows($connect) < 1 ) {
			$msg = "Данные не обновлены";
		}

        $img_types = array(
            'jpeg' => 'image/jpeg',
            'pjpeg-e' => 'image/pjpeg',
            'png' => 'image/png',
            'x-png' => 'image/x-png',
            'gif' => 'image/gif'
        );

        if ( !empty($_FILES['img']['tmp_name']) ) {

            if ( !empty($_FILES['img']['error']) ) {
                $_SESSION['div']['title'] = $title;
                $_SESSION['div']['text'] = $text;
                $_SESSION['div']['town'] = $town;
                $_SESSION['div']['price'] = $price;
                return "Error upload image";
            }

            $type_img = array_search($_FILES['img']['type'],$img_types);

            if ( !$type_img ) {
                return "Wrong type img";
            }

            if ( $_FILES['img']['size'] > (2*1024*1024) ) {
                return "Very big img";
            }

            if ( !move_uploaded_file($_FILES['img']['tmp_name'],FILES.$_FILES['img']['name']) ) {
                return "Error copy image";
            }

            if(!img_resize($_FILES['img']['name'],$type_img)) {
                return "Error to resize image";
            }

            $img = $_FILES['img']['name'];

            $sql2 = "UPDATE ".PREF."post SET img='$img' WHERE id='$id'";

            $result2 = mysqli_query($connect,$sql);

            if (!$result2) {
                return mysqli_error($connect);
            }

            if ( mysqli_affected_rows($connect) < 1 ) {
				$msg = "Данные не обновлены";
			}

        }

        if ( !empty($_FILES['mini']) ) {
            $id_mess = mysqli_insert_id($connect);

            $img_s = "";

            for( $i = 0; $i < count($_FILES['mini']['tmp_name']); $i++ ) {
                if ( empty($_FILES['mini']['tmp_name'][$i]) ) continue;

                if ( !empty($_FILES['mini']['error'][$i]) ) {
                    $msg .= "Error upload image";
                    continue;
                }

                $type_img = array_search($_FILES['mini']['type'][$i],$img_types);
                if ( !$type_img ) {
                    $msg = "Wrong type img";
                    continue;
                }

                if ( $_FILES['mini']['size'][$i] > (2*1024*1024) ) {
                    $msg = "Very big img";
                    continue;
                }

                $name_img = $id_mess."_".$i;
                $rash = substr($_FILES['mini']['name'][$i],strripos($_FILES['mini']['name'][$i],"."));
                $name_img .= $rash;

                if ( !move_uploaded_file($_FILES['mini']['tmp_name'][$i],FILES.$name_img) ) {
                    $msg = "Error copy image";
                    continue;
                }

                if(!img_resize($name_img,$type_img)) {
                    return "Error to resize mini image";
                }


                $img_s .= $name_img."|";
            }

            if ( !empty($img_s) ) {
        		$img_s = rtrim($img_s,"|");

            	$sql3 = "UPDATE ".PREF."post SET img_s='$img_s' WHERE id='$id'";

            	$result3 = mysqli_query($connect,$sql3);

	            if ( !$result3 ) {
					exit(mysqli_error($connect));
				}

	            if( mysqli_affected_rows($connect) < 1) {
	                $msg = "Не обновлены дополнительные изображения";
	            }
	            else {
	            	return TRUE;
	            }
            }

        }
        
        if ( !$msg ) {
    		return TRUE;
        }
        else {
        	return $msg;
        }
    }

    function delete_mess($id_mess) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "DELETE FROM ".PREF."post WHERE id='$id_mess'";

        $result = mysqli_query($connect,$sql);

        if ( $result ) {
        	return TRUE;
        } 
        else {
        	return mysqli_error($connect);
        }
    }

    function update_actual_time($id_mess,$actual_t) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $time = time();

        $time_over = $time + $actual_t*(60*60*24);

        $sql = "UPDATE ".PREF."post SET time_over='$time_over',is_actual='1' WHERE id='$id_mess'";

        $result = mysqli_query($connect,$sql);

        if ( !$result ) {
        	return mysqli_error($connect);
        }

        if ( mysqli_affected_rows($connect) < 1 ) {
        	return "Не обновлено";
        } 

        return TRUE;
    }

    function count_mess( $id_r = FALSE, $id_c = FALSE ) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT COUNT(*) as count FROM ".PREF."post WHERE confirm='1' AND is_actual='1'";

        if ( $id_r ) {
        	$sql .= " AND id_razd='$id_r'";
        }

        if ( $id_c ) {
        	$sql .= " AND id_categories='$id_c'";
        }

        $result = mysqli_query($connect,$sql);

        $row = get_result($result);

        return $row[0]['count'];
    }

    function get_mess( $id_r = FALSE, $id_c = FALSE, $page, $perpage ) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $start = ($page-1)*$perpage;

        $sql = "SELECT
                    ".PREF."post.id,
                    ".PREF."post.title,
                    img,
                    text,
                    date,
                    town,
                    price,
                    ".PREF."post.confirm,
                    is_actual,
                    time_over,
                    ".PREF."users.name AS uname,
                    ".PREF."users.email,
                    ".PREF."categories.name AS cat,
                    ".PREF."razd.name AS razd
                FROM ".PREF."post
                LEFT JOIN ".PREF."users ON ".PREF."users.user_id = ".PREF."post.id_user
                LEFT JOIN ".PREF."categories ON ".PREF."categories.id = ".PREF."post.id_categories
                LEFT JOIN ".PREF."razd ON ".PREF."razd.id = ".PREF."post.id_razd
                WHERE ".PREF."post.confirm ='1' AND ".PREF."post.is_actual='1'";

        if ( $id_r ) {
        	$sql .= " AND id_razd='$id_r'";
        }

        if ( $id_c ) {
        	$sql .= " AND id_categories='$id_c'";
        } 

        $sql .= "ORDER by date DESC";
        $sql .= " LIMIT $start,$perpage";

        $result = mysqli_query($connect,$sql);
        return get_result($result);

    }

    function get_navigation($page,$count_mess,$perpage) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $n_pages = (int)($count_mess/$perpage);

        if ( $count_mess%$perpage != 0 ) {
        	$n_pages++;	
        }

        if ( $count_mess < $perpage || $page > $n_pages ) {
        	return FALSE;
        }

        $result = array();

        if ( $page != 1 ) {
        	$result['first'] = 1;
        	$result['last_page'] = $page - 1; 
        }

        if ( $page > C_LINKS + 1 ) {
        	for ( $i = $page - C_LINKS; $i < $page; $i++ ) {
        		$result['previous'][] = $i;
        	}
        }
        else {
        	for ( $i = 1;$i < $page; $i++ ) {
        		$result['previous'][] = $i;
        	}
        }

        $result['current'] = $page;

        if ( $page + C_LINKS < $n_pages ) {
        	for ( $i = $page + 1; $i <= $page + C_LINKS; $i++ ) {
        		$result['next'][] = $i;
        	}
        }
        else {
        	for ( $i = $page + 1; $i <= $n_pages; $i++ ) {
        		$result['next'][] = $i;
        	}
        }

        if ( $page != $n_pages ) {
        	$result['next_pages'] = $page + 1;
        	$result['end'] = $n_pages;
        }

        return $result;
    }

    function count_s_mess($get) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

    	$search = clear_str($get['search']);
    	$id_categories = (int)clear_str($get['id_categories']);
    	$id_razd = (int)clear_str($get['id_razd']);
    	$p_min = (int)clear_str($get['p_min']);
    	$p_max = (int)clear_str($get['p_max']);

    	if ( !$search && !$id_categories && !$id_razd && !$p_max && !$p_min ) {
    		return "Нет поискового запроса";
    	}

    	$sql = "SELECT COUNT(*) as count FROM 
    		".PREF."post WHERE 
    		".PREF."post.confirm='1' AND 
    		".PREF."post.is_actual='1'";

		if ( $search ) {
			if ( mb_strlen($search,'UTF-8') < 4 ) {
				return "Поисковый запрос должен быть более четырёх символов";
			}

			$sql .= " AND MATCH(title,text) AGAINST('$search' IN BOOLEAN MODE)";
		}

		if ( $id_categories ) {
			$sql .= " AND id_categories='$id_categories'";
		}

		if ( $id_razd ) {
			$sql .= " AND id_razd='$id_razd'";
		}

		if ( $p_min && !$p_max ) {
			$sql .= " AND price > '$p_min'";
		}

		if ( !$p_min && $p_max ) {
			$sql .= " AND price < '$p_max'";
		}

		if ( $p_min && $p_max ) {
			$sql .= " AND price BETWEEN '$p_min' AND '$p_max'";
		}

		$result = mysqli_query($connect,$sql);

		$row = get_result($result);

		return $row[0]['count'];
    }

    function get_search($get,$page,$perpage) {

    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

    	$search = clear_str($get['search']);
        $search_town = clear_str($get['search-town']);
    	$id_categories = (int)clear_str($get['id_categories']);
    	$id_razd = (int)clear_str($get['id_razd']);
    	$p_min = (int)clear_str($get['p_min']);
    	$p_max = (int)clear_str($get['p_max']);

    	$start = ($page-1)*$perpage;

    	$sql = "SELECT
                    ".PREF."post.id,
                    ".PREF."post.title,
                    img,text,date,town,price,
                    ".PREF."post.confirm,
                    is_actual,
                    time_over,
                    ".PREF."users.name AS uname,
                    ".PREF."users.email,
                    ".PREF."categories.name AS cat,
                    ".PREF."razd.name AS razd
                FROM ".PREF."post
                LEFT JOIN ".PREF."users ON ".PREF."users.user_id = ".PREF."post.id_user
                LEFT JOIN ".PREF."categories ON ".PREF."categories.id = ".PREF."post.id_categories
                LEFT JOIN ".PREF."razd ON ".PREF."razd.id = ".PREF."post.id_razd
                WHERE ".PREF."post.confirm ='1' AND ".PREF."post.is_actual='1'";



		if ( $search ) {

			if ( mb_strlen($search,'UTF-8') < 4 ) {
				return "Поисковый запрос должен быть более четырёх символов";
			}

			$sql .= " AND title LIKE '%$search%'";
		}

        if ( !$search && !$search_town && !$id_categories && !$id_razd && !$p_max && !$p_min ) {
            return "Нет поискового запроса";
        }

		if ( $id_categories ) {
			$sql .= " AND id_categories='$id_categories'";
		}

		if ( $id_razd ) {
			$sql .= " AND id_razd='$id_razd'";
		}

        if ( $search_town ) {
            $sql .= " AND town='$search_town'";
        }

		if ( $p_min && !$p_max ) {
			$sql .= " AND price > '$p_min'";
		}

		if ( !$p_min && $p_max ) {
			$sql .= " AND price < '$p_max'";
		}

		if ( $p_min && $p_max ) {
			$sql .= " AND price BETWEEN '$p_min' AND '$p_max'";
		}

		$sql .= " LIMIT $start,$perpage";

		$result = mysqli_query($connect,$sql);

        if ( !$result ) {
            return 'Ничего не найдено';
        }

		$row = get_result($result);

		return $row;
    }

    function count_nc_mess() {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT COUNT(*) as count FROM ".PREF."post WHERE confirm='0' AND is_actual='1'";

        $result = mysqli_query($connect,$sql);

        $row = get_result($result);

        return $row[0]['count'];
    }

    function get_nc_mess($page,$perpage) {

        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $start = ($page-1)*$perpage;

        $sql = "SELECT
                    ".PREF."post.id,
                    ".PREF."post.title,
                    ".PREF."users.name AS uname,
                    ".PREF."users.email,
                    ".PREF."categories.name AS cat,
                    ".PREF."razd.name AS razd
                FROM ".PREF."post
                LEFT JOIN ".PREF."users ON ".PREF."users.user_id = ".PREF."post.id_user
                LEFT JOIN ".PREF."categories ON ".PREF."categories.id = ".PREF."post.id_categories
                LEFT JOIN ".PREF."razd ON ".PREF."razd.id = ".PREF."post.id_razd
                WHERE ".PREF."post.confirm ='0'";;

        $sql .= "ORDER by date DESC";
        $sql .= " LIMIT $start,$perpage";

        $result = mysqli_query($connect,$sql);
        return get_result($result);
    }

    function confirm_mess($id_mess) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "UPDATE ".PREF."post SET confirm='1' WHERE id IN(".$id_mess.")";

        $result = mysqli_query($connect,$sql);

        if ( !$result ) {
            return mysqli_error($connect);
        }

        if ( mysqli_affected_rows($connect) < 1 ) {
            return "Не обновлено";
        }

        return TRUE;
    }

    function confirm_actual() {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $time = time();

        $sql = "UPDATE ".PREF."post SET is_actual='0' WHERE time_over < '$time'";

        $result = mysqli_query($connect,$sql);

        if ( !$result ) {
            return mysqli_error($connect);
        }

        $result = mysqli_affected_rows($connect);

        if ( $result < 1 ) {
            return "Не обновлено";
        }

        return $result;
    }

    function get_roles() {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT id,name FROM ".PREF."role";

        $result = mysqli_query($connect,$sql);

        return get_result($result);
    }

    function get_priv() {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT
                    ".PREF."priv.name,
                    ".PREF."priv.id,
                    ".PREF."role_priv.id_role
                    FROM ".PREF."priv
                    LEFT JOIN ".PREF."role_priv
                        ON ".PREF."role_priv.id_priv=".PREF."priv.id";

        $result = mysqli_query($connect,$sql);

        if ( !$result ) {
            return mysqli_error($connect);
        }

        for ($i = 0; mysqli_num_rows($result) > $i; $i++ ) {
            $row = mysqli_fetch_array($result,MYSQL_ASSOC);

            $arr[$row['name']][$row['id_role']] = TRUE;
            $arr[$row['name']]['id_priv'] = $row['id'];
        }

        return $arr;
    }

    function edit_role_priv($post) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $query = "DELETE FROM ".PREF."role_priv";

        $res = mysqli_query($connect,$query);

        if( !$res ) {
            exit(mysqli_error($connect));
        }

        $msg = '';

        foreach ( $post as $key => $value ) {
            foreach ( $value as $item ) {
                $sql = "INSERT INTO ".PREF."role_priv SET id_priv='$item',id_role='$key'";
                $result = mysqli_query($connect,$sql);

                if( !$result ) {
                    $msg .= mysqli_error($connect);
                }
            }
        }

        if ( $msg ) {
            return $msg;
        }

        return TRUE;
    }

    function delete_users($del_id) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "DELETE FROM ".PREF."users WHERE user_id IN ($del_id)";

        $result = mysqli_query($connect,$sql);

        if ( $result ) {
            return TRUE;
        }
        else  {
            return mysqli_error($connect);
        }
    }

    function confirm_users($id_user) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "UPDATE ".PREF."users SET confirm='1' WHERE user_id='$id_user'";

        $result = mysqli_query($connect,$sql);

        if ( !$result ) {
            return mysqli_error($connect);
        }

        if ( mysqli_affected_rows($connect) < 1 ) {
            return "Не обновлено";
        }

        return TRUE;
    }

    function edit_role_user($id_user,$id_role) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "UPDATE ".PREF."users SET id_role='$id_role' WHERE user_id='$id_user'";

        $result = mysqli_query($connect,$sql);

        if (!$result) {
            return mysqli_error($connect);
        }

        if ( mysqli_affected_rows($connect) < 1 ) {
            return "Не обновлено";
        }

        return TRUE;
    }

    function get_users($page,$perpage) {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $start = ($page-1)*$perpage;

        $sql = "SELECT
                    user_id,
                    login,
                    ".PREF."users.name,
                    confirm,
                    email,
                    id_role,
                    ".PREF."role.name AS role
                    FROM ".PREF."users
                    LEFT JOIN ".PREF."role ON ".PREF."users.id_role = ".PREF."role.id
                    ORDER by id DESC LIMIT $start,$perpage";

        $result = mysqli_query($connect,$sql);

        return get_result($result);
    }

    function count_users() {
        $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT COUNT(*) as count FROM ".PREF."users";

        $result = mysqli_query($connect,$sql);

        $row = get_result($result);

        return $row[0]['count'];
    }

    function add_category($post) {
		$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $name = clear_str($post['name']);
        $parent_id = (int)$post['parent_id'];

        $sql = "INSERT INTO ".PREF."categories(name,parent_id) VALUES ('$name','$parent_id')";

        $result = mysqli_query($connect,$sql);

        if ( !$result ) {
        	return mysql_error($connect);
        }

        return TRUE;
    }

    function edit_category($post) {
    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $id = (int)$post['id'];
        $name = clear_str($post['name']);
        $parent_id = (int)$post['parent_id'];

        $sql = "UPDATE ".PREF."categories set name='$name',parent_id='$parent_id' WHERE id='$id'";
        $result = mysqli_query($connect,$sql);
        if ( !$result ) {
        	return mysql_error($connect);
        }

        return TRUE;
    }

    function get_cat($id) {
    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT id,name,parent_id FROM ".PREF."categories WHERE id='$id'";

        $result = mysqli_query($connect,$sql);
        $row = get_result($result);

        return $row[0];
    }


    function get_child($id) {
    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT COUNT(*) as count FROM ".PREF."categories WHERE parent_id='$id'";

        $result = mysqli_query($connect,$sql);
        $row = get_result($result);

        return $row[0]['count'];
    }

    function delete_cat($id) {
    	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die(mysqli_error($connect));
        mysqli_select_db($connect,DB_NAME);
        mysqli_set_charset($connect, "utf8");

        $sql = "DELETE FROM ".PREF."categories WHERE id='$id'";

        $result = mysqli_query($connect,$sql);

        if ( $result ) {
    		return TRUE;
        }
        else {
        	return mysqli_error($connect);
        }
    }

?>