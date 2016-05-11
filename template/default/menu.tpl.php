<nav>
	<? if($razd && is_array($razd)) :?>
		<? foreach($razd as $item) :?>
			<a href="?action=<?= $m_action; ?>&amp;id_r=<?= $item['id']; ?>&id_cat=<?= $id_cat; ?>"><?= $item['name']; ?></a>
		<? endforeach;?>
	<? endif;?>
	<? if($user) :?>
		<?if($add_mess):?>
			<a href="?action=add_mess">Добавить объявление</a>
		<? endif;?>
		<a href="?action=p_mess">Ваши объявления</a>
	<? endif;?>
</nav>
<div class="clearfix"></div>