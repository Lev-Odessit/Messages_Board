<?= $_SESSION['msg']; ?>
<?php unset($_SESSION['msg']); ?>

<h2 class="col-sm-offset-2 col-ms-5">Авторизируйтесь</h2>

<form class="form-horizontal login_form" METHOD="post">
    <div class="form-group">
        <label for="login_input" class="col-sm-2 control-label"> Логин </label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="login_input" placeholder="Логин" name="login" autocomplete="off">
        </div>
    </div>
    <div class="form-group">
        <label for="password_input" class="col-sm-2 control-label"> Пароль </label>
        <div class="col-sm-5">
            <input type="password" class="form-control" id="password_input" placeholder="Пароль" name="password" autocomplete="off">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-11">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="member"> Запомнить меня
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-11">
            <button type="submit" class="btn btn-default">Логин</button>
        </div>
    </div>
</form>
