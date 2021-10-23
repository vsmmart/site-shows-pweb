<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>
<?php
 if(isset($_FILES['pic']))
 {
    $ext = strtolower(substr($_FILES['pic']['name'],-4)); //Pegando extensão do arquivo
    $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
    $dir = './images/'; //Diretório para uploads 
    move_uploaded_file($_FILES['pic']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo
    echo("Imagen enviada com sucesso!");
 } 
?>


<div class ="container">
    <form method="POST" enctype="multipart/form-data"> 
        <label for="conteudo">Enviar imagem:</label>
        <input type="file" name="pic" accept="images/*"><br>    
            <button type="submit">Enviar imagem</button>
    </form>
</div>
<?php include('templates/footer.php'); ?>

</html>