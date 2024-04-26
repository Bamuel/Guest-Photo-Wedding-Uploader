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
    <title><?= $json_data['title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
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
    <p class="lead">Hello all you lovely people, we are collecting photos that people took at our wedding, so if you have pictures please add them here!</p>
    <p>Please add your name, so we know who they have come from. Upload your pictures with the file picker below! (you can add multiple pictures at the same time)</p>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="photo">Upload Photo:</label><br>
            <input id="files" type="file" name="files" multiple accept="image/*,video/*">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="fileinput/fileinput.min.js"></script>
<script src="fileinput/themes/explorer-fa6/theme.min.js"></script>
<script>
    $(document).ready(function () {
        $("#files").fileinput({
            theme: "explorer-fa6",
            uploadUrl: "upload.php",
            allowedFileTypes: ['image', 'video'],

            showRemove: false,
            showUpload: false,
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
            dropZoneEnabled: false,

        });
    });
</script>

</body>
</html>

