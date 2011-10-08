<?php

error_reporting(0);

$distant_file = "http://resultats.lesprimairescitoyennes.fr:184/json/";
$file = "results.json";
$expire = 60 * 10;
$json = '';

echo $_GET['callback'] . '( {';

if (filemtime($file) < (time() - $expire)) {
    $ctx = stream_context_create(array(
    'http' => array(
        'timeout' => 3
        )
    )
);
    $json = file_get_contents($distant_file, 0, $ctx);

    if ($json != '') {
        $fh = fopen($file, 'w');
        fwrite($fh, $json);
        fclose($fh);

        echo "'msg': 'OK'";

    } else {
        echo "'msg': 'Le fichier contenant les derniers r&eacute;sultats n\'a pas &eacute;t&eacute; re&ccedil;u (err:timeout).'";
    }
} else {
    echo "'msg': 'Le PS n\'a pas encore mis &agrave; jour les r&eacute;sultats.'";
}
echo '});';
?>