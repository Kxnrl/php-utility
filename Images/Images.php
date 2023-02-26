<?php

declare(strict_types=1);
ini_set('memory_limit', '384M');

// Taken from https://github.com/Kxnrl/N0vaDesktop-Extractor/blob/master/N0vaDesktopExtractor/Program.cs#L135
function getJpgInfo($path) : ?array {
    $size = filesize($path);
    if ($size === false || $size >= 300 * 1024) {
        return [
            'height' => -1,
            'width' => -1
        ];
    }
    $file = fopen($path, 'rb');
    $resp = fread($file, $size);
    $pack = unpack("C*", $resp);
    $data = [];
    foreach ($pack as $byte) {
        $data[] = $byte;
    }
    unset($pack);
    fclose($file);

    $off = 0;
    while ($off < count($data))
    {
        while ($data[$off] == 0xff)
        {
            $off++;
        }

        $cdpr = $data[$off++];

        if ($cdpr == 0xd8) continue;
        if ($cdpr == 0xd9) break;
        if (0xd0 <= $cdpr && $cdpr <= 0xd7) continue;
        if ($cdpr == 0x01) continue;

        $len = ($data[$off] << 8) | $data[$off + 1];
        $off += 2;

        if ($cdpr == 0xc0)
        {
            $result = [
                'height' => ($data[$off + 1] << 8) | $data[$off + 2],
                'width' => ($data[$off + 3] << 8) | $data[$off + 4]
            ];
            unset($data);
            return $result;
        }
        $off += $len - 2;
    }

    unset($data);
    return [
        'height' => 0,
        'width' => 0
    ];
}

// Taken from https://github.com/Kxnrl/N0vaDesktop-Extractor/blob/master/N0vaDesktopExtractor/Program.cs#L127
function getPngInfo($path) : ?array {
    $size = filesize($path);
    if ($size === false || $size >= 500 * 1024) {
        return [
            'height' => -1,
            'width' => -1
        ];
    }
    $file = fopen($path, 'rb');
    $resp = fread($file, $size);
    $pack = unpack("C*", $resp);
    $data = [];
    foreach ($pack as $byte) {
        $data[] = $byte;
    }
    unset($pack);
    fclose($file);

    $result = [
        'height' => ($data[20] << 24) + ($data[21] << 16) + ($data[22] << 8) + ($data[23] << 0),
        'width' => ($data[16] << 24) + ($data[17] << 16) + ($data[18] << 8) + ($data[19] << 0)
    ];
    unset($data);
    return $result;
}

function checkFile($path) : ?string {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext == 'jpg')
        $resx = getJpgInfo($path);
    elseif ($ext == 'png')
        $resx = getPngInfo($path);
    else
        $resx = null;

    if ($resx == null)
        return "Failed to parse image";

    if ($resx['width'] == 1920 && $resx['height'] == 1080)
        return null;

    if ($resx['width'] == 1280 && $resx['height'] == 720)
        return null;

    return "Invalid resolution ({$resx['width']} * {$resx['height']})";
}

$listFile = new SplFileObject(__DIR__ . '/.fys/ci/Images.list');
$DirsList = [];
$FileList = [];
$validated = 0;
$errorReports = [];

while (!$listFile->eof()) {
    $path = trim($listFile->fgets());
    $DirsList[] = $path;
}

foreach ($DirsList as $dir) {

    foreach (scandir($dir) as $file) {

        if ($file == '.' || $file == '..' || strncmp($file, '_', 1) == 0) {
            continue;
        }

        $_path = $dir . '/' . $file;
        $FileList[] = $_path;

        $info = pathinfo($_path, PATHINFO_BASENAME);

        if (preg_match('/[A-Z]/', $info)) {
            $errorReports[] = [
                'file' => $_path,
                'errs' => 'uppercase file name of \''.$_path.'\''
            ];
        }
    }
}

foreach ($FileList as $file) {

    $resp = checkFile($file);
    if ($resp !== null) {
        $errorReports[] = [
            'file' => $file,
            'errs' => $resp,
        ];
    }
    $validated++;
}

if (count($errorReports) > 0) {
    foreach($errorReports as $error) {
        print_r('Reported File '. $error['file'] . ' with error: ' . $error['errs'] . PHP_EOL);
    }
    exit(1);
}

print_r("Validated $validated / " . count($FileList) . " Images." . PHP_EOL);
exit(0);