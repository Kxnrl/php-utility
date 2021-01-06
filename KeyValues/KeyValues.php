<?php

declare(strict_types=1);

function errorHandler(int $errno , string $error) : bool {

    print_r("ERROR #" . $errno . " -> " . $error . PHP_EOL);

    if ($errno != E_USER_NOTICE) {
        print_r(json_encode(debug_backtrace(), JSON_PRETTY_PRINT) . PHP_EOL);
    }

    exit(1);
}

function parseEntities(string $file, array $entities) : ?string {

    if (!is_array($entities)) {
        return "EntitiesParser: entities is not an array." . PHP_EOL . 'file: ' . $file;
    }

    global $fieldName;

    foreach ($entities as $section => $entity) {

        if (!is_array($entity)) {
            return "EntitiesParser: key '$section' is not an array." . PHP_EOL . 'file: ' . $file;
        }

        // foreach key
        $totalKeys = 0;
        // check requires
        foreach ($entity as $key => $val) {
            if (in_array($key, $fieldName['entities']['require'], true)) {
                $totalKeys++;
            }
        }
        if (count($fieldName['entities']['require']) != $totalKeys) {
            foreach ($fieldName['entities']['require'] as $key) {
                if (!isset($entity[$key])) {
                    return "EntitiesParser: missing filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
                }
            }
        }

        foreach ($entity as $key => $val) {
            if (!in_array($key, $fieldName['entities']['optional'], true) && !in_array($key, $fieldName['entities']['require'], true)) {
                return "EntitiesParser: redundant filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
            }
        }

        foreach ($entity as $key => $val) {
            if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $val)) {
                return "EntitiesParser: invalid symbol '$val' in '$section'." . PHP_EOL . 'file: ' . $file;
            }
        }

        if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $section)) {
            return "EntitiesParser: invalid symbol '$section' in '$section'." . PHP_EOL . 'file: ' . $file;
        }
    }

    return null;
}

