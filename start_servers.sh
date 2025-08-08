#!/bin/bash
# Mata qualquer processo na porta 8000
sudo kill -9  2> /dev/null

# Inicia o MySQL
sudo service mysql start

# Inicia o servidor PHP
php -S localhost:8000 -t frontend/
