<?php

    // Set header for JSON output
    header('Content-Type: application/json');
    
    // Connect to REDIS
    require '../predis/Autoloader.php';
    Predis\Autoloader::register();
    $client = new Predis\Client();
    
    // New UID is generated
    $id = uniqid();
    
    // Verify no UID collisions
    if ($client->sismember("pens", $id) == 0) {
        
        // Add pen_count & id to pen index
        $client->sadd("pens", $id);
        $client->incr("pen_count");
        
        // Generate token & save to Redis with expire (5 hours)
        $token = uniqid('lj32', true);
        $client->set("session_$id", $token);
        $client->expire("session_$id", 18000);
        
        // Return UID & Token (JSON, Duh)
        $a = array("id" => $id, "token" => $token);
        print_r(json_encode($a));
        
    }

?>