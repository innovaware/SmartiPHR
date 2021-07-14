<?php

require_once('EventoAbstractBean.php');

class Evento extends EventoAbstract {

    public function getSottoDescrizione() {
        $str_res = '';
        if (isset($this->rif_table) && isset($this->rif_dett)) {

            if ($this->rif_table == 'farm') {
                $result = mysqli_query($this->connessione, " SELECT farm.nome nome_farmaco, paziente.cognome, paziente.nome
                FROM  t_farmaco farm, t_magazzino_farmaci mag LEFT OUTER JOIN t_anagrafica paziente ON paziente.id = mag.id_paziente
                WHERE mag.id ='" . $this->rif_dett . "'
                AND mag.id_farmaco = farm.id");
                while ($row = mysqli_fetch_array($result)) {
                    $str_res .= $row['nome_farmaco'] . '<br>';
                    $str_res .= $row['nome'] . ' ' . $row['cognome'];
                }
            } else if ($this->rif_table <> '' && $this->rif_dett <> '') {
                $result = mysqli_query($this->connessione, " SELECT * 
                    FROM t_cartella_" . $this->rif_table . "_dett dett, t_cartella_" . $this->rif_table . "_mast mast , t_anagrafica anag
                    WHERE 
                    mast.id_anag = anag.id
                    AND dett.id_cartella = mast.id 
                    AND dett.id = '" . $this->rif_dett . "' 
                        
                    "
                );
                while ($row = mysqli_fetch_array($result)) {
                    $str_res .= $row['nome'] . ' ' . $row['cognome'] . '<br>';
                    $str_res .= $row['diario_clinico'];
                }
            }
        }

        return $str_res;
    }

}

?>