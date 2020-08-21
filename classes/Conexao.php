<?php
class Conexao {

    private static $conexao=null;

    static public function getConexao(){
        if(!self::$conexao){
            self::$conexao= new PDO (SGBD.":host=".HOST_DB.";dbname=".DB."",USER_DB, PASS_DB);
        }
        return self::$conexao;
    }

}