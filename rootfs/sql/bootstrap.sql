CREATE USER IF NOT EXISTS 'wpuser'@'localhost';
CREATE DATABASE IF NOT EXISTS wordpress;
GRANT ALL PRIVILEGES ON *.* TO 'wpuser'@'localhost';
