# Guest Photo Wedding Uploader

Welcome to the Guest Photo Wedding Uploader! This is a simple PHP website designed to facilitate the easy uploading of photos and videos for weddings or similar events. Users can upload their media files, which will be saved on the server and made previewable for easy sharing and viewing.

## Features

- **Easy Upload**: Users can easily upload their photos and videos through a simple and intuitive interface.
- **Preview**: Uploaded media files are immediately previewable after upload, allowing users to confirm their uploads.
- **Server-side Storage**: All uploaded media files are securely stored on the server for future access and sharing.
- **HandBrakeCLI Integration**: The `handbrake.sh` script included in this project enables compression and conversion of video files to MP4 format using HandBrakeCLI. This helps in optimizing video files for storage and playback.

## Requirements

- **PHP**: Ensure that your server has PHP installed to run the website.
- **HandBrakeCLI**: If you intend to use the video compression feature, make sure HandBrakeCLI is installed on your server.

## Installation

1. Clone this repository to your server or download and extract the files to your desired location.
2. Make sure the necessary permissions are set to allow PHP to read and write files in the designated upload directory.
3. If you wish to use the video compression feature, ensure that the `handbrake.sh` script has executable permissions (`chmod +x handbrake.sh`).

## Usage

1. Navigate to the directory where you've installed the Guest Photo Wedding Uploader.
2. Access the website through your preferred web browser.
3. Users can upload their photos and videos by following the on-screen instructions.
4. Uploaded media files will be stored in the designated upload directory and made previewable for easy access.

## Troubleshooting

- If you encounter any issues with file uploads or previews, ensure that PHP has the necessary permissions to read and write files in the designated upload directory.
- If you're experiencing problems with video compression, double-check that HandBrakeCLI is properly installed and accessible by the `handbrake.sh` script.

## Contributing

If you'd like to contribute to the Guest Photo Wedding Uploader project, feel free to fork the repository and submit a pull request with your proposed changes.

## HandBrakeCLI cheatlist
Anything with incompatible ram will crash HandBrake
- 1 GB for transcoding standard definition video (480p/576p)
- 2 GB for transcoding high definition video (720p/1080p)
- 6 GB or more for transcoding ultra high definition video (2160p 4K)

Best to let a separate server handle the transcoding, using sshfs to mount the upload directory to the transcoding server.
This will prevent the web server from crashing/lagging due to transcoding.

---

Thank you for using Guest Photo Wedding Uploader! If you have any questions or feedback, please don't hesitate to contact us.
