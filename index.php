<?php
// Plug CSRF Security Hole
session_start();
$_SESSION['csrf_token'] = sha1(uniqid(rand()));
?>
<!doctype html>
<html lang="en">
    <head>
        <title>WebCite: An online MLA formatter</title>
        <style>
        * {
            margin: 0;
            padding: 0;
        }
        html {
            font-family: Calibri, 'Helvetica Nueue', Helvetica, 'Lucida Grande', Arial, sans-serif;
            text-align: center; /* IE6 */
        }
        body {
            background-color: #f7f7f7;
        }
        #container {
            text-align: left;
            width: 700px;
            border: 1px solid #aaa;
            margin: 25px auto;
        }
        #container input.submit {
            font-size: 2em;
            background-color: #ddd;
            text-align: center;
            width: 100%;
        }
        #container table {
            border-collapse: collapse;
            width: 100%;
        }
        #container table tr.borderbottom {
            border-bottom: 2px solid #aaa;
        }
        </style>
        <script>          
        function addAuthor() {
            var table = document.getElementById('mlaform');
            
            // This is so we can style the addition as a whole.
            var bottomborder = document.createElement('hr');
            bottomborder.setAttribute('style', 'clear: both');
            
            var authorform = new Array()
            authorform['author_first_name'] = "Author: First Name";
            authorform['author_middle_initial'] = "Author: Middle Initial"
            authorform['author_last_name'] = "Author: Last Name";
            for(key in authorform) { // Better than repeating this 3 times.
                var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.appendChild(document.createTextNode(authorform[key]));
                tr.appendChild(td);
                
                var td = document.createElement('td'); // Re-initialize this.
                var ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('class', 'input');
                ele.setAttribute('name', key+'[]');
                td.appendChild(ele);
                tr.appendChild(td);
                
                if(key == 'author_last_name') tr.setAttribute('class', 'borderbottom');
                
                
                table.appendChild(tr);

            }
        }
        </script>
    </head>
    <body>
        <div id="container">
            <form action='mla.php' method='post'>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                <table id="mlaform" id="mlaform">
                    <a href="javascript:addAuthor();">Add Author</a>
                    
                    <tr>
                        <td>Author: First Name</td>
                        <td><input type="text" class="input" name="author_first_name[]" /></td>
                    </tr>
                    <tr>
                        <td>Author: Middle Initial</td>
                        <td><input type="text" class="input" name="author_middle_initial[]" /></td>
                    </tr>
                    <tr class="borderbottom">
                        <td>Author: Last Name</td>
                        <td><input type="text" class="input" name="author_last_name[]" /></td>
                    </tr>
                </table>
                
                <input type="submit" value="Generate MLA!" class="submit" />
            </form>
        </div>
    </body>
</html>