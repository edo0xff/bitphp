<hr>
<h4><?php echo $nombre ?></h4>
<p>
	<i> Con <?php echo $edad ?> años
		<?php if($edad >= 50): ?>
			eres un vejestorio :v
		<?php elseif($edad >= 18): ?>
			no eres tan viejo :B
		<?php else: ?>
			aún eres joven :3
		<?php endif ?>
	</i>
</p>
<p>
	<ul>
		<?php foreach($frutas as $fruta): ?>
				<li><?php echo $fruta ?></li>
		<?php endforeach; ?>
	</ul>
</p>