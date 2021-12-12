<?php

declare(strict_types=1);

function errorHandler(int $errno , string $error) : bool {

    print_r("ERROR #" . $errno . " -> " . $error . PHP_EOL);

    if ($errno != E_USER_NOTICE) {
        print_r(json_encode(debug_backtrace(), JSON_PRETTY_PRINT) . PHP_EOL);
    }

    exit(1);
}

function parseEntities(array $entities) : ?string {

    if (!is_array($entities)) {
        return "EntitiesParser: entities is not an array.";
    }

    global $fieldName;

    foreach ($entities as $section => $entity) {

        if (!is_array($entity)) {
            return "EntitiesParser: key '$section' is not an array.";
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
                    return "EntitiesParser: missing filed '$key' in '$section'.";
                }
            }
        }

        foreach ($entity as $key => $val) {
            if (!in_array($key, $fieldName['entities']['optional'], true) && !in_array($key, $fieldName['entities']['require'], true)) {
                return "EntitiesParser: redundant filed '$key' in '$section'.";
            }
            if (is_string($val) && preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                return "EntitiesParser: invalid symbol '$val' in '$section'.";
            } else if (is_array($val)) {
                foreach ($val as $v) {
                    if (is_string($v) && preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $v)) {
                        return "EntitiesParser: invalid symbol '$v' in '$section'.";
                    } else if (is_array($v)) {
                        foreach ($v as $_v) {
                            if (is_string($val) && preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $_v)) {
                                return "EntitiesParser: invalid symbol '$_v' in '$section'.";
                            }
                        }
                    }
                }
            }
        }
    }

    return null;
}

function parseBossHp(array $BossHp) : ?string {

    if (!is_array($BossHp)) {
        return "BossHpParser: entities is not an array.";
    }

    global $fieldName;

    $uniqueBreakable = [];
    $uniqueCounter = [];
    $uniqueMonster = [];

    if (isset($BossHp['monster'])) {

        if (!is_array($BossHp['monster'])) {
            return "BossHpParser: monster is not an array.";
        }

        foreach ($BossHp['monster'] as $section => $monster) {

            if (!is_array($monster)) {
                return "BossHpParser: key '$section' is not an array.";
            }

            // iterator unique
            if (in_array($monster['hammerid'], $uniqueMonster, true)) {
                return "BossHpParser: key '$section' has duplicate hammerid value '". $monster['hammerid'] ."'.";
            }
            $uniqueMonster[] = $monster['hammerid'];

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($monster as $key => $val) {
                if (in_array($key, $fieldName['BossHP']['optional']['monster']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['BossHP']['optional']['monster']['require']) != $totalKeys) {
                foreach ($fieldName['BossHP']['optional']['monster']['require'] as $key) {
                    if (!isset($monster[$key])) {
                        return "BossHpParser: missing filed '$key' in '$section'.";
                    }
                }
            }
            foreach ($monster as $key => $val) {
                if (!in_array($key, $fieldName['BossHP']['optional']['monster']['optional'], true) && !in_array($key, $fieldName['BossHP']['optional']['monster']['require'], true)) {
                    return "BossHpParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "BossHpParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "BossHpParser: invalid symbol '$val' in '$section'.";
                }
            }
        }
    }

    if (isset($BossHp['breakable'])) {

        if (!is_array($BossHp['breakable'])) {
            return "BossHpParser: breakable is not an array.";
        }

        foreach ($BossHp['breakable'] as $section => $breakable) {

            if (!is_array($breakable)) {
                return "BossHpParser: key '$section' is not an array.";
            }

            // iterator unique
            if (in_array($breakable['targetname'], $uniqueBreakable, true)) {
                return "BossHpParser: key '$section' has duplicate targetname value '". $breakable['targetname'] ."'.";
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
                        return "BossHpParser: missing filed '$key' in '$section'.";
                    }
                }
            }
            foreach ($breakable as $key => $val) {
                if (!in_array($key, $fieldName['BossHP']['optional']['breakable']['optional'], true) && !in_array($key, $fieldName['BossHP']['optional']['breakable']['require'], true)) {
                    return "BossHpParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "BossHpParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "BossHpParser: invalid symbol '$val' in '$section'.";
                }
            }
        }
    }

    if (isset($BossHp['counter'])) {

        if (!is_array($BossHp['counter'])) {
            return "BossHpParser: breakable is not an array.";
        }

        foreach ($BossHp['counter'] as $section => $counter) {

            if (!is_array($counter)) {
                return "BossHpParser: key '$section' is not an array.";
            }

            // iterator unique
            if (in_array($counter['iterator'], $uniqueCounter, true)) {
                return "BossHpParser: key '$section' has duplicate iterator value '". $counter['iterator'] ."'.";
            }
            $uniqueCounter[] = $counter['iterator'];

            // counter unique
            if (isset($counter['counter']) && strlen($counter['counter']) > 2) {
                if (in_array($counter['counter'], $uniqueCounter, true)) {
                    return "BossHpParser: key '$section' has duplicate counter value '". $counter['counter'] ."'.";
                }
                $uniqueCounter[] = $counter['counter'];
            }

            // backup unique
            if (isset($counter['backup']) && strlen($counter['backup']) > 2) {
                if (in_array($counter['backup'], $uniqueCounter, true)) {
                    return "BossHpParser: key '$section' has duplicate backup value '". $counter['backup'] ."'.";
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
                        return "BossHpParser: missing filed '$key' in '$section'.";
                    }
                }
            }
            foreach ($counter as $key => $val) {
                if (!in_array($key, $fieldName['BossHP']['optional']['counter']['optional'], true) && !in_array($key, $fieldName['BossHP']['optional']['counter']['require'], true)) {
                    return "BossHpParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "BossHpParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "BossHpParser: invalid symbol '$val' in '$section'.";
                }
            }
        }
    }

    return null;
}

