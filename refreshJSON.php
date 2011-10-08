<?php

error_reporting(0);

$distant_file = "http://resultats.lesprimairescitoyennes.fr:184/json/";
$file = "results.json";
$expire = 60 * 10;
$json = '';

echo $_GET['callback'] . '( {';

if (filemtime($file) < (time() - $expire)) {
    $json = file_get_contents($distant_file);

    if ($json != '') {
        $fh = fopen($file, 'w');
        fwrite($fh, $json);
        fclose($fh);

        echo "'msg': 'JSON successfully refreshed.'";

    } else {
        echo "'msg': 'Problem reading JSON.'";
    }
} else {
    echo "'msg': 'JSON not refreshed.'";
}
echo '});';
?>