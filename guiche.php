<?php
    include('config/bd_conexao.php');
    
    //Verificando se o parametro id foi enviado pelo get
    if(isset($_GET['id'])){
        
        //Limpa a query sql
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        //Monta a query
        $sqlartista = "SELECT * FROM shows WHERE shows.id = $id";
        $sqlhorarios = "SELECT dataHora FROM datahorashow WHERE datahorashow.idshow = $id";
        //Pega o resultado da query
        $resultartista = mysqli_query($conn, $sqlartista);
        $resulthorarios = mysqli_query($conn,$sqlhorarios);

        //Busca um unico resultado em formato de vetor
        $show = mysqli_fetch_assoc($resultartista);
        $show_horario = mysqli_fetch_assoc($resulthorarios);

        mysqli_free_result($resultartista);
        mysqli_free_result($resulthorarios);

        mysqli_close($conn);
        
    }
    //Remove o show do BD
    // if(isset($_POST['delete'])){

    //     //Limpa a query sql
    //     $id_show = mysqli_real_escape_string($conn, $_POST['id']);

    //     //Montando a query
    //     $sql = "DELETE FROM shows WHERE id = $id_show";

    //     //Removendo do banco
    //     if(mysqli_query($conn, $sql)){

    //         //Sucesso
    //         header('Location: index.php');
    //     } else{
    //         echo 'query error: '.mysqli_error($conn);
    //     }
    // }
 
?>



<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>

    <div class="container center">
        <?php if($show): ?>
            <h4> <?php echo $show['nome']; ?></h4>
            <h5>Descricao: </h5>
            <p> <?php echo $show['descricao']; ?></p>
            <h5>Data:</h5>           
            <p><?php echo date($show_horario['dataHora']); ?></p>
            <h5>Local:</h5>
            <p><?php echo $show['local']; ?></p>
            <h5>Preço:</h5>
            <p>R$<?php echo $show_horario['valorIngresso']; ?></p>

            
            <!-- Formulario de Edição -->
            <form action="editar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                <input type="submit" name="editar" value="Editar" class="btn brand z-depth-0">
            </form>
            


            <!-- Formulario de Remoção -->
            <!-- <form action="detalhes.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                <input type="submit" name="delete" value="Remover" class="btn brand z-depth-0">
            </form> -->

        <?php else: ?>
            <h5>Show não encontrado</h5>    
        <?php endif ?>
    </div>
    
    <?php include('templates/footer.php'); ?>

</html>