function parseTranslations(array $translations) : ?string {

    if (!is_array($translations)) {
        return "TranslationsParser: translations is not an array.";
    }

    global $fieldName;

    foreach ($translations as $section => $tran) {

        if (!is_array($tran)) {
            return "TranslationsParser: key '$section' is not an array.";
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
                    return "TranslationsParser: missing filed '$key' in '$section'.";
                }
            }
        }
        foreach ($tran as $key => $val) {
            if (!in_array($key, $fieldName['Console_T']['optional'], true) && !in_array($key, $fieldName['Console_T']['require'], true)) {
                return "TranslationsParser: redundant filed '$key' in '$section'.";
            }
            if (!is_string($val)) {
                return "TranslationsParser: invalid struct '$val' in '$section'.";
            }
            if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！%]/xu', $val)) {
                return "TranslationsParser: invalid symbol '$val' in '$section'.";
            }
        }
    }

    return null;
}

function parseMapData(array $mapdata) : ?string {

    if (!is_array($mapdata)) {
        return "MapDataParser: MapData is not an array.";
    }

    global $fieldName;

    foreach ($mapdata as $name => $data) {

        if (!is_array($data)) {
            return "MapDataParser: key '$name' is not an array.";
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
                    return "MapDataParser: missing filed '$key' in '$name'.";
                }
            }
        }
        foreach ($data as $key => $val) {
            if (!in_array($key, $fieldName['MapData']['optional'], true) && !in_array($key, $fieldName['MapData']['require'], true)) {
                return "MapDataParser: redundant filed '$key' in '$name'.";
            }
            if (!is_string($val)) {
                return "MapDataParser: invalid struct '$val' in '$name'.";
            }
            if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                return "MapDataParser: invalid symbol '$val' in '$name'.";
            }
        }
    }

    return null;
}

function parseMapStage(array $mapstage) : ?string {

    if (!is_array($mapstage)) {
        return "MapStageParser: MapStage is not an array.";
    }

    global $fieldName;

    foreach ($mapstage as $name => $data) {

        if (!is_array($data)) {
            return "MapStageParser: key '$name' is not an array.";
        }

        // foreach key
        $totalKeys = 0;
        // check requires
        foreach ($data as $key => $val) {
            if (in_array($key, $fieldName['MapStage']['require'], true)) {
                $totalKeys++;
            }
        }
        if (count($fieldName['MapStage']['require']) != $totalKeys) {
            foreach ($fieldName['MapStage']['require'] as $key) {
                if (!isset($data[$key])) {
                    return "MapStageParser: missing filed '$key' in '$name'.";
                }
            }
        }
        foreach ($data as $key => $val) {
            if (!in_array($key, $fieldName['MapStage']['optional'], true) && !in_array($key, $fieldName['MapStage']['require'], true)) {
                return "MapStageParser: redundant filed '$key' in '$name'.";
            }
            if (!is_string($val)) {
                return "MapStageParser: invalid struct '$val' in '$name'.";
            }
            if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                return "MapStageParser: invalid symbol '$val' in '$name'.";
            }
        }
    }

    return null;
}

