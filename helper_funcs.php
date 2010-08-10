<?php
function validate_csrf() {
    global $_SESSION, $_POST; // Slight hack, but prevents having to mess with var names.
    if($_SESSION['csrf_token'] == $_POST['csrf_token']) return true;
    $_SESSION['err'] = 'CSRF Token did not validate. Please try again.';
    header("Location: ./global.php");
}