#!/bin/bash
sudo apt-get update && sudo apt-get upgrade -y
sudo apt-get install -y php php-curl php-mysql php-mbstring composer
composer install