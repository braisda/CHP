#!/bin/sh
echo "\n	########## INICIANDO INSTALACIÓN 'CHP' ##########"
echo "\nCambiando directorio a /var/www/html..."
cd /var/www/html
rm -R CHP
echo "\nDescargando 'CHP'...\n"
git clone "https://github.com/braisda/CHP.git"

chmod 777 -R /var/www/html/CHP

apt-get update
apt-get install poppler-utils

echo "Configurando base de datos..."
mysql -uroot -ppdp < /var/www/html/CHP/database.sql

echo "\n"
echo " _____  _   _ ______   _            ______  _____ ____________" 
echo "/  __ \| | | || ___ \ | |           | ___ \/  __ \| ___ \  _  \\"
echo "| /  \/| |_| || |_/ / | |__  _   _  | |_/ /| /  \/| |_/ / | | |"
echo "| |    |  _  ||  __/  | '_ \| | | | | ___ \| |    | ___ \ | | |"
echo "| \__/\| | | || |     | |_) | |_| | | |_/ /| \__/\| |_/ / |/ /"
echo " \____/\_| |_/\_|     |_.__/ \__, | \____/  \____/\____/|___/"
echo "                              __/ |"
echo "                             |___/"
echo "\n	########## INSTALACIÓN FINALIZADA  ##########"
echo "\nAcceda a la aplicación con su navegador desde: 'ip_servidor/CHP'"
echo "\n"