function parseBossHp(string $file, array $BossHp) : ?string {

    if (!is_array($BossHp)) {
        return "BossHpParser: entities is not an array." . PHP_EOL . 'file: ' . $file;
    }

    global $fieldName;

    $uniqueBreakable = [];
    $uniqueCounter = [];

    if (isset($BossHp['breakable'])) {

        if (!is_array($BossHp['breakable'])) {
            return "BossHpParser: breakable is not an array." . PHP_EOL . 'file: ' . $file;
        }

        foreach ($BossHp['breakable'] as $section => $breakable) {

            if (!is_array($breakable)) {
                return "BossHpParser: key '$section' is not an array." . PHP_EOL . 'file: ' . $file;
            }

            // iterator unique
            if (in_array($breakable['targetname'], $uniqueBreakable, true)) {
                return "BossHpParser: key '$section' has duplicate targetname value '". $breakable['targetname'] ."'." . PHP_EOL . 'file: ' . $file;
            }
            $uniqueBreakable[] = $breakable['targetname'];

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($breakable as $key => $val) {
                if (in_array($key, $fieldName['BossHP']['optional']['breakable']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['BossHP']['optional']['breakable']['require']) != $totalKeys) {
                foreach ($fieldName['BossHP']['optional']['breakable']['require'] as $key) {
                    if (!isset($breakable[$key])) {
                        return "BossHpParser: missing filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
                    }
                }
            }
            foreach ($breakable as $key => $val) {
                if (!in_array($key, $fieldName['BossHP']['optional']['breakable']['optional'], true) && !in_array($key, $fieldName['BossHP']['optional']['breakable']['require'], true)) {
                    return "BossHpParser: redundant filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
                }
            }
            foreach ($breakable as $key => $val) {
                if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $val)) {
                    return "BossHpParser: invalid symbol '$val' in '$section'." . PHP_EOL . 'file: ' . $file;
                }
            }
            if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $section)) {
                return "BossHpParser: invalid symbol '$section' in '$section'." . PHP_EOL . 'file: ' . $file;
            }
        }
    }

    if (isset($BossHp['counter'])) {

        if (!is_array($BossHp['counter'])) {
            return "BossHpParser: breakable is not an array." . PHP_EOL . 'file: ' . $file;
        }

        foreach ($BossHp['counter'] as $section => $counter) {

            if (!is_array($counter)) {
                return "BossHpParser: key '$section' is not an array." . PHP_EOL . 'file: ' . $file;
            }

            // iterator unique
            if (in_array($counter['iterator'], $uniqueCounter, true)) {
                return "BossHpParser: key '$section' has duplicate iterator value '". $counter['iterator'] ."'." . PHP_EOL . 'file: ' . $file;
            }
            $uniqueCounter[] = $counter['iterator'];

            // counter unique
            if (isset($counter['counter']) && strlen($counter['counter']) > 2) {
                if (in_array($counter['counter'], $uniqueCounter, true)) {
                    return "BossHpParser: key '$section' has duplicate counter value '". $counter['counter'] ."'." . PHP_EOL . 'file: ' . $file;
                }
                $uniqueCounter[] = $counter['counter'];
            }

            // backup unique
            if (isset($counter['backup']) && strlen($counter['backup']) > 2) {
                if (in_array($counter['backup'], $uniqueCounter, true)) {
                    return "BossHpParser: key '$section' has duplicate backup value '". $counter['backup'] ."'." . PHP_EOL . 'file: ' . $file;
                }
                $uniqueCounter[] = $counter['backup'];
            }

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($counter as $key => $val) {
                if (in_array($key, $fieldName['BossHP']['optional']['counter']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['BossHP']['optional']['counter']['require']) != $totalKeys) {
                foreach ($fieldName['BossHP']['optional']['counter']['require'] as $key) {
                    if (!isset($counter[$key])) {
                        return "BossHpParser: missing filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
                    }
                }
            }
            foreach ($counter as $key => $val) {
                if (!in_array($key, $fieldName['BossHP']['optional']['counter']['optional'], true) && !in_array($key, $fieldName['BossHP']['optional']['counter']['require'], true)) {
                    return "BossHpParser: redundant filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
                }
            }
            foreach ($counter as $key => $val) {
                if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $val)) {
                    return "BossHpParser: invalid symbol '$val' in '$section'." . PHP_EOL . 'file: ' . $file;
                }
            }
            if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $section)) {
                return "BossHpParser: invalid symbol '$section' in '$section'." . PHP_EOL . 'file: ' . $file;
            }
        }
    }

    return null;
}

function parseTranslations(string $file, array $translations) : ?string {

    if (!is_array($translations)) {
        return "TranslationsParser: translations is not an array." . PHP_EOL . 'file: ' . $file;
    }

    global $fieldName;

    foreach ($translations as $section => $tran) {

        if (!is_array($tran)) {
            return "TranslationsParser: key '$section' is not an array." . PHP_EOL . 'file: ' . $file;
        }

        // foreach key
        $totalKeys = 0;
        // check requires
        foreach ($tran as $key => $val) {
            if (in_array($key, $fieldName['Console_T']['require'], true)) {
                $totalKeys++;
            }
        }
        if (count($fieldName['Console_T']['require']) != $totalKeys) {
            foreach ($fieldName['Console_T']['require'] as $key) {
                if (!isset($tran[$key])) {
                    return "TranslationsParser: missing filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
                }
            }
        }
        foreach ($tran as $key => $val) {
            if (!in_array($key, $fieldName['Console_T']['optional'], true) && !in_array($key, $fieldName['Console_T']['require'], true)) {
                return "TranslationsParser: redundant filed '$key' in '$section'." . PHP_EOL . 'file: ' . $file;
            }
        }
        foreach ($tran as $key => $val) {
            if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $val)) {
                return "TranslationsParser: invalid symbol '$val' in '$section'." . PHP_EOL . 'file: ' . $file;
            }
        }
    }

    return null;
}

