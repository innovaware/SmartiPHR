<?php

class Calendar {

    private $connessione;

    public function __construct($conn) {
        $this->connessione = $conn;
    }

    function getInizioSettimanaDaData($data_corrente) {
        $unixTimestamp = strtotime($data_corrente);
        $dayOfWeek = date("N", $unixTimestamp);
        if ($dayOfWeek == 7)
            return $data_corrente;
        $week_start = date('Y-m-d', strtotime($data_corrente . ' -' . $dayOfWeek . ' days'));
        //partire da lunedi
        //$week_start = date('Y-m-d', strtotime($data_corrente.' -'.($dayOfWeek-1).' days'));
        return $week_start;
    }

    function numeroGiornoInSettimana($data_corrente) {
        $unixTimestamp = strtotime($data_corrente);
        $dayOfWeek = date("N", $unixTimestamp);

        return 1 + ($dayOfWeek % 7);
    }

    function ultimoGiornoMeseDaDataInizio($inizioMese) {
        $numeroGiorniMeseCorrente = cal_days_in_month(CAL_GREGORIAN, (int) substr($inizioMese, 5, 2), (int) substr($inizioMese, 0, 4));
        return date('Y-m-d', strtotime($inizioMese . ' + ' . ($numeroGiorniMeseCorrente - 1) . ' days'));
    }

    function numeroGiorniMeseDaDataInizio($inizioMese) {
        return cal_days_in_month(CAL_GREGORIAN, (int) substr($inizioMese, 5, 2), (int) substr($inizioMese, 0, 4));
    }

    function getArrayEventiGiornalieri($data) {
        return $this->getArrayEventi($data, $data);
    }

    function getArrayEventi($data_inizio, $data_fine) {
        $res = mysqli_query($this->connessione, "select * from t_evento where date(data_evento)>='" . $data_inizio . "' and date(data_evento)<='" . $data_fine . "' order by data_evento ");

        $array_eventi = array();
        while ($row = mysqli_fetch_array($res)) {
            $data_evento = substr($row['data_evento'], 0, 10);

            $array_temp = isset($array_eventi[$data_evento]) ? $array_eventi[$data_evento] : array();
            //array_push($array_temp, $row['descrizione']);
            $array_temp[$row['id']] = $row['descrizione'];
            $array_eventi[$data_evento] = $array_temp;
        }

        return $array_eventi;
    }

    function retrieveVistaMese($inizioMese) {

        require_once('EventoBean.php');
        $fineMese = $this->ultimoGiornoMeseDaDataInizio($inizioMese);
        $numeroGiorniMeseCorrente = $this->numeroGiorniMeseDaDataInizio($inizioMese);


        $inizioCalendario = $this->getInizioSettimanaDaData($inizioMese);
        $scartoMP = $this->numeroGiornoInSettimana($inizioMese);
        $scartoMS = ($this->numeroGiornoInSettimana($fineMese) == 0) ? 0 : 7 - $this->numeroGiornoInSettimana($fineMese);


        $str_result = '';
        //$str_result .= '<table class="table">';
        $str_result .= '<div>';

        $str_result .= '<div style="float:left;"  class="btn-group" role="group" >';
        $str_result .= '<button id="btn_mese_prec" class="btn btn-secondary btn_sel_mese" data-incdec="-1" data-mese="' . substr($inizioMese, 5, 2) . '" data-anno="' . substr($inizioMese, 0, 4) . '"><</button>';
        $str_result .= '<button id="btn_mese_succ" class="btn btn-secondary btn_sel_mese" data-incdec="1" data-mese="' . substr($inizioMese, 5, 2) . '" data-anno="' . substr($inizioMese, 0, 4) . '">></button>';
        $str_result .= '</div>';
        $str_result .= '<button id="btn_settimana" class="btn btn-secondary btn_vista_settimana" data-inizio_mese="' . $inizioMese . '" >Week</button>';
        $str_result .= '<div>';

        $str_result .= '</div>';

        $str_result .= '<div style="float:left; width:400px" >';
        $str_result .= '<h2>' . $this->getNomeMeseFromNumero(substr($inizioMese, 5, 2)) . ' ' . substr($inizioMese, 0, 4) . '</h2>';
        $str_result .= '</div>';
        $str_result .= '</div>';
        $str_result .= '<div style="clear:both"></div>';
        $str_result .= '<table class="table_mese">';
        $str_result .= '<tr>';
        $str_result .= '<td><div class="cal_head">' . 'Dom' . '</div></td>';
        $str_result .= '<td><div class="cal_head">' . 'Lun' . '</div></td>';
        $str_result .= '<td><div class="cal_head">' . 'Mar' . '</div></td>';
        $str_result .= '<td><div class="cal_head">' . 'Mer' . '</div></td>';
        $str_result .= '<td><div class="cal_head">' . 'Gio' . '</div></td>';
        $str_result .= '<td><div class="cal_head">' . 'Ven' . '</div></td>';
        $str_result .= '<td><div class="cal_head">' . 'Sab' . '</div></td>';
        $str_result .= '</tr>';
        $str_result .= '<tr>';

        for ($i = 1; $i < ($numeroGiorniMeseCorrente + $scartoMP + $scartoMS ); $i++) {
            $color_text = ( (($i) % 7 ) == 1 ) ? 'red' : 'black';

            $data = date('Y-m-d', strtotime($inizioCalendario . ' + ' . ($i - 1) . ' days'));
            $disabled = (substr($data, 5, 2) != substr($inizioMese, 5, 2)) ? ' disabled ' : '';

            $str_result .= '<td class="cal_day ' . $disabled . '">';
            $str_result .= '<div style="color:' . $color_text . '" data-data_evento="' . $data . '" class="label_day" data-toggle="modal" data-target="#modal_inserisci_evento">' . substr(dataEn2It($data), 0, 2) . '</div>';
            $str_result .= '<div id="cont_' . $i . '" class="container_event droppable" tipo_cont="mese" data_evento="' . $data . '" ora_evento="99:99" ondrop="drop(event)" ondragover="allowDrop(event)" >';

            $array_eventi = $this->getArrayEventiGiornalieri($data);

            if (isset($array_eventi[$data])) {
                foreach ($array_eventi[$data] as $key => $value) {
                    $evento = new Evento($this->connessione, $key);
                    $str_result .= $evento->getDivEvento($key, $value);
                }
            }
            $str_result .= '</div>';

            $str_result .= '</td>';

            if ((($i) % 7 ) == 0) {
                $str_result .= '</tr>';
                $str_result .= '<tr>';
            }
        }
        $str_result .= '</tr>';
        $str_result .= '</table>';
        return $str_result;
    }

