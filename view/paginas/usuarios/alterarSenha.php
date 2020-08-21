<p>A conta está com a senha padrão. Por favor insira uma nova senha.</p>

<form action="<?php echo HOME_URI;?>usuario/alterarPassword" method="POST">
    <input type="password" name="senha" placeholder="Nova Senha" required/>

    <button type="submit" name="alterar">ALTERAR</button>
</form>