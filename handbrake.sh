#!/bin/bash

# Directory paths
originalVideoDir="original_videos/"
uploadDir="savedimages/"
backupDir="original_backups/"
# Create backup directory if it doesn't exist
mkdir -p "$backupDir"

# Loop through all files in the original video directory
for file in $originalVideoDir*; do
    if [ -f "$file" ]; then
        # Get the file extension
        fileExtension="${file##*.}"

        # Check if the file is a video file
        if [ "$fileExtension" == "mov" ] || [ "$fileExtension" == "mp4" ] || [ "$fileExtension" == "avi" ] || [ "$fileExtension" == "webm" ] || [ "$fileExtension" == "mkv" ]; then
            # Convert the video file using HandBrakeCLI
            convertedFileName=$(basename "$file" ."$fileExtension").mp4
            convertedFilePath="$uploadDir$convertedFileName"
            HandBrakeCLI -i "$file" -o "$convertedFilePath" --preset="Very Fast 720p30"

            # Remove the original video file after conversion
            mv "$file" "$backupDir"
        fi
    fi
done