function parseMapData(string $file, array $mapdata) : ?string {

    if (!is_array($mapdata)) {
        return "MapDataParser: MapData is not an array." . PHP_EOL . 'file: ' . $file;
    }

    global $fieldName;

    foreach ($mapdata as $name => $data) {

        if (!is_array($data)) {
            return "MapDataParser: key '$name' is not an array." . PHP_EOL . 'file: ' . $file;
        }

        // foreach key
        $totalKeys = 0;
        // check requires
        foreach ($data as $key => $val) {
            if (in_array($key, $fieldName['MapData']['require'], true)) {
                $totalKeys++;
            }
        }
        if (count($fieldName['MapData']['require']) != $totalKeys) {
            foreach ($fieldName['MapData']['require'] as $key) {
                if (!isset($data[$key])) {
                    return "MapDataParser: missing filed '$key' in '$name'." . PHP_EOL . 'file: ' . $file;
                }
            }
        }
        foreach ($data as $key => $val) {
            if (!in_array($key, $fieldName['MapData']['optional'], true) && !in_array($key, $fieldName['MapData']['require'], true)) {
                return "MapDataParser: redundant filed '$key' in '$name'." . PHP_EOL . 'file: ' . $file;
            }
        }
        foreach ($data as $key => $val) {
            if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $val)) {
                return "MapDataParser: invalid symbol '$val' in '$name'." . PHP_EOL . 'file: ' . $file;
            }
        }
        if (preg_match('/[！￥…（）——+｛｝|：“《》？，。、；’【】、·]/', $name)) {
            return "MapDataParser: invalid symbol '$name' in '$name'." . PHP_EOL . 'file: ' . $file;
        }
    }

    return null;
}

// a simple parser for Valve's KeyValue format
// https://developer.valvesoftware.com/wiki/KeyValues
//
// author: Rossen Popov, 2015-2016
function KvParser(string $file) : ?array
{

    $text = file_get_contents($file);

    if(!is_string($text)) {
        trigger_error("KvParser expects parameter 1 to be a string, " . gettype($text) . " given." . PHP_EOL . 'file: ' . $file);
        return null;
    }

    // detect and convert utf-16, utf-32 and convert to utf8
    if      (substr($text, 0, 2) == "\xFE\xFF")         $text = mb_convert_encoding($text, 'UTF-8', 'UTF-16BE');
    else if (substr($text, 0, 2) == "\xFF\xFE")         $text = mb_convert_encoding($text, 'UTF-8', 'UTF-16LE');
    else if (substr($text, 0, 4) == "\x00\x00\xFE\xFF") $text = mb_convert_encoding($text, 'UTF-8', 'UTF-32BE');
    else if (substr($text, 0, 4) == "\xFF\xFE\x00\x00") $text = mb_convert_encoding($text, 'UTF-8', 'UTF-32LE');

    // strip BOM
    $text = preg_replace('/^[\xef\xbb\xbf\xff\xfe\xfe\xff]*/', '', $text);

    $lines = preg_split('/\n/', $text);

    $arr = array();
    $stack = array(0=>&$arr);
    $expect_bracket = false;

    $re_keyvalue = '~^("(?P<qkey>(?:\\\\.|[^\\\\"])+)"|(?P<key>[a-z0-9\\-\\_]+))' .
        '([ \t]*(' .
        '"(?P<qval>(?:\\\\.|[^\\\\"])*)(?P<vq_end>")?' .
        '|(?P<val>[a-z0-9\\-\\_]+)' .
        '))?~iu';

    $j = count($lines);
    for($i = 0; $i < $j; $i++) {
        $line = trim($lines[$i]);

        // skip empty and comment lines
        if( $line == "" || $line[0] == '/') { continue; }

        // one level deeper
        if( $line[0] == "{" ) {
            $expect_bracket = false;
            continue;
        }

        if($expect_bracket) {
            trigger_error("KvParser: invalid syntax, expected a '}' on line " . ($i+1) . PHP_EOL . 'file: ' . $file);
            return null;
        }

        // one level back
        if( $line[0] == "}" ) {
            array_pop($stack);
            continue;
        }

        // nessesary for multiline values
        while(True) {
            preg_match($re_keyvalue, $line, $m);

            if(!$m) {
                trigger_error("KvParser: invalid syntax on line " . ($i+1) . PHP_EOL . 'file: ' . $file);
                return null;
            }

            $key = (isset($m['key']) && $m['key'] !== "")
                ? $m['key']
                : $m['qkey'];
            $val = (isset($m['qval']) && (!isset($m['vq_end']) || $m['vq_end'] !== ""))
                ? $m['qval']
                : (isset($m['val']) ? $m['val'] : False);

            if($val === False) {
                // chain (merge*) duplicate key
                if(!isset($stack[count($stack)-1][$key])) {
                    $stack[count($stack)-1][$key] = array();
                }
                $stack[count($stack)] = &$stack[count($stack)-1][$key];
                $expect_bracket = true;
            }
            else {
                // if don't match a closing quote for value, we consome one more line, until we find it
                if(!isset($m['vq_end']) && isset($m['qval'])) {
                    $line .= "\n" . $lines[++$i];
                    continue;
                }

                $stack[count($stack)-1][$key] = $val;
            }
            break;
        }
    }

    if(count($stack) !== 1)  {
        trigger_error("KvParser: open parentheses somewhere" . PHP_EOL . 'file: ' . $file);
        return null;
    }

    return $arr;
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

        if ($file == '.' || $file == '..') {
            continue;
        }
        $KeyValues[] = $dir . '/' . $file;
    }
}

