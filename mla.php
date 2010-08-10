<?php session_start(); ?>
<b>session: <?php echo $_SESSION['csrf_token']; ?></b>
<pre>
<?php print_r($_POST); ?>
</pre>