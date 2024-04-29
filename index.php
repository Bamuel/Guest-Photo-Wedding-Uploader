<?php
//read json file
$json = file_get_contents('config.json');
//decode json
$json_data = json_decode($json, true);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= strip_tags($json_data['title']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .banner {
            background-image: url('<?= $json_data['imageBanner'] ?>');
            background-size: cover;
            background-position: center;
            padding: 0;
            text-align: center;
            color: white;
            opacity: 0.7;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .banner {
                padding: 30px 0;
            }

            h1 {
                font-size: 28px;
            }

            p {
                font-size: 16px;
            }
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .user-details {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 255, 255, 0.75);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .user-details i {
            margin-right: 5px;
        }
    </style>
    <link href="fileinput/fileinput.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="fileinput/themes/explorer-fa6/theme.min.css">
</head>
<body>
<div class="banner">
    <div class="container">
        <h1><?= $json_data['title'] ?></h1>
    </div>
</div>
<div class="container">
    <br>
    <p class="lead">Hello all you lovely people, we are collecting photos that people took at our wedding, so if you
        have pictures please add them here!</p>
    <p>Please add your name, so we know who they have come from. Upload your pictures with the file picker below! (you
        can add multiple pictures at the same time)</p>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="photo">Upload Photo:</label><br>
            <input id="files" type="file" name="files" multiple accept="image/*,video/*">
        </div>
    </form>
</div>
<br>
<hr style="width: 80%; margin: auto;">
<br>
<!-- Gallery -->
<div class="container">
    <h2>Gallery</h2>
    <div class="row">
        <?php
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
                    $fileTimestamp = filemtime($filePath); // Get the file's last modified timestamp
                    $filesWithTimestamp[$file] = $fileTimestamp;
                }
            }

            // Sort files by timestamp
            arsort($filesWithTimestamp); // Sort in descending order based on timestamp

            // Check if the user agent is from an Apple device (Mac, iPhone, iPad). This is used to display video files only on Apple devices as <img>
            $isAppleDevice = strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false;

            // Display files
            foreach ($filesWithTimestamp as $file => $timestamp) {
                $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $userName = substr($fileName, 0, strpos($fileName, '_'));
                echo '<div class="col-lg-4 col-md-4 col-sm-6 col-6">' . PHP_EOL;
                echo '<div class="image-container position-relative">' . PHP_EOL;

                if (in_array($fileExtension, array('mov', 'mp4', 'avi', 'webm', 'mkv')) && !$isAppleDevice) {
                    // Check if the file is a video and if it is not an Apple device
                    echo '<div id="videoContainer_' . $fileName . '" class="videoBackground">' . PHP_EOL;
                    echo '<video class="w-100 shadow-1-strong rounded mb-4" style="border: 1px solid black;" preload="none" controls muted>' . PHP_EOL;
                    echo '<source src="savedimages/' . $file . '" type="video/' . $fileExtension . '" onerror="document.getElementById(\'videoContainer_' . $fileName . '\').style.display=\'none\'; document.getElementById(\'videoError_' . $fileName . '\').style.display=\'block\'">' . PHP_EOL;
                    echo '</video>' . PHP_EOL;
                    echo '</div>' . PHP_EOL;
                    //button to download video instead.
                    echo '<div id="videoError_' . $fileName . '" class="w-100 shadow-1-strong rounded mb-4" style="display: none; color: red; background-color: #333333"><br><br><span style="margin-left: 10px">Your browser does not support the iOS format Videos.</span><div style="margin-left: 10px" class="btn btn-sm btn-success" onclick="window.open(\'savedimages/' . $file . '\', \'_blank\');"><i class="fa-solid fa-download fa-fw"></i> Download</div><br><br></div>' . PHP_EOL;
                }
                else {
                    //One day Chrome/Edge/Firefox will support video in img tags. Until then, we'll just show a video.
                    echo '<img src="savedimages/' . $file . '" class="w-100 shadow-1-strong rounded mb-4" style="border: 1px solid black;" ondblclick="window.open(\'savedimages/' . $file . '\', \'_blank\');">' . PHP_EOL;
                }

                echo '<div class="user-details">' . PHP_EOL;
                if ($userName === 'Anonymous' || $userName === "") {
                    echo '<i class="fa-solid fa-user-secret fa-lg"></i>' . $userName . '</div>' . PHP_EOL;
                }
                else if ($userName === 'test') {
                    echo '<i class="fa-solid fa-terminal fa-lg"></i>' . $userName . '</div>' . PHP_EOL;
                }
                else {
                    echo '<i class="fa-solid fa-user fa-lg"></i>' . $userName . '</div>' . PHP_EOL;
                }
                echo '</div>' . PHP_EOL;
                echo '</div>' . PHP_EOL;
            }
        }
        ?>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="fileinput/fileinput.min.js"></script>
<script src="fileinput/themes/explorer-fa6/theme.min.js"></script>
<script>
    $(document).ready(function () {
        $("#files").fileinput({
            theme: "explorer-fa6",
            allowedFileTypes: ['image', 'video'],
            uploadUrl: 'upload.php',
            uploadExtraData: function () {
                var name = $('#name').val();
                return {name: name};
            },
            maxFileSize: 51200, // 50MB
            showRemove: false,
            showUpload: true,
            showDownload: false,
            showZoom: false,
            showDrag: false,
            showPreview: false,
            showCancel: false,
            fileActionSettings: {
                showRemove: false,
                showUpload: false,
                showDownload: false,
                showZoom: false,
                showDrag: false,
                showPreview: false,
                showCancel: false,
            },
            showUploadedThumbs: false,
            dropZoneEnabled: false
        });
        $('#files').on('filebatchuploadcomplete', function (event, preview, config, tags, extraData) {
            location.reload();
        });
    });
</script>

</body>
</html>

