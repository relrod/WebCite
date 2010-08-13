<?php
session_start();
require_once './helper_funcs.php';
// Users should only be here if there's an error, or they're new.
?>
<!doctype html>
<html lang="en">
    <head>
        <title>WebCite: An online MLA formatter</title>
        <link href="./media/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <h4><?php if($_SESSION['err']) { echo "An error has occured!"; } else { echo "Welcome to WebCite!"; } ?></h4>
        <div id="container">
            <?php
            if($_SESSION['err']) echo $_SESSION['err'];
            else {
                foreach(mla_types() as $type => $visualname) {
            ?>
            <a href='./index.php?type=<?php echo $type; ?>'><?php echo $visualname; ?></a><br />
            <?php
                }
            }
            ?>
        </div>
    </body>
</html>