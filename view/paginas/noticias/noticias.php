<div class="panel-heading"><h1>Notícias</h1></div>

<?php
    if(isset($_SESSION["email"])){
?>

    <div class="panel-heading"><a href="<?php echo HOME_URI ?>noticia/nova"><button  class="btn btn-primary btn-lg">Criar nova notícia</button></a></div>

<?php
    }
?>

<?php
if(isset($noticias)){
    foreach($noticias AS $noticia){
?>
    <div class="panel panel-primary">
        <div class="panel-heading"><h2><?php echo $noticia->titulo ?></h2></div>

        <div class="coments">
        <?php echo substr($noticia->descricao,0,180)."..." ?><a href="<?php echo HOME_URI."noticia/ver/".$noticia->id;?>">Ler mais</a>
        </div>

        <div class='data'><span class="label label-primary"><?php echo $noticia->data ?></span>
        <span class="label label-primary"><?php echo "Por:".$noticia->nome_usuario ?></span>
        <a href="<?php echo HOME_URI;?>noticia/excluir/<?php echo $noticia->id?>">
            <button type="button" class="btn btn-danger"><i class='fas fa-window-close'></i></button>
        </a>
        </div>        
    </div>
<?php
    }
}
?>