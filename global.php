<?php
session_start();
// Users should only be here if there's an error.
if(!$_SESSION['err']) header("Location: /");

// TODO: Make this pretty.
?>
<b><?php echo $_SESSION['err']; ?></b>

<?php session_destroy(); ?>