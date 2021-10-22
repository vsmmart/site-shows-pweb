<?php
include('config/bd_conexao.php');

$horarios = [];
//Verificando se o parametro id foi enviado pelo get
if (isset($_GET['id'])) {

    //Limpa a query sql
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //Monta a query
    $sql_artista = "SELECT * FROM shows WHERE id = $id;";
    $sql_horarios = "SELECT * FROM datahorashow WHERE idShow = $id;";
    //Pega o resultado da query
    $resultArtista = mysqli_query($conn, $sql_artista);
    $resultHorarios = mysqli_query($conn, $sql_horarios);

    //Busca um unico resultado em formato de vetor
    $show = mysqli_fetch_assoc($resultArtista);
    $show_horario = mysqli_fetch_assoc($resultHorarios);


    while ($row = mysqli_fetch_array($resultHorarios)) {
        array_push($horarios, $row);
    }

    mysqli_free_result($resultArtista);
    // mysqli_free_result($resultHorarios);

    mysqli_close($conn);
}


?>



<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="container center">
    <?php if ($show) : ?>
        <h4> <?php echo $show['nome']; ?></h4>
        <h5>Descricao: </h5>
        <p> <?php echo $show['descricao']; ?></p>
        <h5>Local:</h5>
        <p><?php echo $show['local']; ?></p>
        <h5>Selecione:</h5>

        <div class="input-field col s12"><select>
                <option value="" disabled selected>Choose your option</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select><label>Materialize Select</label>
        </div>


        <select name="horarios" id="ddl">
            <?php

            foreach ($horarios as $h) { ?>

                <option value="x"> <?php "Valor: " . $h['valorIngresso'] . " " . "Data: " . date($h["dataHora"]) . " " . "Nº de Ingressos: " . $h["capacidade"] ?> </option>

            <?php } ?>

        </select>


</div>







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

<?php else : ?>
    <h5>Show não encontrado</h5>
<?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>