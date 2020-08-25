<?php
/**
 * Classe Comentario
 * Desenvolvida em aulas no Curso Técnico em Informática do CIMOL
 * @author Artur arturkontzm@gmail.com
 * @author Cândido candido.cimol@gmail.com
 * @version 0.1
 * @access public
 * @copyright GPL 2020, Inf63
 * @since 09/07/2020
*/
class Comentario{
    /**
     * @access private
     * @name id
    */ 
    private $id;

    /**
     * @access private
     * @name comentario
    */ 
    private $comentario;
    
    /**
     * @access private
     * @name data
    */ 
    private $data;
    
    /**
     * @access private
     * @name noticia
    */ 
    private $noticia;
    
    /**
     * @access private
     * @name usuario
    */ 
    private $usuario;

    /**
     * @access public
     * @param int
    */ 
    public function setId($id){
        $this->id=$id;
    }
    
    /**
     * @access public
     * @return int
    */ 
    public function getId(){
        return $this->id;
    }

    /**
     * @access public
     * @param String
    */
    public function setComentario($comentario){
        $this->comentario=$comentario;
    }
    
    /**
     * @access public
     * @return String
    */ 
    public function getComentario(){
        return $this->comentario;
    }

    /**
     * @access public
     * @param String
    */
    public function setData($data){
        $this->data=$data;
    }
    
    /**
     * @access public
     * @return String
    */
    public function getData(){
        return $this->data;
    }

    /**
     * @access public
     * @param String
    */
    public function setNoticia($noticia){
        $this->noticia=$noticia;
    }
    
    /**
     * @access public
     * @return String
    */
    public function getNoticia(){
        return $this->noticia;
    }

    /**
     * @access public
     * @param String
    */
    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    
    /**
     * @access public
     * @return String
    */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * Método responsável por criar um novo comentário
     * @access public
     * @author Artur
     * @since 12/08/2020
     * @version 0.1
    */
    public function criar($noticia){
        $comentario = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);

        if(isset($_SESSION['nome'])){
            $nome=$_SESSION['nome'];
        }else{
            $nome="ANÔNIMO";
        }

        $mysql = Conexao::getConexao();
        $adicionar = "INSERT INTO comentario (comentario, nome, noticia_id) VALUES ('$comentario', '$nome', '$noticia')";

        if($mysql->query($adicionar)){
            header("location:".HOME_URI."noticia/ver/".$noticia);
        }else{
            echo "Erro<br>Clique <a href='".HOME_URI."noticia/ver/$noticia'>aqui</a> para retornar";
        }
    }

    /**
     * Método responsável por listar os comentários
     * @access public
     * @author Artur
     * @since 19/08/2020
     * @version 0.1
    */
    public function listar($noticia){
        $mysql=Conexao::getConexao();
        $exibir="SELECT id, comentario, nome FROM comentario 
        WHERE noticia_id='$noticia' ORDER BY id DESC";
            
        $resultado=$mysql->query($exibir);

        $comentarios=null;
        while($comentario=$resultado->fetch(PDO::FETCH_OBJ)){
            $comentarios[]=$comentario;
        }

        return $comentarios;
    }
    
    /**
     * Método responsável por listar os comentários
     * @access public
     * @author Artur
     * @since 21/08/2020
     * @version 0.2
    */
    public  function apagar($id, $noticia, $nome){
        if(isset($_SESSION['email'])){
            if($nome==$_SESSION['nome']){

                $mysql= Conexao::getConexao();
                $excluir = "DELETE FROM comentario WHERE id='$id'";
                
                if($mysql->query($excluir)){
                    
                    header("location:".HOME_URI."noticia/ver/$noticia");
                }else{
                    echo "Falha na operação";
                    echo "<br>Clique <a href='".HOME_URI."noticia/ver/$noticia'>aqui</a> para retornar";
                }
                echo "Esse não é seu comentário!";
                echo "<br>Clique <a href='".HOME_URI."noticia/ver/$noticia'>aqui</a> para retornar";
            }
        }else{
            header("location:index");
        }
    }
}