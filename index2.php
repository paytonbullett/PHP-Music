<?php
// index.php

error_reporting(E_ALL & ~E_DEPRECATED);
session_start();
set_time_limit(0);

// --- ROUTING ---
$pwa = $_GET['pwa'] ?? null;
$access = $_GET['access'] ?? null;
$action = $_GET['action'] ?? null;

if ($pwa) {
    require __DIR__ . '/actions/pwa.php';
    exit;
}

if ($access === 'admin') {
    require __DIR__ . '/actions/admin.php';
    exit;
}

if ($action === 'full_scan') {
    require __DIR__ . '/actions/scan.php';
    exit;
}

if ($action) {
    require __DIR__ . '/actions/api.php';
    exit;
}

// --- RENDER MAIN PAGE ---
$initialViewJS = '';
if (isset($_GET['share_type']) && isset($_GET['id'])) {
    require_once __DIR__ . '/database.php';
    $db_for_share = get_db();
    $share_type = $_GET['share_type'];
    $share_id_raw = $_GET['id'];
    $view_config = null;

    switch ($share_type) {
        case 'song':
            $stmt = $db_for_share->prepare("SELECT album FROM music WHERE id = ?");
            $stmt->execute([(int)$share_id_raw]);
            $song_info = $stmt->fetch();
            if ($song_info) {
                $view_config = [
                    'type' => 'album_songs',
                    'param' => rawurlencode($song_info['album']),
                    'sort' => 'title_asc',
                    'highlight' => (int)$share_id_raw
                ];
            }
            break;
        case 'album':
            $view_config = ['type' => 'album_songs', 'param' => rawurlencode($share_id_raw), 'sort' => 'title_asc'];
            break;
        case 'artist':
            $view_config = ['type' => 'artist_songs', 'param' => rawurlencode($share_id_raw), 'sort' => 'album_asc'];
            break;
        case 'playlist':
            $stmt = $db_for_share->prepare("SELECT id FROM playlists WHERE public_id = ?");
            $stmt->execute([$share_id_raw]);
            if ($stmt->fetch()) {
                $view_config = ['type' => 'playlist_songs', 'param' => rawurlencode($share_id_raw), 'sort' => 'manual_order'];
            }
            break;
    }

    if ($view_config) {
        $initialViewJSON = json_encode($view_config);
        $initialViewJS = "<script>window.initialView = {$initialViewJSON};</script>";
    }
}

// Load the main HTML layout
require __DIR__ . '/views/main_layout.php';
