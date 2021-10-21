<?php
    include('config/bd_conexao.php');
    
    //Verificando se o parametro id foi enviado pelo get
    if(isset($_GET['id'])){
        
        //Limpa a query sql
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        //Monta a query
        $sql = "SELECT * FROM shows WHERE id = $id";

        //Pega o resultado da query
        $result = mysqli_query($conn, $sql);

        //Busca um unico resultado em formato de vetor
        $show = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
        
    }
    //Remove o show do BD
    if(isset($_POST['delete'])){

        //Limpa a query sql
        $id_show = mysqli_real_escape_string($conn, $_POST['id']);

        //Montando a query
        $sql = "DELETE FROM shows WHERE id = $id_show";

        //Removendo do banco
        if(mysqli_query($conn, $sql)){

            //Sucesso
            header('Location: index.php');
        } else{
            echo 'query error: '.mysqli_error($conn);
        }
    }
  /*  if(isset($_POST['edit'])){
        $id_pizza = mysqli_real_escape_string($conn, $_POST['id_pizza']);
        $sql = "UPDATE pizza SET WHERE id = $id_pizza";

    }*/
?>



<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>

    <div class="container center">
        <?php if($show): ?>
            <h4> <?php echo $show['artista']; ?></h4>
            <h5>Data: </h5>
            <p> <?php echo date($show['data']); ?></p>
            <h5>Local:</h5>
            <p><?php echo $show['local']; ?></p>
            <h5>Quantidade de Ingressos:</h5>
            <p><?php echo $show['ingressos']; ?></p>
            <h5>Preço:</h5>
            <p>R$<?php echo $show['preco']; ?></p>

            
            <!-- Formulario de Edição -->
            <form action="editar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                <input type="submit" name="editar" value="Editar" class="btn brand z-depth-0">
            </form>
            


            <!-- Formulario de Remoção -->
            <form action="detalhes.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                <input type="submit" name="delete" value="Remover" class="btn brand z-depth-0">
            </form>

        <?php else: ?>
            <h5>Show não encontrado</h5>    
        <?php endif ?>
    </div>
    
    <?php include('templates/footer.php'); ?>

</html>