<?php
include('config/bd_conexao.php');

$datahorashow = [];

//Verificando se o parametro id foi enviado pelo get
if (isset($_GET['id'])) {

    //Limpa a query sql
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //Monta a query
    $sql = "SELECT * FROM shows WHERE id = $id;";
    //Pega o resultado da query
    $result = mysqli_query($conn, $sql);
    $show = mysqli_fetch_assoc($result);


    $datas = "SELECT * FROM datahorashow WHERE idShow = $id;";
    $resultData = mysqli_query($conn, $datas);


    while ($row = mysqli_fetch_array($resultData)) {
        array_push($datahorashow, $row);
    }


    //Busca um unico resultado em formato de vetor



    mysqli_free_result($result);
    mysqli_close($conn);
}
//Remove o show do BD
if (isset($_POST['delete'])) {

    //Limpa a query sql
    $id_show = mysqli_real_escape_string($conn, $_POST['id']);

    //Montando a query
    $sql = "DELETE FROM shows WHERE id = $id_show";

    //Removendo do banco
    if (mysqli_query($conn, $sql)) {

        //Sucesso
        header('Location: index.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
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
    <?php if ($show) : ?>
        <h4> <?php echo $show['nome']; ?></h4>
        <h5>local: </h5>
        <p> <?php echo $show['local']; ?></p>
        <h5>Descrição:</h5>
        <p><?php echo $show['descricao']; ?></p>

        <div>
            <?php
            foreach ($datahorashow as $datahora) { ?>
                <ul>
                    <li>  <?php echo "Capacidade: ".$datahora['capacidade']."</br>"; ?> </li>
                    <li> <?php echo "Data e Hora: ".$datahora['dataHora']."</br>"; ?></li>
                    <li> <?php echo "Valor: ".$datahora['valorIngresso']."</br>"; ?></li>
                </ul>
            <?php } ?>
        </div>        

    <?php else : ?>
        <h5>Show não encontrado</h5>
    <?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>