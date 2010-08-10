<?php
session_start();
require_once './helper_funcs.php';
validate_csrf();
?>

<b>session: <?php echo $_SESSION['csrf_token']; ?></b>
<pre>
<?php print_r($_POST); ?>
</pre>