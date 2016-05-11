<div style="width: 300px; margin: 0 auto; border: 2px solid grey; text-align: center">

    <?php if ( $acc ) : ?>
        <p style="color: red"><?= $acc; ?></p>
    <? endif; ?>

    <h1>Авторизируйтесь</h1>
        <?= $_SESSION['msg']; ?>
        <?php unset($_SESSION['msg'])?>
            <form method="POST">
                <label>
                login<br/>
                    <input type="text" name="login"/>
                </label><br/>
                Password<br/>
                <label>
                    <input type="password" name="password"/>
                </label><br/>
                <br/>
                <input type="submit" value="Вход"/>
            </form>
            <br/>
</div>
