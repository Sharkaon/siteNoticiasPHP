<?php
    /**
     * Classe Usuário
     * Desenvolvida em aulas no Curso Técnico em Informática do CIMOL
     * @author Artur arturkontzm@gmail.com
     * @version 0.1
     * @access public
     * @copyright GPL 2020, Inf63
     * @since 09/07/2020
     */
class Usuario{
    /**
     * @access private
     * @name id
    */ 
    private $id;
    
    /**
     * @access private
     * @name nome
    */ 
    private $nome;
    
    /**
     * @access private
     * @name email
    */ 
    private $email;
    
    /**
     * @access private
     * @name senha
    */ 
    private $senha;
    
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
    public function setNome($nome){
        $this->nome=$nome;
    }
    
    /**
     * @access public
     * @return String
    */ 
    public function getNome(){
        return $this->nome;
    }
    
    /**
     * @access public
     * @param String
    */
    public function setEmail($email){
        $this->email=$email;
    }
    
    /**
     * @access public
     * @return String
    */
    public function getEmail(){
        return $this->email;
    }
    
    /**
     * @access public
     * @param String
    */
    public function setSenha($senha){
        $this->senha=$senha;
    }
    
    /**
     * @access public
     * @return String
    */
    public function getSenha(){
        return $this->senha;
    }

    /**
     * Responsável por carregar a página índice adequada
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.2
     */
    public function index(){
        if(isset($_SESSION["email"])){
            $this->listar();
        }else{
            $this->autenticar();
        }   
    }

    /**
     * Responsável por carregar a página de lista de usuários
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function listar(){
        include HOME_DIR."view/paginas/usuarios/listar.php";
    }

    /**
     * Responsável por carregar a página de criação de cadastro
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function criar(){
        include HOME_DIR."view/paginas/usuarios/cadastrar.php";
    }

    /**
     * Responsável por carregar a página de autenticação
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function autenticar(){
        include HOME_DIR."view/paginas/usuarios/autenticar.php";
    }

    /**
     * Responsável por carregar a página de alteração de senha
     * @access public
     * @author Artur
     * @since 08/08/2020
     * @version 0.1
     */
    public function alterarSenha(){
        include HOME_DIR."view/paginas/usuarios/alterarSenha.php";
    }

    /**
     * Responsável por carregar a página de alteração de dados
     * @access public
     * @author Artur
     * @since 08/08/2020
     * @version 0.1
     */
    public function alterar($id){
        echo("Alterar dados do usuário #$id");
        include HOME_DIR."view/paginas/usuarios/alterar.php";
    }

    /**
     * Responsável por realizar o logout
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function logout(){
        unset($_SESSION["email"]);
        unset($_SESSION["nome"]);
        unset($_SESSION["id"]);
        header("location: ".HOME_URI."usuario");
    }

    /**
     * Responsável por validar um cadastro
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function validarCadastro(){
        $repeated=false;
        //Setar varíaveis
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $nome = filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mysql= Conexao::getConexao();
            if($mysql){
                // Pegar os emails cadastrados e armazenar em um vetor
                $resultado=$mysql->query("SELECT email FROM usuario");

                while($emailBD=$resultado->fetch(PDO::FETCH_ASSOC)){
                    // Comparar o email informado com o vetor
                    if($emailBD['email']==$email){
                        $repeated=true;
                    }
                }
                if($repeated==false){
                    // Senão, salvar o email
                    $this->criarCadastro($nome, $email);
                }
                if($repeated==true){
                    echo("Email já cadastrado. Clique <a href='".HOME_URI."usuario'>aqui</a> para retornar.");
                }
            }else{
                echo("Erro na conexão");
            }
        }
    }

    /**
     * Responsável por criar o cadastro
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function criarCadastro($nome, $email){
        $senha=md5('123');//Senha padrão

        //Operações no banco
        $mysql= Conexao::getConexao();
        $inserir = "INSERT INTO usuario (id, nome, email, senha) VALUES (0, '$nome', '$email', '$senha')";
        if($mysql->query($inserir)){
            $this->index(); 
        }
        else{
            echo("Erro no cadastro. Clique <a href='".HOME_URI."usuario'>aqui</a> para retornar.");
        }
    }

    /**
     * Responsável por validar um login
     * @access public
     * @author Artur
     * @since 05/08/2020
     * @version 0.1
     */
    public function validar(){
        //Setar variáveis
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
        $senha = md5($senha);
        //Executa apenas se o email for válido
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mysql= Conexao::getConexao();

            if($mysql){
                //Operações no banco
                $sql=$mysql->query("SELECT id, nome, email, senha FROM usuario WHERE email='$email'AND senha='$senha'");
                $resultado=$sql->fetch(PDO::FETCH_ASSOC);
                if($resultado){
                    $_SESSION["nome"]=$resultado["nome"];
                    $_SESSION["email"]=$resultado["email"];
                    $_SESSION["id"]=$resultado["id"];
                }else{
                    echo "Email ou Senha incorretos<br>
                    Clique <a href='".HOME_URI."usuario'>aqui</a> para retornar";
                }
                

                //Checar se a senha é a padrão
                if($resultado["senha"]==md5('123')){
                    header("location: ".HOME_URI."usuario/alterarSenha");
                }else if (isset($resultado["email"])){
                    header("location: ".HOME_URI."usuario");
                }

            }
        }
    }

    /**
     * Responsável por alterar a senha do usuário
     * @access public
     * @author Artur
     * @since 08/08/2020
     * @version 0.1
     */
    public function alterarPassword(){
        //Setar variáveis
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
        $senha=md5($senha);
        $email=$_SESSION["email"];

        //Checar se senha é válida
        if($senha!='123'){
            //Operações no banco
            $mysql=Conexao::getConexao();
            $alterar = "UPDATE usuario SET senha = '$senha' where email='$email'";
            if($mysql->query($alterar)){
                $this->index();
            }else{
                echo("Falha");
            }
        }else{
            echo ("Senha inválida.<br/>");
            include HOME_DIR."view/paginas/usuarios/alterarSenha.php";
        }
    }

    /**
     * Responsável por apagar um usuário
     * @access public
     * @author Artur
     * @since 08/08/2020
     * @version 0.1
     */
    public function apagar($id){
        $mysql= Conexao::getConexao();
        $deletar = "DELETE FROM usuario WHERE id=$id";

        if($mysql->query($deletar)){
            echo "Usuário Deletado";
        }else{
            echo "Falha na operação";
        }
        echo "<br>Clique <a href='".HOME_URI."usuario'>aqui</a> para retornar";
    }

    /**
     * Responsável por alterar os dados de um usuário
     * @access public
     * @author Artur
     * @since 08/08/2020
     * @version 0.1
     */
    public function alterarDados($id){
        //Setar variáveis
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        
        $mysql= Conexao::getConexao();
        $alterar = "UPDATE usuario SET email = '$email', nome='$nome' where id='$id'";

        if($mysql->query($alterar)){
            echo "Usuário Alterado";
        }else{
            echo "Falha na operação";
        }
        echo "<br>Clique <a href='".HOME_URI."usuario'>aqui</a> para retornar";
    }
}