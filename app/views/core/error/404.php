<p>
  <h4>404 - page not found D:</h4>
  <i>You can contact the <a href="mailto:<?php echo \BitPHP\Config::ADMIN_EMAIL ?>">administrator</a> to report this error.</i>
</p>
<?php if(\BitPHP\Config::CRYPTED_ISSUES_REPORT):
	$sc  = \BitPHP\Load::library('SpiderCrypt');
	$msg = "\nDescription: $d \n\nException: $e \n\nTrace: ".JSON_ENCODE($trace, JSON_PRETTY_PRINT);
	$msg = $sc->sCrypt($msg, \BitPHP\Config::CRYPT_KEY); ?>
	<hr>
	<pre><b>Error message:</b><?php echo substr($msg,0,140), '[...]' ?></pre>
	<button type="button" class="btn btn-link pull-right" id="send">Send error report</button>
	<script>
	  //err_msg to error_report/index
	  $("#send").click(function(){
	    $.post(
	      "http://<?php echo $_SERVER['SERVER_NAME'], \BitPHP\Config::BASE_PATH ?>error_report",
	      {err_msg: "<?php echo $msg ?>"},
	      function(r) { $("#send").html(r); $("#send").unbind("click"); }
	    );
	  });
	</script>
<?php endif; ?>