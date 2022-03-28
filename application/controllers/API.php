<?php

/**
 * Description of Postagem
 *
 * @author G4lil3u
 */
class API extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function agendaTarefa() {

		ispost();

		$hora = $this->input->post('hora', TRUE);

		if (empty($hora)) {
			json_output(400, array('status' => 400, 'mensagem' => 'Um ou mais parametros nao foram informados'));
		}

		if (validaHora($hora) == true) {
			$agenda = $this->reddit->agenda($hora);
			json_output(200, array('status' => 200, 'mensagem' => 'Agendamento realizado com sucesso. A requisicao podera ser feita as '.$hora));
		} else {
			json_output(400, array('status' => 400, 'mensagem' => 'Um ou mais parametros nao foram informados corretamente'));
		}
	}

	public function index()
	{
		isget();

		$horaDisparo = $this->reddit->hora();
		
		horaAgendada($horaDisparo);
		
		$validaDiaPostagem = $this->reddit->dia();

		if (!empty($validaDiaPostagem)) {
			json_output(400, array('status' => 400, 'mensagem' => 'A requisicao ja foi realizada hoje. Volte amanha'));
		}

		$user_agent = $this->agent->agent_string();

		$url = 'https://api.reddit.com/r/artificial/hot';
		$return = curl($url, $user_agent);
		$resp = json_decode($return);
		$dados = $resp->data->children;
		foreach ($dados as $reddit) {

			$bd = [
				'titulo' => $reddit->data->title,
				'autor'  => $reddit->data->author,
				'ups'    => $reddit->data->ups,
				'comentarios' => $reddit->data->num_comments
			];

			
			$this->reddit->save($bd);
		}
		
		$this->reddit->logRequisicao();

		json_output(200, array('status' => 200, 'mensagem' => 'Dados salvos com sucesso'));
	}

	public function postagemPorPeriodo()
	{
		isget();

		$dataInicial = $this->input->get('datainicial', TRUE);
		$dataFinal = $this->input->get('datafinal', TRUE);
		$ordem = $this->input->get('ordem', TRUE);

		if (empty($dataInicial) || empty($dataFinal) || empty($ordem)) {
			json_output(400, array('status' => 400, 'mensagem' => 'Um ou mais parametros nao foram informados'));
		} else {

			if ((validaData($dataInicial) == true && validaData($dataFinal) == true) && ($ordem == 'ups' || $ordem == 'comentarios')) {
				$result = $this->reddit->periodo($dataInicial, $dataFinal, $ordem);
				json_output(200, array('dados' => $result));
			} else {
				json_output(400, array('status' => 400, 'mensagem' => 'Um ou mais parametros nao foram informados corretamente'));
			}
		}
	}

	public function autores()
	{
		isget();

		$ordem = $this->input->get('ordem', TRUE);

		if (!empty($ordem)) {
			if ($ordem == 'ups' || $ordem == 'comentarios') {
				$result = $this->reddit->autores($ordem);
				json_output(200, array('dados' => $result));
			} else {
				json_output(400, array('status' => 400, 'mensagem' => 'Um ou mais parametros nao foram informados corretamente'));
			}
		} else {
			json_output(400, array('status' => 400, 'mensagem' => 'Um ou mais parametros nao foram informados'));
		}
	}
}
