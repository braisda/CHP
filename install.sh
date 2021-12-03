#!/bin/sh
echo "\n	########## INICIANDO INSTALACIÓN 'CHP' ##########"

echo 'El archivo ya existe, no es necesario transferirlo al directorio Apache'

cd /home/pdp
mv CHP.tar /var/www/html/CHP.tar

echo "Desempaquetando archivos..."
tar -xf /var/www/html/CHP.tar -C /var/www/html
rm /var/www/html/CHP.tar
chomd 777 -R /var/www/html/CHP

echo "Configurando base de datos..."
mysql -u root -ppdp -B < /var/www/html/CHP/database.sql

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