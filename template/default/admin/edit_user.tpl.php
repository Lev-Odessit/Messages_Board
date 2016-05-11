<h3 class="title_page">Пользователи</h3>
<?php if($_SESSION['msg']) : ?>
    <?= $_SESSION['msg']; ?>
    <?php unset($_SESSION['msg']);?>
<?php endif; ?>
<?php if ($text) : ?>
	<form method="POST">
		<table cellspacing="0" class="moder_mess">
			<thead>
				<th>id</th>
				<th>login|name</th>
				<th>role</th>
				<th>confirm</th>
				<th>Delete</th>
			</thead>
			<?php foreach ($text as $item) : ?>
				<tr>
					<td><?= $item['user_id'] ?></td>
					<td><?= $item['login'] ?>|<?= $item['name'] ?>
						<br />
						<small><?= $item['email'] ?></small>
					</td>
					<td>
						<?php if ($roles) : ?>
						<form method="POST">
							<input type="hidden" name="role_id_u" value="<?= $item['user_id'] ?>" />
							<select name="role_u">
								<?php foreach ($roles as $val ) : ?>
									<?php if ( $val['id'] == $item['id_role'] ) :?>
										<option selected value="<?= $val['id'] ?>"><?= $val['name'] ?></option>
									<?php else : ?>
										<option value="<?= $val['id']; ?>"><?= $val['name'] ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
							<input type="submit" name="edit_roles" value="Ok">	
						</form>
						<?php else : ?>
							<?= $item['email'] ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if ( $item['confirm'] ) :?>
							<p style="color: green">Active</p>
						<?php else : ?>
							<form method="POST">
								<input type="checkbox" name="confirm_u" value="<?= $item['user_id']; ?>" />
								<input type="submit" name="confirm_user" value="Ok">
							</form>
						<?php endif; ?>
					</td>
					<td>
						<input type="checkbox" name="delete_u[]" value="<?= $item['user_id']; ?>">		
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<input type="submit" name="delete_user" value="Delete" />
	</form>
<?php endif; ?>

<?php if ($navigation) : ?>
    <ul class="pager">

        <?php if ( $navigation['first'] ) : ?>
            <li class="first">
                <a href="?page=1">Первая</a>
            </li>
        <?php endif; ?>

        <?php if ( $navigation['last_page'] ) : ?>
            <li>
                <a href="?page=<?= $navigation['last_page']; ?>">&lt;</a>
            </li>
        <?php endif; ?>

        <?php if ($navigation['previous']) : ?>
            <?php foreach ($navigation['previous'] as $val) : ?>
                <li>
                    <a href="?page=<?= $val; ?>"><?= $val; ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ( $navigation['current'] ) : ?>
            <li>
                <span><?= $navigation['current']; ?></span>
            </li>
        <?php endif; ?>

        <?php if ( $navigation['next'] ) : ?>
            <?php foreach ( $navigation['next'] as $v ) : ?>
                <li>
                    <a href="?page=<?= $v; ?>"><?= $v; ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ( $navigation['next_pages'] ) : ?>
            <li>
                <a href="?page=<?= $navigation['next_pages']; ?>">&gt;</a>
            </li>
        <?php endif; ?>

        <?php if ( $navigation['end'] ) : ?>
            <li class="last">
                <a href="?page=<?= $navigation['end']; ?>">Последняя</a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>