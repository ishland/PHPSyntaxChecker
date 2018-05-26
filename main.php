<?php
$fileErrors = 0;

function syntaxCheck ($src = ".")
{
    global $fileErrors;
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if (($file != '.') && ($file != '..')) {
            $name = explode(".", $file);
            if (is_dir($src . '/' . $file)) {
                syntaxCheck($src . '/' . $file);
            } else {
                if (end($name) !== "php")
                    continue;
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

syntaxCheck();
echo "\n{$fileErrors} syntax error(s).\n";
