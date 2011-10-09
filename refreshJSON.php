<?php

    // desactive les erreurs    
    ini_set('display_errors', 0);
    ini_set('log_errors', 0);
    error_reporting(null);

    $file = "results.json";
    $expire = 60 * 10;
    $json = '';

    echo $_GET['callback'] . '( {';

    if( filemtime($file) < (time() - $expire) ) {
        echo "'msg': 'OK'";
    } else {
        echo "'msg': 'Le PS n\'a pas encore mis &agrave; jour les r&eacute;sultats.'";
    }

    echo '});';
?>