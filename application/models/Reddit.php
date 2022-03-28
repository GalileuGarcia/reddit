<?php

/**
 * Description of Login_Model
 *
 * @author G4lil3u
 */
class Reddit extends CI_Model{
    
    public function agenda($hora) {
		$this->db->insert('agendamento', array(
			'hora_disparo' => $hora.':00'
		));
	}
	
	public function save($dados) {
        $this->db->insert('postagens', $dados);
    }

	public function periodo($dataInicial, $dataFinal, $ordem) {
		$this->db->where('DATE(data_criacao) BETWEEN DATE("'. $dataInicial. '") and DATE("'. $dataFinal.'")');
		$this->db->order_by($ordem, "DESC");
		return $this->db->get('postagens')->result();
	}

	public function autores($ordem) {
		$this->db->select('autor, comentarios, ups');
		$this->db->order_by($ordem, "DESC");
		return $this->db->get('postagens')->result();
	}

	public function dia() {
		$this->db->where('data = CURDATE()');
		return $this->db->get('log_requisicao')->result();
	}
    
	public function hora() {
		$this->db->select('hora_disparo');
		$this->db->order_by('id_agendamento', "DESC");
		return substr($this->db->get('agendamento')->row_array()['hora_disparo'], 0, -3);

	}

	public function logRequisicao() {
		$this->db->insert('log_requisicao', array(
			'data' => date('Y-m-d')
		));
	}
}
