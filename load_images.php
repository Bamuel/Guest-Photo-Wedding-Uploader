<?php
//read json file
$json = file_get_contents('config.json');
//decode json
$json_data = json_decode($json, true);

if (!file_exists('savedimages')) {
    @mkdir('savedimages', 0777, true);
}
if (file_exists('savedimages')) {
    // Get files and their timestamps
    $filesWithTimestamp = [];
    $files = scandir('savedimages');
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = 'savedimages/' . $file;
            if (filesize($filePath) >= 5 * 1024) { // Check if filesize is at least 5KB
                $fileTimestamp = filemtime($filePath); // Get the file's last modified timestamp
                $filesWithTimestamp[$file] = $fileTimestamp;
            }
        }
    }

    // Sort files by timestamp
    arsort($filesWithTimestamp); // Sort in descending order based on timestamp

    // Check if the user agent is from an Apple device (Mac, iPhone, iPad). This is used to display video files only on Apple devices as <img>
    $isAppleDevice = strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false;

    $output = array();
    // Display files
    foreach ($filesWithTimestamp as $file => $timestamp) {
        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $userName = substr($fileName, 0, strpos($fileName, '_'));
        if (in_array($fileExtension, array('mov', 'mp4', 'avi', 'webm', 'mkv')) && !$isAppleDevice) {
            $type = "video";
        }
        else {
            $type = "image";
        }

        // Display the icon
        if ($userName === 'Anonymous' || $userName === "") {
            $icon = 'fa-solid fa-user-secret fa-lg';
            $userName = 'Anonymous';
        }
        else if (strtolower($userName) === 'test') {
            $icon = 'fa-solid fa-terminal fa-lg';
        }
        else if (in_array(strtolower($userName), $json_data['ninja'], true)) {
            $icon = 'fa-solid fa-user-ninja fa-lg';
        }
        else if (in_array(strtolower($userName), $json_data['doctor'], true)) {
            $icon = 'fa-solid fa-user-doctor fa-lg';
        }
        else if (in_array(strtolower($userName), $json_data['injured'], true)) {
            $icon = 'fa-solid fa-user-injured fa-lg';
        }
        else if (in_array(strtolower($userName), $json_data['photographers'], true)) {
            $icon = 'fa-solid fa-camera-retro fa-lg';
        }
        else {
            $icon = 'fa-solid fa-user fa-lg';
        }
        $output[] = array(
            'file' => $file,
            'type' => $type,
            'icon' => $icon,
            'timestamp' => $timestamp,
            'userName' => $userName,
            'fileExtension' => $fileExtension);
    }

    echo json_encode($output);
}