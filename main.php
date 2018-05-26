<?php
$fileErrors ++;

function syntaxCheck ($src = ".")
{
    global $fileErrors;
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if (($file != '.') && ($file != '..') && (preg_match('[*.php]', $file))) {
            if (is_dir($src . '/' . $file)) {
                checkFiles($src . '/' . $file);
            } else {
                $result = exec("php -l " . $src . '/' . $file);
                if (strchr($result, "Errors parsing")) {
                    $fileErrors ++;
                    echo "[Error] Parsing error.\n";
                }
                echo $result . "\n";
            }
        }
    }
    closedir($dir);
}