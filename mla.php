<?php
session_start();
require_once './form_funcs.php';
validate_csrf();
?>

<b>session: <?php echo $_SESSION['csrf_token']; ?></b>
<pre>
<?php print_r($_POST); ?>
</pre>

<?php
if($_POST['website'] != '') {
    if(is_valid_url($_POST['website'])) {
        $title = fetch_url_title($_POST['website']);
        if(!$title) $title = "&lt;title&gt; tag could not be found.";
    } else {
        $title = "INVALID URL given.";
    }
} else {
    // They didn't pass us a website, it must be something else.
    // I'm beginning to think a ?type=website, ?type=book, etc would be easier.
    $title = "&lt;not website&gt;";
}
?>
<b><?php echo $title; ?></b>

<hr />
<?php echo parse_post_data($_POST); ?>
<hr />