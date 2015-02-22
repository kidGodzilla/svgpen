<?php

    // Set header for JSON output
    header('Content-Type: application/json');

    // Get POST data
    $data = $_POST['data'];
    $template = $_POST['template'];
    
    $id = uniqid();

    // Get data
    $template = file_get_contents($template);
    
    // Get the header
    $head = explode('<body', $template);
    $head = $head[0];
    
    // Get the footer
    $foot = explode('</body>', $template);
    $foot = $foot[1];
    
    // Get the opening body tag
    $bTagEnding = explode('<body', $template);
    $bTagEnding = explode('>', $bTagEnding[1]);
    $bodyTag = '<body'.$bTagEnding[0].'>';
    
    // Write the file
    $f = "../h/$id.html";
    $fh = fopen($f, "w") or die("Can't open file");
    fwrite($fh, $head."\n".$bodyTag."\n".$data."\n".'</body>'."\n".$foot);
    fclose($fh);
    
    echo '{ url: "h/'.$id.'.html" }';

?>