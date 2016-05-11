<?php if($_SESSION['msg']) : ?>
	<?= $_SESSION['msg']; ?>
	<?php unset($_SESSION['msg']);?>
<?php endif; ?>
<div class="col-md-7 col-md-offset-2">
	<h1>Новое объявление</h1>

	<?php unset($_SESSION['p']); ?>

	<form method='POST' enctype="multipart/form-data">
		<div class="form-group">
			<label for="add_mess_title">Заголовок объявления*:</label>
			<input id="add_mess_title" class="form-control" type='text'  name='title' value="<?=$_SESSION['p']['title'];?>">
		</div>
		<div class="form-group">
			<label for="add_mess_text">Текст объявления*:</label>
			<textarea id="add_mess_text" class="form-control" rows="3" name="text"></textarea>
		</div>
		<div class="form-group">
			<label for="add_mess_id_categories">Категории*:</label> <br>
			<select id="add_mess_id_categories" name="id_categories">
				<?php if ( $categories ) :?>
					<?php foreach( $categories as $key => $item ) :?>
						<optgroup label="<?=$item[0]?>">
							<?php foreach( $item['next'] as $k => $v ) :?>
								<option value="<?=$k;?>">--<?=$v;?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label><b>Выбеирте тип объявления*:</b></label> <br>
			<?php if ( $razd ) :?>
				<?php foreach( $razd as $item ) :?>
					<input type="radio" name="id_razd" value="<?= $item['id']; ?>"> <?= $item['name']; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="form-group">
			<label for="add_mess_town">Город*:</label>
			<input id="add_mess_town" class="form-control small-width" type='text' name='town' value="<?=$_SESSION['p']['town'];?>">
		</div>
		<div class="form-group">
			<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
			<label for="add_mess_main_img">Основное изображение*:</label>
			<input type='file' name='img'>
		</div>
		<div class="form-group">
			<label>Дополнительные изображения:</label>
			<input type='file' name='img'> <br>
			<input type='file' name='img'>
		</div>
		<div class="form-group">
			<label for="add_mess_id_categories">Период актуальности объявления*:</label> <br>
			<select id="add_mess_id_categories" name="time">
				<option value="10">10 дней</option>
				<option value="15">15 дней</option>
				<option value="20">20 дней</option>
				<option value="30">30 дней</option>
			</select>
		</div>
		<div class="form-group">
			<label for="add_mess_price">Цена*:</label>
			<input id="add_mess_price" class="form-control small-width" type='text' name='price' value="<?=$_SESSION['p']['town'];?>">
		</div>
		<div class="form-group">
			<label for="add_mess_capcha">Введите строку*:</label> <br>
			<img src="capcha.php"> <br><br>
			<input class="form-control small-width" type='text' name='capcha' id="add_mess_capcha">
		</div>
		<button type="submit" name='reg' class="btn btn-default">Добавить</button>
	</form>
</div>