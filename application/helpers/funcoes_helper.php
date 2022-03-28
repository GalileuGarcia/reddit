<?php

function json_output($statusHeader, $response)
{
	header("Content-Type: application/json");
	http_response_code($statusHeader);
	echo json_encode($response);
	exit();
}

function ispost()
{
	$metodo = $_SERVER['REQUEST_METHOD'];
	if ($metodo != 'POST') {
		json_output(400, array('status' => 400, 'mensagem' => 'Bad Request.'));
	}
}

function isget()
{
	$metodo = $_SERVER['REQUEST_METHOD'];
	if ($metodo != 'GET') {
		json_output(400, array('status' => 400, 'mensagem' => 'Bad Request.'));
	}
}

function validaData($date, $format = 'Y-m-d')
{

	$d = DateTime::createFromFormat($format, $date);

	return $d && $d->format($format) == $date;
}

function curl($url, $user_agent)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
	$result = curl_exec($curl);
	curl_close($curl);

	return $result;
}

function validaHora($time, $format = 'H:i') {
	$d = DateTime::createFromFormat($format, $time);

	return $d && $d->format($format) == $time;
}

function horaAgendada($horaDisparo) {
	$tempo = new DateTime();  
	$horaAtual = $tempo->format("H:i");

	if ($horaDisparo !== $horaAtual) {
		json_output(400, array('status' => 400, 'mensagem' => 'A requisicao nao pode ser processada nesse horario'));
	} 
}
