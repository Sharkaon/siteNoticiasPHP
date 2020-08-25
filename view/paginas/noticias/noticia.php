<div class="panel-heading"><h1>Notícias</h1></div>
<div class="panel panel-primary">

    
    <div class="panel-heading"><h1><?php echo $noticia->titulo ?></h1></div>
    <div class="coments">
        <p class="coment-user"><?php echo $noticia->descricao?></P>
    </div>

    <div class='data'>
        <span class="label label-primary"><?php echo $noticia->data ?></span>
        <span class="label label-primary"><?php echo "Por:".$noticia->nome_usuario ?></span>
    </div>
  
</div>

<div class="panel panel-primary">

    
        <div class="panel-heading">
            <h5 class="panel-title">Comentarios</h5>
        </div>

        <form class="form" action="<?php echo HOME_URI?>comentario/criar/<?php echo $noticia->id?>" method="post">  
            <div class="form-group">
                <input type="text" name="comment" class="form-control input-lg" placeholder="Adicione um comentário">
                <div class="input-form">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>

        <?php
            include HOME_DIR."classes/Comentario.php";

            $com = new Comentario();
            $comentarios=$com->listar($noticia->id);

            if($comentarios){
                foreach($comentarios as $comentario){
        ?>
        <div class="coments">
            <p class="nome-user"><?php echo $comentario->nome?></p>
            <p class="coment-user"><?php echo $comentario->comentario?> </p>
        <?php
        if(isset($_SESSION['nome'])){
            if($comentario->nome==$_SESSION['nome']){
        ?>
                <a href="<?php echo HOME_URI; ?>comentario/apagar/<?php echo $comentario->id ?>/<?php echo $noticia->id ?>/<?php echo $comentario->nome ?>">
                    <button type="button" class="btn btn-danger"><i class='fas fa-window-close'></i></button>
                </a>
        <?php
            }
        }
        ?>
        </div>

        <?php
                }
            }
        ?>

    </div>

</div>