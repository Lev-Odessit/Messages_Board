		<footer>
			<div class="container_12">
				<ul class="navigation_links">
					<li>
						<a href="<?=SITE_NAME;?>">Главная</a>
					</li><!--
					--><li>
						<a href="?action=p_mess">Ваши объявления</a>
					</li><!--
					<? if($razd && is_array($razd)) :?>
						<? foreach($razd as $item) :?>
					 --><li>
						<a href="?action=<?= $m_action; ?>&amp;id_r=<?= $item['id']; ?>&id_cat=<?= $id_cat; ?>"><?= $item['name']; ?></a>
					</li><!--
						<? endforeach;?>
					<? endif;?>
					-->
				</ul>
				<ul class="social_links">
					<li>
						<a href="#">F</a>
					</li>
					<li>
						<a href="#">V</a>
					</li>
					<li>
						<a href="#">T</a>
					</li>
					<li>
						<a href="#">L</a>
					</li>
					<li>
						<a href="#">G</a>
					</li>
				</ul>
				<div class="clear"></div>
				<div class="all_rights">Доска объявлений 2016. All rights reserved.</div>
			</div>
		</footer>
        <script src="<?=TEMPLATE;?>scripts/lightbox.js"></script>
</body>
</html>