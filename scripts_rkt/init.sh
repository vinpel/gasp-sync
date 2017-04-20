#!/bin/bash

#apk add --no-cache git
# Add scrypt function
apk add --no-cache php7-libsodium@testing

PATH=$PATH:/data/htdocs
KEY_PATH=/data/htdocs/console/runtime/ssl

if [ ! -d ${KEY_PATH} ];then
    mkdir -p ${KEY_PATH}
fi
#Create if not exist certificate self signed
if [ ! -f ${KEY_PATH}/apache.crt ];then
  echo "## Creating apache ssl key : ${KEY_PATH}/apache.crt"
#  apk add --no-cache openssl
    cd ${KEY_PATH}
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
     -keyout ${KEY_PATH}/apache.key \
     -out    ${KEY_PATH}/apache.crt \
     -subj "/C=FR/ST=Paris/L=Paris/O=Apache SelfSigned Key/OU=IT Department/CN=127.0.0.1"
fi
#Mise en place du virtualhost

# Suppression de la config par defaut
rm /etc/apache2/conf.d/conteneur.conf
# Mise en place de la configuration SSL
cp /data/htdocs/scripts_rkt/ssl.conf /etc/apache2/conf.d/ssl.conf
sed -i -e 's/<<PORT>>/443/g' /etc/apache2/conf.d/ssl.conf
sed -i -e 's/<<KEY_PATH>>/\/data\/htdocs\/ssl/g' /etc/apache2/conf.d/ssl.conf
sed -i -e 's/<<DOCUMENT_ROOT>>/\/data\/htdocs\/frontend\/web/g' /etc/apache2/conf.d/ssl.conf


#sed -i -e 's/<<DOCUMENT_ROOT>>/\/data\/htdocs\/\/web\//g' /etc/apache2/conf.d/frontend.conf
