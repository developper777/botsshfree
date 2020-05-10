<?php

/*
*
** @author httd1 <t.me/httd1>
** @admYSSHBot
*
*/

class conexaoSSH {
	
	function __construct ($host, $usuario, $senha, $porta=22){
		
		$this->conexao=ssh2_connect ($host, $porta);

		$this->status=ssh2_auth_password ($this->conexao, $usuario, $senha);
		
		}
		
	public function exec ($comando){
		
		$stream=ssh2_exec ($this->conexao, $comando);
		
		stream_set_blocking ($stream, true);
		
		$ret=trim (stream_get_contents($stream));
		
		return $ret;
		
		}

	public function status (){

		return $this->status;
		
	}
	
	}