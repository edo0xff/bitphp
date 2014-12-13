    <!-- jQuery and bootstrap -->
    <?php $path = \BitPHP\Config::BASE_PATH ?>
    <script src="<?php echo $path ?>app/js/bootstrap.min.js"></script>
    <!--BACKSTRETCH-->
    <script src="<?php echo $path ?>app/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("<?php echo $path ?>app/resources/images/default-01.jpg",{speed: 1000});
    </script>
    <!--Prims js, for code highlight-->
    <script src="<?php echo $path ?>app/js/prism.min.js"></script>
  </body>
</html>