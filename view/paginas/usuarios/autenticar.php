<?php
    if(!isset($_SESSION["email"])){
?>
<div class="panel-heading"><h1>Usuários</h1></div>
<form action= <?php echo(HOME_URI."usuario/validar")?> method="post" id="autenticar">
    <div class="form-row">
        <div class="form-group col-md-6">
            <input type="email" name="email" placeholder="E-MAIL" class="form-control" required></input>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <input type="password" name="senha" placeholder="SENHA" class="form-control" required></input>
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-2">
            <button type="submit" name="autenticar" value="autenticar" class="btn btn-primary">AUTENTICAR</button>
        </div>
    </div>
    
</form>

<?php
}else{
    header("location:".HOME_URI."usuario");
}
?>