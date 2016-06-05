<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=SITE_NAME_HEADER;?></title>
    <meta http-equiv="Content-Type" charset=UTF-8" name="viewport" content="width=device-width, initial-scale=1">

    <!-- Reset all browsers stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>css/reset.css">
    <!-- Grid System Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>css/960.css">
    <!-- Font Awesome Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>css/font-awesome.css">
    <!--  Gallery Styles  -->
    <link href="<?=TEMPLATE;?>css/lightbox.css" rel="stylesheet">
    <!-- Slick Slyder Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>slick/slick.css">
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>slick/slick-theme.css">
    <!-- Custom Stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>css/custom.css">
    <!-- Latest compiled and minified JQuery -->
    <script  src="https://code.jquery.com/jquery-1.12.2.min.js"></script>
    <!--  Slick Slider script  -->
    <script type="text/javascript" src="<?=TEMPLATE;?>slick/slick.min.js"></script>
    <!-- Main JS script -->
    <script src="<?=TEMPLATE;?>scripts/main.js"></script>
</head>
<body>
    <header>
        <div class="top">
            <div class="authentication container_12">
                <?php if(!$user) : ?>
                    <a href="?action=login">Вход</a> | <a href="?action=registration">Регистрация</a>
                <?php else :?>
                    <b><?= $user['name']; ?></b> | <a href="?action=login&logout=1">Выход</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="bottom">
            <div class="container_12">
                <a class="site_logo grid_5" href="<?=SITE_NAME;?>">
                    <img src="<?=TEMPLATE;?>images/logo.png" alt="">
                    <span>Доска Объявлений</span>
                </a>
                <div class="grid_1"></div>
                <form method="GET" class="header_search grid_4">
                    <input name="action" value="search" type="hidden">
                    <input class="search_field" name="search" type="text" placeholder="Поиск по названию..."/>
                    <input class="header_search_btn" type="submit" value="Поиск">
                </form>
                <?php if($user) : ?>
                    <a href="?action=add_mess" class="add_post grid_2">
                        <span>Добавить объявление</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>