function parseButtons(array $buttons) : ?string {

    if (!is_array($buttons)) {
        return "ButtonsParser: Buttons is not an array.";
    }

    global $fieldName;

    foreach ($buttons as $name => $data) {

        if (!is_array($data)) {
            return "ButtonsParser: key '$name' is not an array.";
        }

        // foreach key
        $totalKeys = 0;
        // check requires
        foreach ($data as $key => $val) {
            if (in_array($key, $fieldName['Buttons']['require'], true)) {
                $totalKeys++;
            }
        }
        if (count($fieldName['Buttons']['require']) != $totalKeys) {
            foreach ($fieldName['Buttons']['require'] as $key) {
                if (!isset($data[$key])) {
                    return "ButtonsParser: missing filed '$key' in '$name'.";
                }
            }
        }
        foreach ($data as $key => $val) {
            if (!in_array($key, $fieldName['Buttons']['optional'], true) && !in_array($key, $fieldName['Buttons']['require'], true)) {
                return "ButtonsParser: redundant filed '$key' in '$name'.";
            }
            if (!is_string($val)) {
                return "ButtonsParser: invalid struct '$val' in '$name'.";
            }
            if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                return "ButtonsParser: invalid symbol '$val' in '$name'.";
            }
        }
    }

    return null;
}

