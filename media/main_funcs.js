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