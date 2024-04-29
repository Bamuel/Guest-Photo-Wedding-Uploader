<?php
//get ajax request and upload file (can be multiple) to savedimages folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request contains files
    if (isset($_FILES['files'])) {
        // Specify the directory where the uploaded files will be saved
        $uploadDir = 'savedimages/';
        $name = $_POST['name'] ?? 'Anonymous';
        $name = $name === '' ? 'Anonymous' : $name;

        // Check if the directory exists, if not, create it
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Get the temporary file path
        $tmpFilePath = $_FILES['files']['tmp_name'];

        // Check if a file was actually uploaded
        if ($tmpFilePath != "") {
            // Generate a unique filename to avoid overwriting existing files
            $fileName = $name . '_' . uniqid() . '_' . $_FILES['files']['name'];

            // Set the destination path for the uploaded file
            $newFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
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