<?php
    /**
     * Classe Notícia
     * Desenvolvida em aulas no Curso Técnico em Informática do CIMOL
     * @author Artur arturkontzm@gmail.com
     * @author Cândido candido.cimol@gmail.com
     * @version 0.1
     * @access public
     * @copyright GPL 2020, Inf63
     * @since 09/07/2020
     */
    class Noticia{
        /**
         * @access private
         * @name id
         */
        private $id;
        /**
         * @access private
         * @name titulo
         */
        private $titulo;
        /**
         * @access private
         * @name descricao
         */
        private $descricao;
        /**
         * @access private
         * @name comentarios
         */
        private $comentarios;
        /**
         * @access private
         * @name data
         */
        private $data;
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
        public function setTitulo($titulo){
            $this->titulo=$titulo;
        }
        
        /**
         * @access public
         * @return String
         */
        public function getTitulo(){
            return $this->titulo;
        }

        /**
         * @access public
         * @param String
         */
        public function setDescricao($descricao){
            $this->descricao=$descricao;
        }
        
        /**
         * @access public
         * @return String
         */
        public function getDescricao(){
            return $this->descricao;
        }

        /**
         * @access public
         * @param String
         */
        public function setComentarios($comentarios){
            $this->comentarios=$comentarios;
        }
        
        /**
         * @access public
         * @return String
         */
        public function getComentarios(){
            return $this->comentarios;
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
         * Método responsável por carregar a página inícial
         * @access public
         * @author Cândido
         * @since 09/07/2020
         */
        public function index(){
            $this->listar();
        }

        /**
         * Método responsável por listar as notícias
         * @access public
         * @author Artur
         * @since 12/08/2020
         * @version 0.2
         */
        public function listar(){
            $mysql=Conexao::getConexao();
            $exibir="SELECT id, titulo, descricao,DATE_FORMAT(data, '%d/%m/%Y') AS data, (SELECT nome FROM usuario 
            WHERE id=noticia.usuario_id) AS nome_usuario FROM noticia ORDER BY id DESC LIMIT 5";
            $resultado=$mysql->query($exibir);
            
            $noticias=null;
            while($noticia=$resultado->fetch(PDO::FETCH_OBJ)){
                $noticias[]=$noticia;
            }
            include HOME_DIR."view/paginas/noticias/noticias.php";
        }

        /**
         * Método responsável por carregar página para criar novas notícias
         * @access public
         * @author Artur
         * @since 12/08/2020
         * @version 0.1
         */
        public  function nova(){
            if(isset($_SESSION['email'])){
                include HOME_DIR."view/paginas/noticias/criar.php";
            }else{
                header("location:index.php");
            }
        }

        /**
         * Método responsável por salvar novas notícias
         * @access public
         * @author Artur
         * @since 12/08/2020
         * @version 0.1
         */
        public  function salvar(){
            $id = $_SESSION['id'];
            $data = date("Y-m-d");
            $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_STRING);
            $descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_STRING);
            
            $mysql = Conexao::getConexao();
            $salvar="INSERT INTO noticia (usuario_id, titulo, descricao, data) VALUES ('$id', '$titulo', '$descricao', '$data')";

            if($mysql->query($salvar)){
                header("location:index");
            }else{
                echo "falha";
                echo "<br>Clique <a href='".HOME_URI."noticia'>aqui</a> para retornar";
                var_dump($id, $data, $titulo, $descricao, $salvar);
            }
        }

        /**
         * Método responsável por carregar as notícias
         * @access public
         * @author Artur
         * @since 12/08/2020
         * @version 0.2
         */
        public  function ver($id){
            $mysql=Conexao::getConexao();
            $carregar= "SELECT id, titulo, descricao,DATE_FORMAT(data, '%d/%m/%Y') AS data,
                (SELECT nome FROM usuario WHERE id=noticia.usuario_id) AS nome_usuario FROM noticia  WHERE id=$id";          
            $resultado=$mysql->query($carregar);
                
        
            if($noticia=$resultado->fetch(PDO::FETCH_OBJ)){
                include HOME_DIR."view/paginas/noticias/noticia.php";
            }else{
                header("location:index");
            }
        }

        /**
         * Método responsável por excluir uma notícia
         * @access public
         * @author Artur
         * @since 19/08/2020
         * @version 0.1
         */
        public  function excluir($id){
            if(isset($_SESSION['email'])){
                $mysql= Conexao::getConexao();
                $excluirC = "DELETE FROM comentario WHERE noticia_id='$id'";
                $excluirN = "DELETE FROM noticia WHERE id='$id'";

                if($mysql->query($excluirC)){
                    if($mysql->query($excluirN)){
                        echo "Sucesso";
                    }else{
                        echo "Falha na operação de apagar notícias";
                        var_dump($id, $excluirN);
                    }
                }else{
                    echo "Falha na operação de apagar comentários";
                    var_dump($id, $excluirC);
                }
                echo "<br>Clique <a href='".HOME_URI."noticia'>aqui</a> para retornar";
            }else{
                header("location:index");
            }
        }

    }
?>