<?php

declare(strict_types=1);

$configs = [
    'Commands' => [
        'echo', 'zr_class_modify'
    ],
    'ConVars' => [
        'mp_timelimit' => ['max' => 300.0, 'min' => 1.0],
        'mp_roundtime' => ['max' => 60.0, 'min' => 1.0],

        'vips_map_extend_times' => ['max' => 5.0, 'min' => 0.0],
        'mcr_map_extend_times' => ['max' => 5.0, 'min' => 0.0],

        'store_thirdperson_enabled' => ['max' => 1.0, 'min' => 0.0],

        'ze_infection_sort_by_keephuman_desc' => ['max' => 1.0, 'min' => 0.0],
        'zr_infect_mzombie_ratio' => ['max' => 32.0, 'min' => 1.0],
        'zr_infect_mzombie_respawn' => ['max' => 1.0, 'min' => 0.0],
        'zr_infect_spawntime_max' => ['max' => 90.0, 'min' => 0.0],
        'zr_infect_spawntime_min' => ['max' => 90.0, 'min' => 0.0],
        'zr_knockback_multi' => ['max' => 1.5, 'min' => 0.1],

        'ze_damage_zombie_cash' => ['max' => 3.0, 'min' => 0.1],
        'ze_damage_rank_points' => ['max' => 99999.0, 'min' => 5000.0],
        'ze_damage_shop_credit' => ['max' => 99999.0, 'min' => 5000.0],
        'ze_credits_pass_round' => ['max' => 30.0, 'min' => 1.0],
        'rank_ze_win_points_humans' => ['max' => 30.0, 'min' => 1.0],

        'ze_bosshp_display_breakable' => ['max' => 1.0, 'min' => 0.0],
        'ze_bosshp_vscript_creation' => ['max' => 1.0, 'min' => 0.0],

        'ze_newbee_protection_point' => ['max' => 100000.0, 'min' => 500.0],
        'ze_entwatch_require_client' => ['max' => 1.0, 'min' => 0.0],

        'ze_buttons_glow_enabled' => ['max' => 1.0, 'min' => 0.0],

        'k_nv_enabled' => ['max' => 1.0, 'min' => 0.0],
        'k_fl_enabled' => ['max' => 1.0, 'min' => 0.0],

        'ze_savelevel_enable' => ['max' => 1.0, 'min' => 0.0],
        'ze_savelevel_filter' => ['max' => 1.0, 'min' => 0.0],
        'ze_savelevel_onuser' => ['max' => 1.0, 'min' => 0.0],
        'ze_savelevel_multis' => ['max' => 1.0, 'min' => 0.0],

        'ze_grenade_nade_cfeffect' => ['max' => 3.0, 'min' => 0.0],

        'ze_weapons_awp_counts' => ['max' => 64.0, 'min' => 1.0],
        'ze_weapons_spawn_hegrenade' => ['max' => 2.0, 'min' => 0.0],
        'ze_weapons_spawn_molotov' => ['max' => 1.0, 'min' => 0.0],
        'ze_weapons_spawn_decoy' => ['max' => 1.0, 'min' => 0.0],
        'ze_weapons_round_hegrenade' => ['max' => 15.0, 'min' => -1.0],
        'ze_weapons_round_molotov' => ['max' => 10.0, 'min' => -1.0],
        'ze_weapons_round_decoy' => ['max' => 10.0, 'min' => -1.0],
        'ze_weapons_round_flash' => ['max' => 10.0, 'min' => -1.0],
        'ze_weapons_round_tagrenade' => ['max' => 5.0, 'min' => -1.0],
        'ze_weapons_round_healshot' => ['max' => 5.0, 'min' => -1.0],

        'sm_hunter_leappower' => ['max' => 500.0, 'min' => 150.0],
        'sm_faster_maxspeed' => ['max' => 2.0, 'min' => 1.1],
        'sm_boomer_distance' => ['max' => 999.0, 'min' => 100.0],
        'sm_smoker_distance' => ['max' => 9999.0, 'min' => 100.0],
        'sm_blader_damage' => ['max' => 5000.0, 'min' => 30.0],
        'sm_farter_distance' => ['max' => 9999.0, 'min' => 50.0],

        'sv_autobunnyhopping' => ['max' => 1.0, 'min' => 0.0],
        'sv_enablebunnyhopping' => ['max' => 1.0, 'min' => 0.0],

        'ammo_grenade_limit_flashbang' => ['max' => 2.0, 'min' => 0.0],
        'ammo_grenade_limit_total' => ['max' => 5.0, 'min' => 0.0],

        'sv_gravity' => ['max' => 800.0, 'min' => 790.0],

        'mg_randomteam' => ['max' => 1.0, 'min' => 0.0],
        'mg_bhopspeed' => ['max' => 3500.0, 'min' => 200.0],

        'mg_spawn_pistol' => ['max' => 1.0, 'min' => 0.0],
        'mg_spawn_knife' => ['max' => 1.0, 'min' => 0.0],
        'mg_spawn_helmet' => ['max' => 1.0, 'min' => 0.0],
        'mg_spawn_kevlar' => ['max' => 100.0, 'min' => 0.0],
        'mg_economy_system' => ['max' => 2.0, 'min' => 0.0],

        'mg_restrict_awp' => ['max' => 1.0, 'min' => 0.0],
        'mg_restrict_machinegun' => ['max' => 1.0, 'min' => 0.0],
        'mg_restrict_autosniper' => ['max' => 1.0, 'min' => 0.0],

        'mg_wallhack_delay' => ['max' => 240.0, 'min' => 60.0],

        'mp_buytime' => ['max' => 180.0, 'min' => 10.0],
        'mp_taser_recharge_time' => ['max' => 30.0, 'min' => -1.0],
    ],
];

$listFile = new SplFileObject(__DIR__ . '/__CI/Configs.list');
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

function checkConfig(string $_text) : ?string {
    global $configs;

    $text = trim($_text);
    if (strncmp($text, "//", 2) == 0 || strlen($text) < 2) {
        return null;
    }

    $pos = strpos($text, ' ');
    if ($pos === false) {
        return "Failed to parse line.";
    }

    $first = substr($text, 0, $pos);
    $second = str_replace('"', "", substr($text, $pos+1));

    $command = strtolower($first);
    if (in_array($command, $configs['Commands'])) {
        return null;
    }

    if (!array_key_exists($command, $configs['ConVars'])) {
        return "$command is undefined.";
    }

    $var = $configs['ConVars'][$command];
    $value = floatval($second);
    if ($value > $var['max'] || $value < $var['min']) {
        return "value of '$command' is out-of-bounds ($value).";
    }

    return null;
}

function checkFile(string $path) : ?array {
    $file = new SplFileObject($path);
    $line = 0;
    while (!$file->eof()) {
        $line++;

        $text = $file->fgets();
        $resp = checkConfig($text);
        if ($resp !== null) {
            return [
                'line' => $line,
                'resp' => $resp
            ];
        }
    }
    return null;
}

foreach ($FileList as $file) {

    $resp = checkFile($file);
    if ($resp !== null) {
        $errorReports[] = [
            'file' => $file,
            'line' => $resp['line'],
            'errs' => $resp['resp'] ?? "illegal command or value.",
        ];
    }
    $validated++;
}

if (count($errorReports) > 0) {
    foreach($errorReports as $error) {
        print_r('Reported File '. $error['file'] . '(' . $error['line'] . ') with error: ' . $error['errs'] . PHP_EOL);
    }
    exit(1);
}

print_r("Validated $validated / " . count($FileList) . " Configs." . PHP_EOL);
exit(0);