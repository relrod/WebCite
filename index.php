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
            padding: 10px;
        }
        #container input {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        #container input.input {
            height: 30px;
            width: 170px;
            font-size: 1.4em;
            font-family: Calibri, 'Helvetica Nueue', Helvetica, 'Lucida Grande', Arial, sans-serif;
        }
        #container input.single {
            width: 530px;
        }
        #container input.default {
            color: #aaa;
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
        
        function formonclick(obj, value, newcolor) {
            if (obj.value == value) {
                obj.value='';
                if(newcolor == undefined) {
                    obj.style.color='#444444';
                } else {
                    obj.style.color=newcolor;
                }
            }
        }

        function formonblur(obj, value, newcolor) {
            if(obj.value == '') {
                obj.value=value;
                if(newcolor == undefined) {
                    obj.style.color='#aaaaaa';
                } else {
                    obj.style.color=newcolor;
                }
            }
        }
        
        </script>
    </head>
    <body>
        <h4>Fill in relevant pieces of information</h4>
        <div id="container">
            <form action='mla.php' method='post'>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                <table id="mlaform" id="mlaform">
                    <tr class="borderbottom">
                        <td>Source: Website</td>
                        <td><input type="text" class="input single" name="website" /></td>
                    </tr>
                    <tr><td><a href="javascript:addAuthor();">Add Author</a></tr></td>
                    <tr>
                        <td>Author: Name</td>
                        <td>
                            <input type="text" class="input default" name="author_first_name[]" value="First" onfocus="formonclick(this, 'First');" onblur="formonblur(this, 'First');"/>
                            <input type="text" class="input default" name="author_middle_initial[]" value="M.I." size="2" onfocus="formonclick(this, 'M.I.');" onblur="formonblur(this, 'M.I.');" />
                            <input type="text" class="input default" name="author_last_name[]" value="Last" onfocus="formonclick(this, 'Last');" onblur="formonblur(this, 'Last');" />
                        </td>
                    </tr>

                </table>
                
                <input type="submit" value="Generate MLA!" class="submit" />
            </form>
        </div>
    </body>
</html>