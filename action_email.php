<?php
$r = array('envio' => false);

print_r($_POST);

if(isset($_POST['nome']) && $_POST['email'] && $_POST['mensagem']) {
	$nome = filter_var($_POST['nome']);
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$ass = filter_var($_POST['ass']);
	$mensagem = filter_var($_POST['mensagem']);

	$para = "contato@gallosound.com.br";
	$assunto = 'Email Formulario Site Gallo Sound';
	$corpo = "Nome:".$nome."\r\n Assunto:".$ass."\r\n E-mail:".$email."\r\n Mensagem: ".$mensagem;
	$cabecalho = "From: contato@gallosound.com.br"."\r\n".
				"Replay-To: ".$email."\r\n".
				"X-Mailer: PHP/".phpversion();
	mail($para, $assunto, $corpo, $cabeçalho);

	$r = array('envio' => true);

	echo json_encode($r);
	exit;
}

echo json_encode($r);