<?php
//get ajax request and upload file (can be multiple) to savedimages folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request contains files
    if (isset($_FILES['files'])) {
        // Specify the directory where the uploaded files will be saved
        $uploadDir = 'savedimages/';
        $originalVideoDir = 'original_videos/';
        $name = $_POST['name'] ?? 'Anonymous';
        $name = $name === '' ? 'Anonymous' : $name;

        // Check if the directory exists, if not, create it
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (!file_exists($originalVideoDir)) {
            mkdir($originalVideoDir, 0777, true);
        }

        // Get the temporary file path
        $tmpFilePath = $_FILES['files']['tmp_name'];

        // Check if a file was actually uploaded
        if ($tmpFilePath != "") {
            $fileExtension = strtolower(pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION));
            // Generate a unique filename to avoid overwriting existing files
            $fileName = $name . '_' . uniqid() . '_' . $_FILES['files']['name'];

            // Set the destination path for the uploaded file
            $newFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                if (in_array($fileExtension, array('mov', 'mp4', 'avi', 'webm', 'mkv'))) {
                    // Move the original video to the original_videos directory
                    $originalFilePath = $originalVideoDir . $fileName;
                    rename($newFilePath, $originalFilePath);
                    //A conversion will be handled by a separate script handbrake.sh
                }
                echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
            }
            else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
            }
        }
    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'No files were uploaded']);
    }
}
else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}