    function retrieveVistaSettimana($data) {
        require_once 'EventoBean.php';

        $inizioCalendario = $this->getInizioSettimanaDaData($data);

        $inizioCalendarioPrec = date('Y-m-d', strtotime($inizioCalendario . ' - 7 days'));
        $inizioCalendarioSucc = date('Y-m-d', strtotime($inizioCalendario . ' + 7 days'));

        $str_result = '';
        $str_result .= '<div id="div_vista_settimana">';
        $str_result .= '<div id="div_settimana_navbar" >';
        $str_result .= '<button id="btn_sett_prec" class="btn btn-secondary btn_sel_sett" data-data_arrivo="' . $inizioCalendarioPrec . '" >Prec</button>';
        $str_result .= '<button id="btn_sett_succ" class="btn btn-secondary btn_sel_sett" data-data_arrivo="' . $inizioCalendarioSucc . '" >Succ</button>';
        $str_result .= '<button id="btn_mese" class="btn btn-secondary  " data-inizio_mese="' . $data . '" >Mese</button>';
        $str_result .= '<button class="btn btn-primary" data-toggle="modal" data-target="#modal_inserisci_evento">Inserisci appuntamento</button>';
        $str_result .= '</div>';
        $str_result .= '<div style="margin-left:400px;"><h2>Dal ' . dataEn2It(date('d-m-Y', strtotime($inizioCalendarioSucc . ' - 7 days'))) . ' al ' . dataEn2It(date('d-m-Y', strtotime($inizioCalendarioSucc . ' - 1 days'))) . '</h2></div>';
        $str_result .= '<div class="div_container_vista" style="margin-top:10px;">';
        $str_result .= $this->retrieveVistaGiornoHeader($inizioCalendarioPrec, $inizioCalendarioSucc);
        for ($i = 0; $i < 7; $i++) {
            $data_corrente = date('Y-m-d', strtotime($inizioCalendario . ' + ' . ($i) . ' days'));
            //echo $data_corrente;
            $str_result .= $this->retrieveVistaGiorno($data_corrente, $inizioCalendarioPrec, $inizioCalendarioSucc);
        }
        $str_result .= '</div>';
        $str_result .= '<div style="clear:both"></div>';
        $str_result .= '</div>';
        return $str_result;
    }

