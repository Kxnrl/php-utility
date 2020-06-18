<?php

declare(strict_types=1);

function errorHandler( int $errno , string $error) : bool {

    print_r("ERROR #" . $error . " -> " . $error . PHO_EOL);
    exit(1);
}

set_error_handler('errorHandler');

$listFile = new SplFileObject(__DIR__ . '/CI/KeyValues.list');
$DirsList = [];
$KeyValues = [];

while (!$listFile->eof()) {

    $path = trim($listFile->fgets());
    $ext = pathinfo(__DIR__ . 'KeyValues.php/' . $path, PATHINFO_EXTENSION);
    if ($ext == 'kv' || $ext == 'vdf') {
        // this is kv file
        $KeyValues[] = $path;
    } else {
        // otherwise directory
        $DirsList[] = $path;
    }
}

foreach ($DirsList as $dir) {

    foreach (scandir($dir) as $file) {

        $KeyValues[] = $file;
    }
}

require_once __DIR__ . '/vdf.php';

$validated = 0;
foreach ($KeyValues as $kv) {

    $array = vdf_decode(__DIR__ . 'KeyValues.php/' . $kv);
    if (!is_array($array)) {
        trigger_error("Failed to decode file [$kv] -> is_array (Array) return false.", E_USER_NOTICE);
    } else {
        $validated++;
    }
}

print_r("Validated $validated / " . count($KeyValues) . " KeyValue files." . PHP_EOL);
exit(0);