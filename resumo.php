<?php
include('config/bd_conexao.php');

//Verificando se o parametro id foi enviado pelo get
if (isset($_POST['confirmarCompra'])) {

    $meia = $_POST['meia'];
    $inteira = $_POST['inteira'];
    $totalIngressos = intval($meia) + intval($inteira);

    //Limpa a query sql
    $id = mysqli_real_escape_string($conn, $_POST['id_show']);
    $idDS = mysqli_real_escape_string($conn, $_POST['id_datashow']);

    //Monta a query
    $sql_capacidade = "SELECT capacidade FROM datahorashow WHERE id = $idDS";
    $sql = "SELECT * FROM shows WHERE id = $id";
    $dhs = "SELECT * FROM datahorashow WHERE idShow = $id AND id = $idDS";

    //Pega o resultado da query

    $resultCapacidade = mysqli_query($conn, $sql_capacidade);
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $dhs);

    //Busca um unico resultado em formato de vetor   

    $capacidade = mysqli_fetch_assoc($resultCapacidade);
    $show = mysqli_fetch_assoc($result);
    $data =  mysqli_fetch_assoc($result2);


    
    $capacidadeAtualizada = $capacidade["capacidade"] - $totalIngressos;
    $atualizaBanco = " UPDATE datahorashow SET capacidade = $capacidadeAtualizada WHERE id = $idDS";

    if (mysqli_query($conn, $atualizaBanco)) {
        //Sucesso
        header('Location: index.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    mysqli_free_result($resultCapacidade);
    mysqli_close($conn);

    mysqli_free_result($result);
    mysqli_free_result($result2);
    
}

if (isset($_GET['comprar'])) {

    $meia = $_GET['meia'];
    $inteira = $_GET['inteira'];
    $totalIngressos = intval($meia) + intval($inteira);

    //Limpa a query sql
    $id = mysqli_real_escape_string($conn, $_GET['id_show']);
    $idDS = mysqli_real_escape_string($conn, $_GET['id_datashow']);

    //Monta as queries
    $sql = "SELECT * FROM shows WHERE id = $id";
    $dhs = "SELECT * FROM datahorashow WHERE idShow = $id AND id = $idDS";


    //Pega o resultado da query
    $result = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $dhs);

    //Busca um unico resultado em formato de vetor   
    $show = mysqli_fetch_assoc($result);
    $data =  mysqli_fetch_assoc($result2);


    mysqli_free_result($result);
    mysqli_free_result($result2);
  
    mysqli_close($conn);

}

?>


<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="container center">
    <?php if ($show && $data) : ?>
        <h2> Resumo da Compra</h2>

        <h5>Show: <?php echo $show['nome']; ?> </h5>
        <p> </p>

        <h5>Local: <?php echo $show['local']; ?></h5>
        <p></p>

        <h5>Descrição: <?php echo $show['descricao']; ?></h5>
        <p></p>

        <h5>Data: <?php echo date($data['dataHora']); ?></h5>
        <p> </p>

        <h5>Quantidade de Inteiras: <?php echo $inteira; ?></h5>
        <p>R$<?php echo $data['valorIngresso'] * $inteira; ?></p>

        <h5>Quantidade de Meias: <?php echo $meia; ?></h5>
        <p>R$<?php echo ($data['valorIngresso'] / 2) * $meia; ?></p>

        <h5>Preço Total: R$<?php echo $data['valorIngresso'] * $inteira + ($data['valorIngresso'] / 2) * $meia; ?></h5>

        <form action="resumo.php" method="POST">
        <input type="hidden" name="id_show" value="<?php echo $show['id']; ?>">
        <input type="hidden" name="id_datashow" value="<?php echo $data['id']; ?>">  
        <input type="hidden" name="meia" value="<?php echo $meia; ?>">
        <input type="hidden" name="inteira" value="<?php echo $inteira; ?>">  
        <input type="submit" value="Confirmar compra" name="confirmarCompra" class="btn brand z-depth-0">
        </form>

    <?php else : ?>
        <h5>Show não encontrado</h5>
    <?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>