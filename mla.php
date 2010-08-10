<?php
session_start();
require_once './helper_funcs.php';
validate_csrf();
?>

<b>session: <?php echo $_SESSION['csrf_token']; ?></b>
<pre>
<?php print_r($_POST); ?>
</pre>

<?php
if(is_valid_url($_POST['website'])) {
    $title = fetch_url_title($_POST['website']);
    if(!$title) $title = "&lt;title&gt; tag could not be found.";
} else {
    $title = "&lt;INVALID url given.&gt;";
}
?>
<b><?php echo $title; ?></b>