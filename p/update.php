<?php

    // Set header for JSON output
    header('Content-Type: application/json');
    
    // Connect to REDIS
    require '../predis/Autoloader.php';
    Predis\Autoloader::register();
    $client = new Predis\Client();

    // Get POST data
    $data = $_POST['data'];
    $id = $_POST['id'];
    $token = $_POST['token'];
    
    // 	check redis for token validity
    $serverToken = $client->get("session_$id");
    if ($token == $serverToken) {
        
        // 	save to file ../v/$id.svg
        //file_put_contents($data, "../v/$id.svg");
        $f = "../v/$id.svg";
    	$fh = fopen($f, "w") or die("Can't open file");
    	fwrite($fh, $data);
    	fclose($fh);
        
        // 	update expire time
        $client->expire("session_$id", 18000); 
        
    }

?>