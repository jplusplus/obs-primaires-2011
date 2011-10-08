<?php
    echo $_GET['callback'] . '(';

    $json = file_get_contents('results.json');
    echo $json;

    echo ');';
?>