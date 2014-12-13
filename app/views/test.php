<h4><?php echo $nombre ?></h4>
<hr>
<p>
	<i> Con <?php echo $edad ?> años
		<?php if($edad >= 50): ?>
			eres un vejestorio :v</i>
		<?php elseif($edad >= 18): ?>
			no eres tan viejo :B</i>
		<?php else: ?>
			aún eres joven :3</i>
		<?php endif ?>
</p>