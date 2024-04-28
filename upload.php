<?php
//get ajax request and upload file (can be multiple) to savedimages folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request contains files
    if (isset($_FILES['file'])) {
        // Specify the directory where the uploaded files will be saved
        $uploadDir = 'savedimages/';

        // Check if the directory exists, if not, create it
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Get Nam of the person
        $name = $_POST['name'];

        // Loop through each file in the request
        $fileCount = count($_FILES['file']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            // Get the temporary file path
            $tmpFilePath = $_FILES['file']['tmp_name'][$i];

            // Check if a file was actually uploaded
            if ($tmpFilePath != "") {
                // Generate a unique filename to avoid overwriting existing files
                $fileName = uniqid() . '_' . $_FILES['file']['name'][$i];

                // Set the destination path for the uploaded file
                $newFilePath = $uploadDir . $fileName;


                // Compress the image before uploading
                compressImage($tmpFilePath, $newFilePath);
                // Output success message
                echo "File uploaded successfully: $fileName\n";

            }
        }
    } else {
        echo "No files uploaded";
    }
} else {
    echo "Invalid request method";
}

function compressImage($source, $destination, $quality = 75)
{
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg')
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    else
        return false;

    // Save the compressed image
    imagejpeg($image, $destination, $quality);

    // Free up memory
    imagedestroy($image);

    return true;
}

?>