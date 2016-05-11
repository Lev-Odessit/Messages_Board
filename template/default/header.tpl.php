<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=SITE_NAME_HEADER;?></title>
    <meta http-equiv="Content-Type" charset=UTF-8" name="viewport" content="width=device-width, initial-scale=1">

    <!-- Reset all browsers stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>css/normalize.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Custom stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE;?>css/custom.css">
    <!-- Latest compiled and minified JQuery -->
    <script   src="https://code.jquery.com/jquery-1.12.2.min.js"   integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk="   crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- Main JS script -->
    <script src="<?=TEMPLATE;?>scripts/main.js"></script>

</head>
<body>
<div class="wrapper container">
    <header class="container-fluid">
        <h1 class="site_logo"><a href="<?=SITE_NAME;?>">Доска объявлений</a></h1>

        <div class="authentication">
            <?php if(!$user) : ?>
                <a href="?action=login">Вход</a>
                |
                <a href="?action=registration">Регистрация</a>
            <?php else :?>
                <span class="user_name">Добро пожаловать <strong><?= $user['name']; ?></strong> </span> | <a href="?action=login&logout=1">Выход</a>
            <?php endif; ?>
        </div>
    </header>