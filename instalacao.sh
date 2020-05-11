echo "Instalando dependencias..."

apt-get install php -y > /dev/null
apt-get install php-curl -y > /dev/null
apt-get install php-ssh2 -y > /dev/null
apt-get install redis -y > /dev/null
apt-get install php-redis -y > /dev/null
apt-get install screen -y > /dev/null
apt-get install zip -y > /dev/null

mkdir bot && cd bot

wget https://www.dropbox.com/s/j9bpk6m27egkwkp/gerarusuario-sshplus.sh?dl=0 -O gerarusuario.sh; chmod +x gerarusuario.sh > /dev/null

wget https://github.com/httd1/admysshbot/raw/master/%40admysshbot.zip -O bot.zip && unzip bot.zip > /dev/null

rm dadosBot.ini > /dev/null

clear

ip=$(hostname -I)

echo "Digite o toke do seu bot:"
read token
echo "Digite o nome de usuario do seu servidor (tem que ser usúario root):"
read user
echo "Digite a senha do seu servidor:"
read senha
echo "ip=$ip
token=$token
usuario=$user
senha=$senha
limite=100" >> dadosBot.ini

screen -dmS bot php bot.php

echo "Pronto, o bot esta executando em segundo plano
Bot por @httd1"
