<?php


class EventoAbstract{
	
	protected $connessione;

	protected $id;
	protected $dataEn;
	protected $dataIt;
	protected $ora;
	protected $tipo;
	protected $descrizione;
	protected $rif_dett;
        protected $rif_table;
	protected $data;


	public function __construct($connessione, $id){
		$this->connessione = $connessione;

		$this->id = $id;

		$res = mysqli_query($this->connessione, "select t_evento.*, date(data_evento) as data_ev, time(data_evento) as ora_evento from t_evento where id='".$id."' ");
		while($row = mysqli_fetch_array($res)){
			$this->dataEn = ($row['data_ev']);
			$this->dataIt = dataEn2It($row['data_ev']);
			$this->descrizione = $row['descrizione'];
			$this->ora = substr($row['ora_evento'], 0, 5);
			$this->tipo = $row['tipo_evento'];
			$this->rif_dett = $row['rif_dett'];
                        $this->rif_table = $row['rif_table'];
		}
	}

	function getOraEvento(){
		return $this->ora;
	}
	function getSottoDescrizione(){
		return $this->rif_dett;
	}

	function getDivEvento(){
		$str_event = '';
		
		$str_event .= '<div id="'.$this->id.'" class="cal_event draggable event_type_'.$this->tipo.'" draggable="true" ondragstart="drag(event)">';
		$str_event .= '<div>';
		$str_event .= '<span style="font-weight:bold">'.$this->getOraEvento().'</span> '.$this->descrizione;
		$str_event .= '</div>';
		$str_event .= '<div class="event_subdescription" style="display:none">';
		$str_event .= '<span style="font-weight:italic;" >'.$this->getSottoDescrizione().'</span> ';
		$str_event .= '</div>';
		$str_event .= '</div>';
		
		return $str_event;
	}
	
}



?>