<div class="container_12">
	<?php if($_SESSION['msg']) : ?>
		<div class="general_msg">
			<?=$_SESSION['msg']; ?>
			<?php unset($_SESSION['msg']); ?>
		</div>
	<?php endif; ?>
	<? if ( is_array($text) ) :?>
	<? if ( $text['is_actual'] == 0 ) :?>
		<p>не актуально</p>
	<? endif; ?>
		<div class="new_mess columns">
			<form method='POST' enctype="multipart/form-data" class="grid_8">
				<h1><?= $text['title']; ?></h1>

				<div class="form_input">
					<label for="add_mess_title">Заголовок объявления*:</label>
					<input id="add_mess_title" type='text'  name='title' value="<?= $text['title']; ?>">
					<input type='hidden'  name='id' value="<?= $text['id']; ?>">
				</div>
				<div class="form_input">
					<label for="add_mess_text">Текст объявления*:</label>
					<textarea id="add_mess_text" rows="3" name="text"><?= $text['text']; ?></textarea>
				</div>
				<div class="form_input">
					<label for="add_mess_id_categories">Категории*:</label>
					<select name="id_categories">
						<?php if ( $categories ) :?>
							<?php foreach( $categories as $key => $item ) :?>
								<optgroup label="<?=$item[0]?>">
									<?php foreach( $item['next'] as $k => $v ) :?>
										<? if ( $text['id_categories'] == $k ) : ?>
											<option selected value="<?=$k;?>">--<?=$v;?></option>
										<? else : ?>
											<option value="<?=$k;?>">--<?=$v;?></option>
										<? endif; ?>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
				<div class="form_input">
					<label>Выбеирте тип объявления*:</label>
					<?php if ( $razd ) :?>
						<?php foreach( $razd as $item ) :?>
							<? if ( $text['id_razd'] == $item['id'] ) : ?>
								<input checked type="radio" name="id_razd" value="<?= $item['id']; ?>"><?= $item['name']; ?>
							<? else : ?>
								<input type="radio" name="id_razd" value="<?= $item['id']; ?>"><?= $item['name']; ?>
							<? endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class="form_input">
					<label for="add_mess_town">Город*:</label>
					<input id="add_mess_town" type='text' name='town' value="<?= $text['town']; ?>">
				</div>
				<div class="form_input">
					<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
					<label for="add_mess_main_img">Основное изображение*:</label>
					<input type='file' name='img'>
					<img class="img" width="80px" src="<?= SITE_NAME."/".MINI.$text['img']; ?>">
				</div>
				<!--		<div class="form-group">-->
				<!--			<label>Дополнительные изображения:</label>-->
				<!--			<input type='file' name='img'> <br>-->
				<!--			<input type='file' name='img'>-->
				<!--		</div>-->
				<div class="form_input">
					<label for="add_mess_id_categories">Период актуальности объявления*: ( актуально ещё <?= $d_left; ?> )</label>
					<select id="add_mess_id_categories" name="time">
						<option value="10">10 дней</option>
						<option value="15">15 дней</option>
						<option value="20">20 дней</option>
						<option value="30">30 дней</option>
					</select>
				</div>
				<div class="form_input">
					<label for="add_mess_price">Цена*:</label>
					<input id="add_mess_price" type='text' name='price' value="<?= $text['price']; ?>">
				</div>
				<div class="form_input">
					<label for="add_mess_capcha">Введите строку*:</label>
					<img src="capcha.php"> <br><br>
					<input type='text' name='capcha' id="add_mess_capcha">
				</div>
				<div class="add_mess_btn">
					<button type="submit" name='reg'>Сохранить изменения</button>
				</div>
			</form>
			<div class="right_column grid_4">
				<div class="banners">
					<div class="title">Баннеры:</div>
					<div class="clear"></div>
					<div class="banner_wrapper">
						<a href="#">280x160</a>
					</div>
					<div class="banner_wrapper">
						<a href="#">280x160</a>
					</div>
				</div>
			</div>
		</div>
	<? else :?>
		<p>Данного текста нет</p>
	<? endif; ?>
</div>
