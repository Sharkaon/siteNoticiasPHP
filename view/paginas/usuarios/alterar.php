<form action="<?php echo HOME_URI;?>usuario/alterarDados/<?php echo $id ?>" method="POST">
    <input type="email" name="email" placeholder="Novo Email" required/>
    <input type="name" name="nome" placeholder="Nova Nome" required/>

    <button type="submit" name="alterar">ALTERAR</button>
</form>