    function retrieveVistaGiorno($data, $data_inizio = '', $data_fine = '') {
        require_once 'EventoBean.php';

        $str_result = '';
        $str_result .= '<div class="div_vista_giorno "  >';
        $str_result .= '<div class="label_day_sett " data-toggle="modal" data-target="#modal_inserisci_evento" data-data_evento="' . $data . '" style="font-weight:bold">' . $this->retrieveIntestazioneVistaGiorno($data) . '</div>';
        $array_orari = $this->retrieveOreOccupateInSettimana($data_inizio, $data_fine);
        //for ($i = 0; $i < 24; $i++) {
        //$ora_corrente = ($i < 10) ? '0' . $i : $i;
        //$ora_corrente .= ':00';

        foreach ($array_orari as $i => $value) {
            $ora_corrente = $i . ':00';

            $str_result .= '<div id="cont_' . $data . $i . '" class="container_event droppable container_vista_settimana"  tipo_cont="settimana" data_evento="' . $data . '" ora_evento="' . $ora_corrente . '" ondrop="drop(event)" ondragover="allowDrop(event)">';

            $ora_successiva = ($i < 10) ? '0' . ($i + 1) : $i + 1;
            $ora_successiva .= ':00';
            $array = $this->retrieveEventiPerOra($data, $ora_corrente, $ora_successiva);
            //print_r($array);
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $evento = new Evento($this->connessione, $key);
                    $str_result .= $evento->getDivEvento($key, $value);
                    //$str_result .= '<div>'.$value.'</div>' ;		
                    //echo $value;
                }
            }
            $str_result .= '</div>';
        }
        $str_result .= '</div>';
        return $str_result;
    }

    function retrieveOreOccupateInSettimana($data_inizio, $data_fine) {
        $res = mysqli_query($this->connessione, " SELECT TIME(data_evento), DATE_FORMAT(data_evento, '%H')AS ora from t_evento where date(data_evento)>='" . $data_inizio . "' and date(data_evento)<='" . $data_fine . "' order by data_evento");
        //echo  " SELECT TIME(data_evento), DATE_FORMAT(data_evento, '%H')AS ora from t_evento where date(data_evento)>='" . $data_inizio . "' and date(data_evento)<='" . $data_fine . "' ";
        $array_orari = array();
        while ($row = mysqli_fetch_array($res)) {
            $array_orari[$row['ora']] = $row['ora'];
        }
        return $array_orari;
    }

    function retrieveIntestazioneVistaGiorno($data) {
        $giorno = date('D', strtotime($data));
        if ($giorno == 'Sun')
            $giorno = 'Dom';
        if ($giorno == 'Mon')
            $giorno = 'Lun';
        if ($giorno == 'Tue')
            $giorno = 'Mar';
        if ($giorno == 'Wed')
            $giorno = 'Mer';
        if ($giorno == 'Thu')
            $giorno = 'Gio';
        if ($giorno == 'Fri')
            $giorno = 'Ven';
        if ($giorno == 'Sat')
            $giorno = 'Sab';
        return '<div style="float:right">' . date('d', strtotime($data)) . ' ' . $this->getNomeMeseFromNumero(date('m', strtotime($data))) . '</div><div style="clear:both"></div><div id="div_giorno_intestazione" style="float:left;width:100px;margin-left:40%"> ' . $giorno . ' </div>';
        ;
    }

    function retrieveVistaGiornoHeader($data_inizio = '', $data_fine = '') {

        $str_result = '';
        $str_result .= '<div class="div_vista_giorno"> <div style="height:50px"></div> ';
        $array_orari = $this->retrieveOreOccupateInSettimana($data_inizio, $data_fine);
        //for ($i = 0; $i < 24; $i++) {
        //$ora_corrente = ($i < 10) ? '0' . $i : $i;
        //$ora_corrente .= ':00';

        foreach ($array_orari as $i => $value) {
            $ora_corrente = $i . ':00';

            $str_result .= '<div class="div_vista_ora">';
            //$ora_corrente = ($i < 10) ? '0' . $i : $i;
            //$ora_corrente .= ':00';

            $str_result .= $ora_corrente;
            $str_result .= '</div>';
        }
        $str_result .= '</div>';
        return $str_result;
    }

    function retrieveEventiPerOra($data_corrente, $ora_corrente, $ora_successiva) {


        $query = " SELECT * FROM t_evento WHERE DATE(data_evento)='" . $data_corrente . "' AND TIME (data_evento)>='" . $ora_corrente . "' AND TIME(data_evento) < '" . ($ora_successiva) . "' order by data_evento ";
        $res = mysqli_query($this->connessione, $query);
        //echo $query;

        $array_eventi_ora = array();
        while ($row = mysqli_fetch_array($res)) {
            $array_eventi_ora[$row['id']] = $row['descrizione'];
        }

        return $array_eventi_ora;
    }

    function getNomeMeseFromNumero($numero) {
        if ($numero == '01')
            return 'Gennaio';
        if ($numero == '02')
            return 'Febbraio';
        if ($numero == '03')
            return 'Marzo';
        if ($numero == '04')
            return 'Aprile';
        if ($numero == '05')
            return 'Maggio';
        if ($numero == '06')
            return 'Giugno';
        if ($numero == '07')
            return 'Luglio';
        if ($numero == '08')
            return 'Agosto';
        if ($numero == '09')
            return 'Settembre';
        if ($numero == '10')
            return 'Ottobre';
        if ($numero == '11')
            return 'Novembre';
        if ($numero == '12')
            return 'Dicembre';
    }

}
