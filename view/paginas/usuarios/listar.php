<div class="panel-heading"><h1>Usuários</h1></div>

<?php 
if(isset($_SESSION['email'])){
?>

<div class="panel-heading" style="font-size:18px"><p>Deseja sair? Clique <a href="<?php echo HOME_URI;?>usuario/logout">aqui</a></p></div>

<a href="<?php echo HOME_URI;?>usuario/criar" class="btn">ADD</a>

<table class="table">
<thead>
    <tr><td>#</td><td>Nome</td><td>Email</td><td></td></tr>
    <?php
        $mysql = Conexao::getConexao();
        if($mysql){
            $resultado=$mysql->query("SELECT id, nome, email FROM usuario");
            while($usuario=$resultado->fetch(PDO::FETCH_ASSOC)){
    ?>

    <tr>
    <td><?php echo $usuario["id"]; ?></td>
    <td><?php echo $usuario["nome"]; ?></td>
    <td><?php echo $usuario["email"]; ?></td>

        <td><a href="<?php echo HOME_URI;?>usuario/apagar/<?php echo $usuario['id']?>">
            <button type="button" class="btn btn-danger"><i class='fas fa-window-close'></i></button>
        </a></td>

        <td><a href="<?php echo HOME_URI;?>usuario/alterar/<?php echo $usuario['id']?>">
            <button type="button" class="btn btn-info"><i class='fas fa-edit'></i></button> 
        </a></td>
        
    </tr>

    <?php
            }
        }
    ?>
</thead>

</table>
<?php
    }else{
        header("location:".HOME_URI."usuario/autenticar");
    }
?>