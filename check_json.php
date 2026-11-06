<?php

$content = file_get_contents('test_profil.html');
$pos = strpos($content, 'window.PROFIL_DEWAN_DATA =');
if ($pos !== false) {
    echo substr($content, $pos, 1000);
}
