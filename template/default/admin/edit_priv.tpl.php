<h3 class="title_page">Привелегии</h3>
<? if($_SESSION['msg']) : ?>
    <?= $_SESSION['msg']; ?>
    <?php unset($_SESSION['msg']);?>
<? endif; ?>
<form method="POST">
    <table cellspacing="0" class="moder_mess">
        <thead>
            <th>Привелегии</th>
            <?php if (is_array($roles)) : ?>
                <?php foreach($roles as $item) : ?>
                    <th><?=$item['name']?></th>
                <?php endforeach; ?>
            <?php endif; ?>
            <th></th>
        </thead>
        <?php if (is_array($priv)) : ?>
            <?php foreach($priv as $key => $val ) : ?>
                <tr>
                    <td><?= $key; ?></td>
                    <?php foreach($roles as $item) : ?>
                        <td>
                            <? if(array_key_exists($item['id'],$val)) : ?>
                                <input name="<?=$item['id']?>[]" type="checkbox" checked value="<?=$val['id_priv']?>">
                            <? else : ?>
                                <input name="<?=$item['id']?>[]" type="checkbox" value="<?=$val['id_priv']?>">
                            <? endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <input type="submit" value="Edit" />
</form>