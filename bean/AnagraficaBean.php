<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnagraficaBean {
    
    public $nome;
    public $cognome;
    public $data_nascita;
    public $sesso;
    public $indirizzo;
    public $cap;
    public $localita;
    public $provincia;
    public $tel;
    public $riferimento;
    
    function __construct($nome, $cognome, $data_nascita, $sesso, $indirizzo='', $cap='', $localita='', $provincia='', $tel='', $riferimento='') {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->data_nascita = $data_nascita;
        $this->sesso = $sesso;
        $this->indirizzo = $indirizzo;
        $this->cap = $cap;
        $this->localita = $localita;
        $this->provincia = $provincia;
        $this->tel = $tel;
        $this->riferimento = $riferimento;
    }
    function getNome() {
        return $this->nome;
    }

    function getCognome() {
        return $this->cognome;
    }

    function getData_nascita() {
        return $this->data_nascita;
    }

    function getSesso() {
        return $this->sesso;
    }

    function getIndirizzo() {
        return $this->indirizzo;
    }

    function getCap() {
        return $this->cap;
    }

    function getLocalita() {
        return $this->localita;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getTel() {
        return $this->tel;
    }

    function getRiferimento() {
        return $this->riferimento;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCognome($cognome) {
        $this->cognome = $cognome;
    }

    function setData_nascita($data_nascita) {
        $this->data_nascita = $data_nascita;
    }

    function setSesso($sesso) {
        $this->sesso = $sesso;
    }

    function setIndirizzo($indirizzo) {
        $this->indirizzo = $indirizzo;
    }

    function setCap($cap) {
        $this->cap = $cap;
    }

    function setLocalita($localita) {
        $this->localita = $localita;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setRiferimento($riferimento) {
        $this->riferimento = $riferimento;
    }



}