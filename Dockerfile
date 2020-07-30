# Create image based on the Skaffolder PHP image
FROM skaffolder/php-base

# Copy source files
WORKDIR /var/www/html/api 
COPY . /var/www/html/api
