<div class="sheet">
	<h3>Error de ejecución</h3>
	<p><?php echo $log['description'], ' ' , $log['exception'] ?></p>
	<p><?php echo $logged ?></p>
	<p>Ejecuta el siguiente comando en la <b>consola de bitphp</b> para ver detalles del error:</p>
	<p><span class="inline-comment">~$ php dummy error <?php echo $log['id'] ?> </span></p>
</div>