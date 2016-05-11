<?= $_SESSION['msg']; ?>
<? unset($_SESSION['msg']); ?>

<h2 class="col-sm-offset-3 col-ms-5">Регистрация</h2>

<form class="form-horizontal reg_form" METHOD="post">
    <div class="form-group">
        <label for="reg_login_input" class="col-sm-3 control-label"> Логин </label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="reg_login_input" placeholder="Логин" name="reg_login" autocomplete="off" value="<?= $_SESSION['reg']['login'];?>" />
        </div>
        <? unset($_SESSION['reg']['login']); ?>
    </div>
    <div class="form-group">
        <label for="reg_password_input" class="col-sm-3 control-label"> Пароль </label>
        <div class="col-sm-5">
            <input type="password" class="form-control" id="reg_password_input" placeholder="Пароль" name="reg_password" autocomplete="off" />
        </div>
    </div>
    <div class="form-group">
        <label for="reg_password_confirm_input" class="col-sm-3 control-label"> Подтвердите пароль </label>
        <div class="col-sm-5">
            <input type="password" class="form-control" id="reg_password_confirm_input" placeholder="Подтвердите пароль" name="reg_password_confirm" autocomplete="off" />
        </div>
    </div>
    <div class="form-group">
        <label for="reg_email_input" class="col-sm-3 control-label"> Email </label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="reg_email_input" placeholder="Email" name="reg_email" autocomplete="off" value="<?= $_SESSION['reg']['email'];?>"/>
        </div>
        <? unset($_SESSION['reg']['email']); ?>
    </div>
    <div class="form-group">
        <label for="reg_name_input" class="col-sm-3 control-label"> Ваше Имя </label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="reg_name_input" placeholder="Имя" name="reg_name" autocomplete="off" value="<?= $_SESSION['reg']['name'];?>"/>
        </div>
        <? unset($_SESSION['reg']['name']); ?>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-default" name="reg">Регистрация</button>
        </div>
    </div>
</form>
