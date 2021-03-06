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

function english_list($array) {
    // Converts array('foo','bar','baz') to 'foo, bar, and baz'
    $last_element = array_pop($array);
    if(count($array) == 0) return $last_element;
    return implode($array, ', ').", and $last_element";
}

function parse_names($array_fn, $array_ln) {
    // Takes two arrays and combines them into a string, provided by english_list().
    $count_fn = count($array_fn);
    $names = array();
    if($count_fn != count($array_ln)) return false;
    $names[] = array_shift($array_ln).", ".array_shift($array_fn);
    $count_fn--;
    for($i = 0; $i < $count_fn; $i++) {
        $names[] = $array_fn[$i]." ".$array_ln[$i];
    }
    return english_list($names);
}
