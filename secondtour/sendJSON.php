<?php
    // desactive les erreurs    
    ini_set('display_errors', 0);
    ini_set('log_errors', 0);
    error_reporting(null); 

    echo $_GET['callback'] . '(';
   		echo file_get_contents('results.json');    
    echo ');';
?>