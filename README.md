instalar dependencias que serão usadas pelo bot

```shell apt-get install php -y && apt-get install php-curl -y && apt-get install php-ssh2 -y && apt-get install redis -y && apt-get install php-redis -y && apt-get install screen -y```

baixando arquivo usado pra criar usuarios ssh
```shell wget https://www.dropbox.com/s/j9bpk6m27egkwkp/gerarusuario-sshplus.sh?dl=0 -O gerarusuario.sh; chmod +x gerarusuario.sh```

cria a pasta bot e entra nela
```shell mkdir bot && cd bot```

baixa o codigo do bot e extrai na pasta bot
```shell wget https://github.com/httd1/admysshbot/raw/master/%40admysshbot.zip -O bot.zip && unzip bot.php > /dev/null```

* Após baixar o codigo do bot entre na pasta bot e edite o arquivo bot.php colocando token do bot ip, usuario root e senha do servidor

abre outra janela nessa pasta
```shell screen -S bot```

inicia o bot nessa janela
```shell php bot.php```

sai da janela criada
```shell Ctrl+a d```
