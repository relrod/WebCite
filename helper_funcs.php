<?php
function validate_csrf() {
    global $_SESSION, $_POST; // Slight hack, but prevents having to mess with var names.
    if($_SESSION['csrf_token'] == $_POST['csrf_token']) return true;
    $_SESSION['err'] = 'CSRF Token did not validate. Please try again.';
    header("Location: ./global.php");
}

function is_valid_url($url) {
    if(!filter_var($url, FILTER_VALIDATE_URL)) return false;
    return true;
}

function fetch_url_title($url) {
    $page = @file_get_contents($url, false, null, -1, 5000); // Hope it's not >5000 chars into the page.
    preg_match('#<title>(.*)</title>#i', $page, $title);
    if(count($title) == 0) return false;
    return $title[1];
}

function mla_types() {
    // Returns an array of types we accept
    return array(
        'book' => 'Book',
        'essay' => 'Essay',
        'ref' => 'Reference (Encyclopedia)',
        'magazine' => 'Magazine',
        'article' => 'Article (newspaper or other)',
        'library' => 'Library Database',
        'web' => 'Website',
        'interview' => 'First-person Interview',
        'tv' => 'Television',
        'video' => 'Other Video',
    );
}

function generate_form($type) {
    // This generates the form.. or an easy array to iterate through
    // to get the form, at least.
    $defclass = 'input single';
    switch($type) {
        case 'book':
            // Author. _Title of Book_. City of Publication: Publisher, Year.
            $form = array(
                'Book Title' => array('class' => $defclass, 'name' => 'title'),
                'City of Pub.' => array('class' => $defclass, 'name' => 'city'),
                'Publisher' => array('class' => $defclass, 'name' => 'publisher'),
                'Year of Pub.' => array('class' => $defclass, 'name' => 'year'),
            );
        case 'essay':
            // Author of Story. "Title of Story." _Title of Book_. Name of Editor. Edition (if given). 
            //     City of Publication: Publisher, Year. Page numbers.
            $form = array(
                'Title of Story' => array('class' => $defclass, 'name' => 'title'),
                'Title of Book' => array('class' => $defclass, 'name' => 'book'),
                'Editor' => array('class' => $defclass, 'name' => 'editor'),
                'Edition' => array('class' => $defclass, 'name' => 'edition'),
                'City of Pub.' => array('class' => $defclass, 'name' => 'city'),
                'Publisher' => array('class' => $defclass, 'name' => 'publisher'),
                'Year' => array('class' => $defclass, 'name' => 'year'),
                'Num. of Pages' => array('class' => $defclass, 'name' => 'pages'),
            );
        case 'ref':
            // Author of Article (if given). "Article Title." _Title of Book_. City of Publication: 
            //     Publisher, Year.
            'Title of Article' => array('class' => $defclass, 'name' => 'title'),
            'Title of Book' => array('class' => $defclass, 'name' => 'book'),
            'City of Pub.' => array('class' => $defclass, 'name' => 'city'),
            'Publisher' => array('class' => $defclass, 'name' => 'publisher'),
            'Year' => array('class' => $defclass, 'name' => 'year'),
        case 'magazine':
            // Author. "Title of Article." _Title of Magazine_ Date: Page(s).
            'Title of Article' => array('class' => $defclass, 'name' => 'title'),
            'Title of Magazine' => array('class' => $defclass, 'name' => 'magtitle'),
            'Date' => array('class' => $defclass, 'name' => 'date'), // TODO: Make this pretty/not a string.
            'Page(s)' => array('class' => $defclass, 'name' => 'pages'),
        case 'article':
            // Author. "Title of Article." _Name of Newspaper_ Date, edition: Page(s).
            'Title of Article' => array('class' => $defclass, 'name' => 'title'),
            'Title of Newspaper' => array('class' => $defclass, 'name' => 'newstitle'),
            'Date' => array('class' => $defclass, 'name' => 'date'), // TODO: Make this pretty/not a string.
            'Edition' => array('class' => $defclass, 'name' => 'edition'),
            'Page(s)' => array('class' => $defclass, 'name' => 'pages'),        
    }
    return $form;
}

// Used in global.php
function new_or_error($session, $newmsg, $errmsg) {
    if($session['new']) return $newmsg;
    if($session['err']) return $errmsg;
}

#header("Location: /");