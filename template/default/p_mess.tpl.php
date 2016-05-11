<h3 class="title_page">Личные объявления</h3>
<? if($_SESSION['msg']) : ?>
    <?= $_SESSION['msg']; ?>
    <?php unset($_SESSION['msg']);?>
<? endif; ?>
<?php if ($text) : ?>
    <?php foreach ( $text as $item ) { ?>
        <div class="t_mess">
        <h4 class="title_p_mess">
            <a href="?action=view_mess&id=<?=$item['id'];?>"><?=$item['title'];?></a>
        </h4>
        <?php if ($item['confirm'] == 0) : ?>
            <p class="no_confirm"><strong>Ещё не подтвержденно модератором</strong></p>
        <?php endif; ?>
        <?php if ($item['is_actual'] == 0) : ?>
            <p class="no_actual"><strong>Уже не актуально</strong></p>
        <?php endif; ?>
        <div class="p_mess_cat">
            <strong>Категория: </strong><?=$item['cat'];?>
            <strong>Тип объявления: </strong><?=$item['razd'];?>
            <strong>Город: </strong><?=$item['town'];?>
        </div>
        <div class="p_mess_cat">
            <strong>Дата добавления объявления: </strong><?=date("d.m.Y",$item['date']);?>
            <strong>Цена: </strong><?=$item['price'];?>
            <strong>Автор: </strong><a href="mailto:<?=$item['email'];?>"><?=$item['uname'];?></a>
        </div>
        <div class="mess_desc">
            <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$item['img'];?>">
            <div class="text_desc">
                <?=nl2br($item['text']);?>
            </div>
        </div>

<form method="POST">
	Период актуальности объявления:
	<select name="time">
		<option value="10">10 дней</option>
		<option value="15">15 дней</option>
		<option value="20">20 дней</option>
		<option value="30">30 дней</option>
	</select>
	<input type="hidden" name="id" value="<?=$item['id'];?>">
	<input type="submit" value="Ok">
	&nbsp;|&nbsp;<a href="?action=edit_mess&id=<?=$item['id'];?>">Изменить</a>
	&nbsp;|&nbsp;<a href="?action=p_mess&delete=<?=$item['id'];?>">Удалить</a>
</form>
</div>
    <?php } ?>
<?php endif; ?>


