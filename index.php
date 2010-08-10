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
        #container {
            background-color: #f7f7f7;
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
            border: 1px solid #aaa;
        }
        #container input.submit:hover {
            border: 1px solid red;
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
            var tr = document.createElement('tr');
            
            // Only one tr per author now.
            var td = document.createElement('td');
            td.appendChild(document.createTextNode("Author: Name"));
            tr.appendChild(td);
            
            var td = document.createElement('td'); // Re-initialize this, two td's per author
            
            // This is so we can style the addition as a whole.
            var bottomborder = document.createElement('hr');
            bottomborder.setAttribute('style', 'clear: both');
            
            var authorform = new Array()
            authorform['author_first_name'] = "First";
            authorform['author_middle_initial'] = "M.I.";
            authorform['author_last_name'] = "Last";
            for(key in authorform) { // Better than repeating this 3 times.
                var ele = document.createElement('input');
                ele.setAttribute('type', 'text');
                ele.setAttribute('class', 'input default');
                ele.setAttribute('name', key+'[]');
                ele.setAttribute('onfocus', "formonclick(this, '"+ authorform[key] + "');");
                ele.setAttribute('onblur', "formonblur(this, '"+ authorform[key] + "');");
                ele.setAttribute('value', authorform[key]);
                
                td.appendChild(ele);
                tr.appendChild(td);
                
                if(key == 'author_last_name') tr.setAttribute('class', 'borderbottom');
            }
            table.appendChild(tr);
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