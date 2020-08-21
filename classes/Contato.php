<?php

class Contato{
    public function index(){
        $this->exibir();
    }

    public function exibir(){
        include HOME_DIR."view\paginas\contatos.php";
    }
}