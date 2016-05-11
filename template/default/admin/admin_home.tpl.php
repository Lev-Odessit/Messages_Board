<h3 class="title">Не подтверждённые объявления</h3>
<? if($_SESSION['msg']) : ?>
    <?= $_SESSION['msg']; ?>
    <?php unset($_SESSION['msg']);?>
<? endif; ?>

<? if (is_array($text)) : ?>
<form method="POST">
    <table cellspacing="0" class="moder_mess">
        <thead>
            <th>id</th>
            <th>title</th>
            <th>User</th>
            <th>Action</th>
        </thead>
            <? foreach($text as $item) : ?>
                <tr>
                    <td>
                        <?=  $item['id']; ?>
                    </td>
                    <td>
                        <?=  $item['title']; ?><br/>
                        <small><?=  $item['cat']; ?></small>
                        <small><?=  $item['razd']; ?></small>
                    </td>
                    <td>
                        <?=  $item['user']; ?><br/>
                        <?=  $item['email']; ?>
                    </td>

                    <td>
                        <input type="checkbox" name="id_mess[]" value="<?=  $item['id']; ?>"/>
                    </td>
                </tr>
            <? endforeach; ?>
    </table>
    <input type="submit" value="Ok"/>
</form>
<?php else : ?>
    <p>Не подтверждённых объявлений нет</p>
<? endif; ?>
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

