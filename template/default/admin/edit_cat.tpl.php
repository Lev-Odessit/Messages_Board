<h3 class="title_page">Категории</h3>
<?php if($_SESSION['msg']) : ?>
    <?= $_SESSION['msg']; ?>
    <?php unset($_SESSION['msg']);?>
<?php endif; ?>
<div class="new_cat">
	<?php if ( $do == 'add' ) : ?>
		<strong>Новая категория</strong>
		<form method="POST">
			<p>Имя категории: <br />
				<input type="text" name="name" />
			</p>
			<p>
			Тип категории: <br />
			<select name="parent_id">
				<option value="0">Родительская</option>
				<?php if( is_array($categories) ) : ?>
					<? foreach($categories as $key => $item ) : ?>
						<option value="<?=$key?>"><?=$item['0']?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>		
			</p>
			<input type="submit" value="Ok">
		</form>
	<?php elseif ( $do == 'edit' ) : ?>
		<strong>Категория - <?= $cat['name'] ?></strong>
		<form method="POST">
			<p>
                Имя категории: <br />
				<input type="text" name="name" value="<?= $cat['name'] ?>" /><br /><br />
                Идентификатор категории: <br />
				<input type="text" name="id" value="<?= $cat['id'] ?>" />
			</p>
			<p>
			Тип категории: <br />
			<select name="parent_id">
				<option value="0">Родительская</option>
				<?php if( is_array($categories) ) : ?>
					<? foreach($categories as $key => $item ) : ?>
						<?php if ( $cat['parent_id'] == $key ) : ?>
							<option selected value="<?=$key?>"><?=$item['0']?></option>
						<?php else : ?>
							<option value="<?=$key?>"><?=$item['0']?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>		
			</p>
			<input type="submit" value="Ok">
		</form>
	<?php endif; ?>
</div>
<div class="edit_cat">
    <?php if( is_array($categories) ) : ?>
        <table cellspacing="0" class="moder_mess">
            <thead>
                <th>Категория</th>
                <th>Родительская</th>
                <th>Изменить</th>
                <th>Удалить</th>
            </thead>
            <? foreach($categories as $key => $item ) : ?>
                <tr>
                    <td class="title">
                        <strong>
                            <?=$item['0']?>
                        </strong>
                    </td>
                    <td>
                        Родительская
                    </td>
                    <td>
                        <a href="<?=SITE_NAME;?>/admin.php?action=edit_cat&id=<?=$key?>&do=edit">Изменить</a>
                    </td>
                    <td>
                        <a href="<?=SITE_NAME;?>/admin.php?action=edit_cat&id=<?=$key?>&do=delete">Удалить</a>
                    </td>
                </tr>
                <?php if(is_array($item['next'])) : ?>
                    <? foreach($item['next'] as $key => $cat ) : ?>
                        <tr>
                            <td class="title">
                                --<?=$cat?>
                            </td>
                            <td>
                                Дочерняя
                            </td>
                            <td>
                                <a href="<?=SITE_NAME;?>/admin.php?action=edit_cat&id=<?=$key?>&do=edit">Изменить</a>
                            </td>
                            <td>
                                <a href="<?=SITE_NAME;?>/admin.php?action=edit_cat&id=<?=$key?>&do=delete">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>