$validated = 0;
$fieldName = [
    'entities' => [
        'require' => [
            'name', 'shortname', 'buttonclass', 'filtername', 'hasfiltername', 'hammerid', 'mode', 'glow', 'hud', 'autotransfer', 'maxuses', 'cooldown', 'maxamount'
        ],
        'optional' => [
            'startcd', 'triggerid', 'containerid', 'isWall', 'level', 'children', 'team'
        ]
    ],
    'Console_T' => [
        'require' => [
            'chi'
        ],
        'optional' => [
            'command', 'blocked'
        ]
    ],
    'BossHP' => [
        'require' => [],
        'optional' => [
            'counter' => [
                'require' => [
                    'iterator'
                ],
                'optional' => [
                    'backup', 'counter', 'displayname', 'countermode', 'multiparts'
                ]
            ],
            'breakable' => [
                'require' => [
                    'targetname'
                ],
                'optional' => [
                    'displayname', 'hpcounts', 'cashonly', 'multiparts'
                ]
            ],
            'monster' => [
                'require' => [
                    'displayname', 'hammerid'
                ],
                'optional' => []
            ]
        ]
    ],
    'MapData' => [
        'require' => [
            'm_Description', 'm_CertainTimes', 'm_Price', 'm_PricePartyBlock', 'm_MinPlayers', 'm_MaxPlayers', 'm_MaxCooldown', 'm_NominateOnly', 'm_VipOnly', 'm_AdminOnly'
        ],
        'optional' => [
            'm_RefundRatio'
        ]
    ]
];

$errorReports = [];

foreach ($KeyValues as $kv) {

    $local = (__DIR__ . '/' . $kv);
    $array = KvParser($local);

    $res = null;

    if (!is_array($array)) {
        trigger_error("Failed to decode file [$kv] -> is_array (Array) return false.");
        continue;
    } else if (isset($array['entities'])) {
        $res = parseEntities($local, $array['entities']);
    } else if (isset($array['Console_T'])) {
        $res = parseTranslations($local, $array['Console_T']);
    } else if (isset($array['BossHP'])) {
        $res = parseBossHp($local, $array['BossHP']);
    } else if (isset($array['MapData'])) {
        $res = parseMapData($local, $array['MapData']);
    }

    if ($res !== null) {
        $errorReports[] = [
            'file' => $local,
            'errs' => $res
        ];
    }

    $validated++;
}

$total = count($errorReports);
if ($total > 0) {

    foreach($errorReports as $error) {
        print_r('Reported File '. $error['file'] . ' with error: ' . $error['errs'] . PHP_EOL);
    }
    //trigger_error(PHP_EOL . PHP_EOL . $total . " errors detected while checking files.", E_USER_ERROR);
    exit(1);
}

print_r("Validated $validated / " . count($KeyValues) . " KeyValue files." . PHP_EOL);
exit(0);