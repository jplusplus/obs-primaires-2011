<?php

    // desactive les erreurs    
    ini_set('display_errors', 0);
    ini_set('log_errors', 0);
    error_reporting(null);

    $distant_file = "http://resultats.lesprimairescitoyennes.fr:184/json/2/";
    //$distant_file = "./results_dummy.json";

    $file = "results.json";
    $expire = 60 * 10;
    $json = '';

    if (! file_exists($file) || filemtime($file) < (time() - $expire) ) {

        $ctx = stream_context_create(array(
            'http' => array(
                'timeout' => 3
                )
            )
        );        

        $json = file_get_contents($distant_file, 0, $ctx);

        if ($json != '') {

            // enregistre le json
            file_put_contents($file, $json);

            echo 'Fichier importé'."\n";

        } else {
            echo 'Les résultats ne sont pas encore disponibles...'."\n";
        }

    } else {
        echo 'Le PS n\'a pas encore mis &agrave; jour les r&eacute;sultats.'."\n";
    }
?>