function parseAwards(array $Awards) : ?string {

    if (!is_array($Awards)) {
        return "AwardsParser: entities is not an array.";
    }

    global $fieldName;

    if (isset($Awards['tp'])) {

        if (!is_array($Awards['tp'])) {
            return "AwardsParser: tp is not an array.";
        }

        foreach ($Awards['tp'] as $section => $tp) {

            if (!is_array($tp)) {
                return "AwardsParser: key '$section' is not an array.";
            }

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($tp as $key => $val) {
                if (in_array($key, $fieldName['Awards']['optional']['tp']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['Awards']['optional']['tp']['require']) != $totalKeys) {
                foreach ($fieldName['Awards']['optional']['tp']['require'] as $key) {
                    if (!isset($monster[$key])) {
                        return "AwardsParser: missing filed '$key' in '$section'.";
                    }
                }
            }

            foreach ($tp as $key => $val) {
                if (!in_array($key, $fieldName['Awards']['optional']['tp']['optional'], true) && !in_array($key, $fieldName['Awards']['optional']['tp']['require'], true)) {
                    return "AwardsParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "AwardsParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "AwardsParser: invalid symbol '$val' in '$section'.";
                }
            }
        }
    }

    if (isset($Awards['pro'])) {

        if (!is_array($Awards['pro'])) {
            return "AwardsParser: pro is not an array.";
        }

        foreach ($Awards['pro'] as $section => $pro) {

            if (!is_array($pro)) {
                return "AwardsParser: key '$section' is not an array.";
            }

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($pro as $key => $val) {
                if (in_array($key, $fieldName['Awards']['optional']['pro']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['Awards']['optional']['pro']['require']) != $totalKeys) {
                foreach ($fieldName['Awards']['optional']['pro']['require'] as $key) {
                    if (!isset($monster[$key])) {
                        return "AwardsParser: missing filed '$key' in '$section'.";
                    }
                }
            }

            foreach ($pro as $key => $val) {
                if (!in_array($key, $fieldName['Awards']['optional']['pro']['optional'], true) && !in_array($key, $fieldName['Awards']['optional']['pro']['require'], true)) {
                    return "AwardsParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "AwardsParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "AwardsParser: invalid symbol '$val' in '$section'.";
                }
            }
        }
    }

    if (isset($Awards['bhop'])) {

        if (!is_array($Awards['bhop'])) {
            return "AwardsParser: pro is not an array.";
        }

        foreach ($Awards['bhop'] as $section => $bhop) {

            if (!is_array($bhop)) {
                return "AwardsParser: key '$section' is not an array.";
            }

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($bhop as $key => $val) {
                if (in_array($key, $fieldName['Awards']['optional']['bhop']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['Awards']['optional']['bhop']['require']) != $totalKeys) {
                foreach ($fieldName['Awards']['optional']['bhop']['require'] as $key) {
                    if (!isset($monster[$key])) {
                        return "AwardsParser: missing filed '$key' in '$section'.";
                    }
                }
            }

            foreach ($bhop as $key => $val) {
                if (!in_array($key, $fieldName['Awards']['optional']['bhop']['optional'], true) && !in_array($key, $fieldName['Awards']['optional']['bhop']['require'], true)) {
                    return "AwardsParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "AwardsParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "AwardsParser: invalid symbol '$val' in '$section'.";
                }
            }
        }
    }

    if (isset($Awards['surf'])) {

        if (!is_array($Awards['surf'])) {
            return "AwardsParser: pro is not an array.";
        }

        foreach ($Awards['surf'] as $section => $surf) {

            if (!is_array($surf)) {
                return "AwardsParser: key '$section' is not an array.";
            }

            // foreach key
            $totalKeys = 0;
            // check requires
            foreach ($surf as $key => $val) {
                if (in_array($key, $fieldName['Awards']['optional']['surf']['require'], true)) {
                    $totalKeys++;
                }
            }
            if (count($fieldName['Awards']['optional']['surf']['require']) != $totalKeys) {
                foreach ($fieldName['Awards']['optional']['surf']['require'] as $key) {
                    if (!isset($monster[$key])) {
                        return "AwardsParser: missing filed '$key' in '$section'.";
                    }
                }
            }

            foreach ($surf as $key => $val) {
                if (!in_array($key, $fieldName['Awards']['optional']['surf']['optional'], true) && !in_array($key, $fieldName['Awards']['optional']['surf']['require'], true)) {
                    return "AwardsParser: redundant filed '$key' in '$section'.";
                }
                if (!is_string($val)) {
                    return "AwardsParser: invalid struct '$val' in '$section'.";
                }
                if (preg_match('/[￥…（）—｛｝：“《》？，。、；’【】·！]/xu', $val)) {
                    return "AwardsParser: invalid symbol '$val' in '$section'.";
                }
            }
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

$listFile = new SplFileObject(__DIR__ . '/__CI/KeyValues.list');
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
            'startcd', 'triggerid', 'containerid', 'isWall', 'level', 'children', 'team', 'holy'
        ]
    ],
    'Console_T' => [
        'require' => [
            'chi'
        ],
        'optional' => [
            'command', 'blocked', "countdown"
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
                    'backup', 'counter', 'displayname', 'countermode', 'multiparts', 'hitbox'
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
            'm_RefundRatio', 'm_Difficulty'
        ]
    ],
    'MapStage' => [
        'require' => [
            'stages', 'extreme'
        ],
        'optional' => [
            'exstart'
        ]
    ],
    'Buttons' => [
        'require' => [
            'id', 'mode', 'name'
        ],
        'optional' => [
            'cd'
        ]
    ],
    'Awards' => [
        'require' => [],
        'optional' => [
            'tp' => [
                'require' => [
                    'max', 'ptr'
                ],
                'optional' => []
            ],
            'pro' => [
                'require' => [
                    'max', 'ptr'
                ],
                'optional' => []
            ],
            'bhop' => [
                'require' => [
                    'max', 'ptr'
                ],
                'optional' => []
            ],
            'surf' => [
                'require' => [
                    'max', 'ptr'
                ],
                'optional' => []
            ]
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
        $res = parseEntities($array['entities']);
    } else if (isset($array['Console_T'])) {
        $res = parseTranslations($array['Console_T']);
    } else if (isset($array['BossHP'])) {
        $res = parseBossHp($array['BossHP']);
    } else if (isset($array['MapData'])) {
        $res = parseMapData($array['MapData']);
    } else if (isset($array['MapStage'])) {
        $res = parseMapStage($array['MapStage']);
    } else if (isset($array['Buttons'])) {
        $res = parseButtons($array['Buttons']);
    } else if (isset($array['Awards'])) {
        $res = parseAwards($array['Awards']);
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