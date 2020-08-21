<div class="panel-heading"><h1>Criar Notícia</h1></div>
<form action= "<?php echo HOME_URI?>noticia/salvar" method="post">
    <div class="form-row" styles="margin-left:16.66%">
        <div class="form-group col-md-12">
            <input type="text" name="titulo" placeholder="TÍTULO" class="form-control input-lg" required>
        </div>
        <div class="form-group col-md-12">
            <input type="text" name="descricao" placeholder="DESCRIÇÃO" class="form-control input-lg" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <button type="submit"  class="btn btn-primary btn-lg">CRIAR</button>
        </div>
    </div>
</form>