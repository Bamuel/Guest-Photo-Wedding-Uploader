FROM ubuntu:latest

# Install Apache and other dependencies
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php && \
    apt-get clean

# Start Apache in the foreground
CMD ["apachectl", "-D", "FOREGROUND"]