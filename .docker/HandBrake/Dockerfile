FROM ubuntu:latest

# Install HandBrake CLI and other dependencies
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y handbrake-cli util-linux && \
    # If needed, install specific NVIDIA library or remove if unnecessary
    apt-get install -y libnvidia-encode-550 && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /data

# Default command to keep the container running
# Copy the handbrake.sh script into the container
COPY handbrake.sh /data/handbrake.sh

# Make the script executable
RUN chmod +x /data/handbrake.sh

# Run handbrake.sh in a loop
CMD while true; do flock -n /tmp/wedphoto.lockfile /data/handbrake.sh; sleep 60; done