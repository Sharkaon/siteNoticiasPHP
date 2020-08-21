<div class="panel-heading"><h1>Cadastrar</h1></div>
<form action= "<?php echo HOME_URI?>usuario/validarCadastro" method="post">
    
    <div class="form-row">
        <div class="form-group col-md-6">
            <input type="email" name="email" placeholder="E-MAIL" class="form-control input-lg" required>
        </div>

        <div class="form-group col-md-6">
            <input type="name" name="nome" placeholder="NOME" class="form-control input-lg" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary btn-lg" name="cadastrar" value="cadastrar">CADASTRAR</button>
        </div>
    </div>
</form>