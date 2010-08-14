<?php

require_once './helper_funcs.php';

function parse_post_data($post_data) {
    // This returns an array containing two arrays. One for line one, one for line two.
    $indent = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    switch($post_data['type']) {
        case 'book':
            // Author. _Title of Book_. City of Publication: Publisher, Year.
            return parse_names($post_data['author_first_name'], $post_data['author_last_name']).'. '
                . '<u>'.$post_data['title'].'</u>. '.$post_data['city'].': '.$post_data['publisher'].', '
                . $post_data['year'].'.';
        case 'essay':
            // Author of Story. "Title of Story." _Title of Book_. Name of Editor. Edition (if given). 
            //     City of Publication: Publisher, Year. Page numbers.
            return parse_names($post_data['author_first_name'], $post_data['author_last_name']).'. '
                . '"'.$post_data['title'].'." <u>'.$post_data['book'].'</u>. '.$post_data['editor']
                . '.<br />'.$indent.$post_data['city'].': '.$post_data['publisher']
                . ', '.$post_data['year'].'. '.$post_data['pages'].'.';
        case 'ref':
            // Author of Article (if given). "Article Title." _Title of Book_. City of Publication: 
            //     Publisher, Year.
            return parse_names($post_data['author_first_name'], $post_data['author_last_name']).'. '
                . '"'.$post_data['title'].'." <u>'.$post_data['title'].'</u>. '.$post_data['city']
                . ':<br />'.$indent.$post_data['publisher'].', '.$post_data['year'].'.';
        case 'magazine':
            // Author. "Title of Article." _Title of Magazine_ Date: Page(s).
            return parse_names($post_data['author_first_name'], $post_data['author_last_name']).'. '
                . '"'.$post_data['title'].'." <u>'.$post_data['magtitle'].'</u>. '.$post_data['date']
                . ': '.$post_data['pages'].'.';
        case 'article':
            // Author. "Title of Article." _Name of Newspaper_ Date, edition: Page(s).
            return parse_names($post_data['author_first_name'], $post_data['author_last_name']).'. '
                . '"'.$post_data['title'].'." <u>'.$post_data['newstitle'].'</u>. '.$post_data['date']
                . ', '.$post_data['edition'].': '.$post_data['pages'].'.';
        case 'web':
            // _Title of the Site_. Editor. Date and/or Version Number. Name of Sponsoring Institution. 
            //     Date of Access <URL>.
            return '<u>'.fetch_url_title($post_data['ur']).'</u>. '.$post_data['editor'].'. '
                . $post_data['date_written'].'. '.$post_data['sponsor'].'.<br />'.$indent
                . $post_data['date_access'].' <'.$post_data['url'].'>.';
        case 'tv':
            // "Title of Episode or Segment."  _Title of Program or Series_. Credit (Performer, writer, 
            //     etc). Name of Network. Call Letters (if any), City of Local Station (if any). 
            //     Broadcast Date.
        case 'interview':
            // Person Interviewed. Type of Interview (personal, telephone, email, etc.). Date.
    }
}

function generate_form($type) {
    // This generates the form.. or an easy array to iterate through
    // to get the form, at least.
    $defclass = 'input single';
    switch($type) {
        case 'book':
            // Author. _Title of Book_. City of Publication: Publisher, Year.
            return array(
                'Book Title' => array('class' => $defclass, 'name' => 'title'),
                'City of Pub.' => array('class' => $defclass, 'name' => 'city'),
                'Publisher' => array('class' => $defclass, 'name' => 'publisher'),
                'Year of Pub.' => array('class' => $defclass, 'name' => 'year'),
            );
        case 'essay':
            // Author of Story. "Title of Story." _Title of Book_. Name of Editor. Edition (if given). 
            //     City of Publication: Publisher, Year. Page numbers.
            return array(
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
            return array(
                'Title of Article' => array('class' => $defclass, 'name' => 'title'),
                'Title of Book' => array('class' => $defclass, 'name' => 'book'),
                'City of Pub.' => array('class' => $defclass, 'name' => 'city'),
                'Publisher' => array('class' => $defclass, 'name' => 'publisher'),
                'Year' => array('class' => $defclass, 'name' => 'year'),
            );
        case 'magazine':
            // Author. "Title of Article." _Title of Magazine_ Date: Page(s).
            return array(
                'Title of Article' => array('class' => $defclass, 'name' => 'title'),
                'Title of Magazine' => array('class' => $defclass, 'name' => 'magtitle'),
                'Date' => array('class' => $defclass, 'name' => 'date'), // TODO: Make this pretty/not a string.
                'Page(s)' => array('class' => $defclass, 'name' => 'pages'),
            );
        case 'article':
            // Author. "Title of Article." _Name of Newspaper_ Date, edition: Page(s).
            return array(
                'Title of Article' => array('class' => $defclass, 'name' => 'title'),
                'Title of Newspaper' => array('class' => $defclass, 'name' => 'newstitle'),
                'Date' => array('class' => $defclass, 'name' => 'date'), // TODO: Make this pretty/not a string.
                'Edition' => array('class' => $defclass, 'name' => 'edition'),
                'Page(s)' => array('class' => $defclass, 'name' => 'pages'),
            );
        case 'web':
            // _Title of the Site_. Editor. Date and/or Version Number. Name of Sponsoring Institution. 
            //     Date of Access <URL>.
            return array(
                'URL of Site' => array('class' => $defclass, 'name' => 'url'),
                'Editor' => array('class' => $defclass, 'name' => 'editor'),
                'Date Written' => array('class' => $defclass, 'name' => 'date_written'),
                'Sponsor' => array('class' => $defclass, 'name' => 'sponsor'),
                'Date of Access' => array('class' => $defclass, 'name' => 'date_access'),
            );
        case 'tv':
            // "Title of Episode or Segment."  _Title of Program or Series_. Credit (Performer, writer, 
            //     etc). Name of Network. Call Letters (if any), City of Local Station (if any). 
            //     Broadcast Date.
            return array(
                'Title of Episode' => array('class' => $defclass, 'name' => 'episode'),
                'Title of Program/Series' => array('class' => $defclass, 'name' => 'program'),
                'Credit' => array('class' => $defclass, 'name' => 'credit'),
                'Name of Network' => array('class' => $defclass, 'name' => 'network'),
                'Call Letters' => array('class' => $defclass, 'name' => 'call'),
                'Broadcast Date' => array('class' => $defclass, 'name' => 'date'),
            );
        case 'interview':
            // Person Interviewed. Type of Interview (personal, telephone, email, etc.). Date.
            return array(
                'Person Interviewed' => array('class' => $defclass, 'name' => 'person'),
                'Type of Interview' => array('class' => $defclass, 'name' => 'type'),
                'Date' => array('class' => $defclass, 'name' => 'date'),
            );
    }
}