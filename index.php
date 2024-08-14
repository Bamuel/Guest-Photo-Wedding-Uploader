<?php
//read json file
$json = file_get_contents('config.json');
//decode json
$json_data = json_decode($json, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= strip_tags($json_data['title']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="author" content="Bamuel, me@bamuel.com">
    <meta http-equiv="Content-Language" content="en-au">
    <meta name="description" content="<?= strip_tags($json_data['description']) ?>">
    <meta property="og:title" content="<?= strip_tags($json_data['title']) ?>"/>
    <meta property="og:image" content="<?= $json_data['imageBanner'] ?>"/>
    <meta property="og:description" content="<?= strip_tags($json_data['description']) ?>"/>
    <meta name="twitter:title" content="<?= strip_tags($json_data['title']) ?>">
    <meta name="twitter:image" content="<?= $json_data['imageBanner'] ?>"/>
    <meta name="robots" content="nofollow">

    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/manifest.json">
    <meta name="theme-color" content="#000000">

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
            color: black;
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
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-fileinput@5.5.4/themes/explorer-fa6/theme.min.css">
</head>
<body>
<div class="banner">
    <div class="container">
        <h1><?= $json_data['title'] ?></h1>
    </div>
</div>
<div class="container">
    <br>
    <p class="lead"><?= $json_data['lead'] ?></p>
    <p><?= $json_data['description'] ?></p>
    <p style="font-size: small"><?= $json_data['description2'] ?></p>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" disabled>
        </div>
        <div class="form-group">
            <label for="files">Upload Photo:</label><br>
            <input id="files" type="file" name="files" multiple accept="image/*,video/*" disabled>
        </div>
    </form>
</div>
<br>
<hr style="width: 80%; margin: auto;">
<br>
<!-- Gallery -->
<div class="container">
    <h2>Gallery</h2>
    <div class="row" id="imageGallery" data-masonry='{"percentPosition": true}'>
        <!-- Images will be loaded here -->
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput@5.5.4/js/fileinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput@5.5.4/themes/explorer-fa6/theme.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script>
    $(document).ready(function () {
        // Run initially after 500ms
        //This will re-layout the images after they've loaded, well constantly check every 1500ms.
        //This is needed for videos to display correctly in the masonry layout after they've loaded.
        setTimeout(function () {
            $('#imageGallery').masonry('layout');
            // Run every 1.5 seconds after the initial run
            setInterval(function () {
                $('#imageGallery').masonry('layout');
            }, 1500);
        }, 500);


        loadimages();
        setInterval(function () {
            loadimages();
        }, 1000);

        var loadedImages = [];

        function loadimages() {
            $.ajax({
                url: 'load_images.php',
                type: 'GET',
                beforeSend: function () {
                    //this will make it flow abit better.
                    $('#imageGallery').masonry('layout');
                },
                success: function (data) {
                    //        $output[] = array(
                    //            'file' => $file,
                    //            'type' => $type,
                    //            'icon' => $icon,
                    //            'timestamp' => $timestamp,
                    //            'userName' => $userName,
                    //            'fileExtension' => $fileExtension);
                    var images = JSON.parse(data);
                    var output = '';
                    $.each(images, function (key, value) {
                        var fileName = value.file;
                        if (!loadedImages.includes(fileName)) {
                            var type = value.type;
                            var fileIcon = value.icon;
                            var timestamp = value.timestamp;
                            var userName = value.userName;
                            var fileExtension = value.fileExtension;
                            html = '<div class="col-lg-4 col-md-4 col-sm-6 col-6">';
                            html += '<div class="image-container position-relative">';
                            if (type === 'video') {
                                html += '<div id="videoContainer_' + fileName + '" class="videoBackground" ondblclick="window.open(\'savedimages/' + fileName + '\', \'_blank\');">';
                                html += '<video class="w-100 shadow-1-strong rounded mb-4" style="border: 1px solid black;" muted autoplay loop>';
                                html += '<source src="savedimages/' + fileName + '" type="video/' + fileExtension + '" onerror="document.getElementById(\'videoContainer_' + fileName + '\').style.display=\'none\'; document.getElementById(\'videoError_' + fileName + '\').style.display=\'block\'">';
                                html += '</video>';
                                html += '</div>';
                                html += '<div id="videoError_' + fileName + '" class="w-100 shadow-1-strong rounded mb-4" style="display: none; color: red; background-color: #333333"><br><br><span style="margin-left: 10px">Your browser does not support the iOS format Videos.</span><div style="margin-left: 10px" class="btn btn-sm btn-success" onclick="window.open(\'savedimages/' + fileName + '\', \'_blank\');"><i class="fa-solid fa-download fa-fw"></i> Download</div><br><br></div>';
                            } else {
                                html += '<img src="savedimages/' + fileName + '" class="w-100 shadow-1-strong rounded mb-4" style="border: 1px solid black;" ondblclick="window.open(\'savedimages/' + fileName + '\', \'_blank\');" alt="Image uploaded by ' + userName + '">';
                            }
                            html += '<div class="user-details">';
                            html += '<i class="' + fileIcon + '"></i>' + userName + '</div>';
                            html += '</div>';
                            html += '</div>';
                            output += html;
                            loadedImages.push(fileName);
                        }
                    });
                    $('#imageGallery').prepend(output).masonry('reloadItems');
                    $('#imageGallery').masonry('layout');
                }
            });
        }


        $("#files").fileinput({
            theme: "explorer-fa6",
            allowedFileTypes: ['image', 'video'],
            uploadUrl: 'upload.php',
            uploadExtraData: function () {
                var name = $('#name').val();
                return {name: name};
            },
            maxFileSize: 81920, // 80 MB limit
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
            loadimages();
            $('#files').fileinput('clear');
        });
    });
</script>

</body>
</html>

