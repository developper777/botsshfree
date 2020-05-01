<?php

// Bot criado por @httd1 código original para o @ysshadmbot

date_default_timezone_set ('America/Sao_Paulo'); // define timestamp padrão

// Incluindo arquivos nescessários
include __DIR__.'/Telegram.php';
include __DIR__.'/conexaoSSH.php';

define ('TOKEN', '<TOKEN BOT>'); // token do bot criado no @botfather

define ('LIMITE', 100); // limite de contas

// informações para acessar o servidor
define ('SERVIDOR', '<IP SERVIDOR>');
define ('USUARIO_SERVIDOR', '<USUARIO>');
define ('SENHA_SERVIDOR', '<SENHA SERVIDOR>');

// Instancia das classes
$tlg=new Telegram (TOKEN);

$redis=new Redis ();
$redis->connect ('localhost', 6379); //redis usando porta padrão

$ssh=new conexaoSSH (SERVIDOR, USUARIO_SERVIDOR, SENHA_SERVIDOR); //realiza conexão com o servidor por ssh

// BLOCO USADO EM LONG POLLING

while (true){

$updates=$tlg->getUpdates();

for ($i=0; $i < $tlg->UpdateCount(); $i++){

$tlg->serveUpdate($i);

switch ($tlg->Text ()){

	case '/start':

	$tlg->sendMessage ([
		'chat_id' => $tlg->ChatID (),
		'text' => '😀 Para comprar sua SSH/EHI de 30 dias BR use o nosso bot de vendas @YellowSSHBot, você também pode ganhar uma renda extra com o nosso Painel de Revenda',
		'parse_mode' => 'html',
		'reply_markup' => $tlg->buildInlineKeyBoard ([
			[$tlg->buildInlineKeyboardButton ('Comprar SSH EHI', 'https://t.me/YellowSSHBot')],
			[$tlg->buildInlineKeyboardButton ('🇧🇷 SSH Gratis BR 🇧🇷', null, '/sshgratis')],
			[$tlg->buildInlineKeyboardButton ('Painel Revenda', 'https://t.me/yellowssh/5772')]
		])
	]);

	break;
	case '/sobre':

	$tlg->sendMessage ([
		'chat_id' => $tlg->ChatID (),
		'text' => 'Bot original @admysshbot por @httd1'
	]);

	break;
	case '/sshgratis':

	$tlg->answerCallbackQuery ([
	'callback_query_id' => $tlg->Callback_ID()
	]);

	if ($redis->dbSize () == LIMITE){

		$textoSSH='👽 Atingimos o limite de contas por hoje volte amanhã :)';

	} elseif ($redis->exists ($tlg->UserID ())){

		$textoSSH='🙃 Você já criou uma conta SSH hoje volte amanhã :)';

	} else {

		$usuario=substr (str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
		$senha=mt_rand(11111, 999999);

		$ssh->exec ('./criarusuario.sh '.$usuario.' '.$senha.' 1 1');

		$textoSSH="🇧🇷 Conta SSH criada ;)\r\n\r\n<b>Servidor:</b> <code>".SERVIDOR."</code>\r\n<b>Usuario:</b> <code>".$usuario."</code>\r\n<b>Senha:</b> <code>".$senha."</code>\r\n<b>Logins:</b> 1\r\n<b>Validade:</b> ".date ('d/m', strtotime('+1 day'))."\r\n\r\n🤙 Cortesia do @YellowSSHBot";

		$redis->setex ($tlg->UserID (), 86400, 'true'); //define registro para ser guardado por 24h

	}

	$tlg->sendMessage ([
		'chat_id' => $tlg->ChatID (),
		'text' => $textoSSH,
		'parse_mode' => 'html',
		'reply_markup' => $tlg->buildInlineKeyBoard ([
			[$tlg->buildInlineKeyboardButton ('Comprar SSH EHI', 'https://t.me/YellowSSHBot')],
			[$tlg->buildInlineKeyboardButton ('Painel Revenda', 'https://t.me/yellowssh/5772')]
		])
	]);

	break;

}

}}