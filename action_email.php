<?php
$r = array('envio' => false);
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['nome']) && $data['email'] && $data['mensagem']) {
	$nome = utf8_decode(filter_var($data['nome']));
	$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
	$whats = utf8_decode(filter_var($data['whats']));
	$ass = utf8_decode(filter_var($data['ass']));
	$mensagem = utf8_decode(filter_var($data['mensagem']));

	if($email) {
		$emailsender = "webmaster@gallosound.com.br";

		if(PATH_SEPARATOR == ";") {
			$quebra_linha = "\r\n"; //Se for Windows
		} else {
			$quebra_linha = "\n"; //Se "nao for Windows"
		}

		$ip = $_SERVER["REMOTE_ADDR"];
		$dia = date("d-m-Y");
		$hora = date("H:i");


		$emaildestinatario = "contato@gallosound.com.br";
		$assunto = "Formulario de Contato - Site Gallo Sound";

		/* Montando a mensagem a ser enviada no corpo do e-mail. */
		$mensagemHTML = "<b>$assunto</b><br />
						<b>Nome:</b> $nome
						<b>E-mail:</b> $email
						<b>WhatsApp:</b> $whats
						<br /><b>Mensagem:</b> <br />$mensagem<br />
						<hr>
						<b>Informa&ccedil;&otilde;es T&eacute;cnicas</b>
						<i>Dia</i>: $dia
						<i>Hora</i>: $hora			  
						<i>IP do remetente</i>: $ip<br />
						";
		$mensagemHTML = preg_replace("/(\\r)?\\n/i", "<br />", $mensagemHTML);

		$headers = "MIME-Version: 1.1".$quebra_linha;
		$headers .= "Content-type: text/html; charset=UTF-8" .$quebra_linha;
		$headers .= "From: $nome <$email>$quebra_linha";
		$headers .= "Reply-To: " . $email . $quebra_linha;

		if(!mail($emaildestinatario, $assunto, $mensagemHTML, $headers ,"-r".$emailsender)){ // Se for Postfix
		    $headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "não for Postfix"
		    mail($emaildestinatario, $assunto, $mensagemHTML, $headers );
		}

		$r = array('envio' => true, 'email' => true);

		

		echo json_encode($r);
		exit;
	} else {
		$r = array('email' => false);
		echo json_encode($r);
		exit;
	}
}

echo json_encode($r);