<?php
// Plug CSRF Security Hole
session_start();
require_once './helper_funcs.php';
$_SESSION['csrf_token'] = sha1(uniqid(rand()));
$type = $_GET['type'];
$possible_types = mla_types();

if(!array_key_exists($type, $possible_types)) {
    header("Location: ./global.php");
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>WebCite: An online MLA formatter</title>
        <link href="./media/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="./media/main_funcs.js"></script>
    </head>
    <body>
        <h4>Fill in relevant pieces of information</h4>
        <div id="container">
            <form action='mla.php' method='post'>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                <table id="mlaform" id="mlaform">
                    <tr>
                        <td>Source: Website</td>
                        <td><input type="text" class="input single" name="website" /></td>
                    </tr>
                    <tr>
                        <td>Source: Magazine Name</td>
                        <td><input type="text" class="input single" name="magazine" /></td>
                    </tr>
                    <tr>
                        <td>Source: Magazine Pages</td>
                        <td><input type="text" class="input single" name="magazine_pages" /></td>
                    </tr>
                    <tr><td><a href="javascript:addAuthor();">Add Author</a></tr></td>
                    <tr class="borderbottom">
                        <td>Author: Name</td>
                        <td><!-- Yes, yes. It's all one line. Because we don't want spaces. Until I get spaces working in JS -->
                            <input type="text" class="input default" name="author_first_name[]" value="First" onfocus="formonclick(this, 'First');" onblur="formonblur(this, 'First');"/><input type="text" class="input default" name="author_middle_initial[]" value="M.I." onfocus="formonclick(this, 'M.I.');" onblur="formonblur(this, 'M.I.');" /><input type="text" class="input default" name="author_last_name[]" value="Last" onfocus="formonclick(this, 'Last');" onblur="formonblur(this, 'Last');" />
                        </td>
                    </tr>

                </table>
                
                <input type="submit" value="Generate MLA!" class="submit" />
            </form>
        </div>
    </body>
</html>