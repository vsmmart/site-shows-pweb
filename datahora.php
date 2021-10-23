<?php
include('config/bd_conexao.php');

$datahorashow = [];
$data = '';
$valorIngresso = $capacidade = 0;
$erros = array('data' => '', 'valorIngresso' => '', 'capacidade' => '');

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

    $id_datahora = mysqli_real_escape_string($conn, $_POST['id']);


    $id_show = mysqli_real_escape_string($conn, $_POST['idShow']);
    //Montando a query
    $sql = "DELETE FROM datahorashow WHERE id = $id_datahora";

    //Removendo do banco
    if (mysqli_query($conn, $sql)) {

        //Sucesso
        header("Location: datahora.php?id=$id_show");
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}

//Remove o show do BD
if (isset($_POST['edit'])) {

    echo $_POST['dataHora'];

    echo $_POST['valorIngresso'];

    echo $_POST['capacidade'];  
}

if (isset($_POST['enviar'])) {

    $id_show = mysqli_real_escape_string($conn, $_POST['id']);

    //Verificar a data do evento 
    if (empty($_POST['data'])) {
        $erros['data'] = 'A data do evento é obrigatório';
    } else {
        $data = $_POST['data'];
    }
    //Verificar valor do ingresso
    if ($_POST['valorIngresso'] <= 0) {
        $erros['valorIngresso'] = 'O valor do Ingresso deve ser informado';
    } else {
        $valorIngresso = $_POST['valorIngresso'];
    }

    if ($_POST['capacidade'] <= 0) {
        $erros['capacidade'] = 'A capacidade deve ser informada';
    } else {
        $capacidade = $_POST['capacidade'];
    }


    if (array_filter($erros)) {
        //echo 'Erro no formulário';
    } else {
        //Limpando codigos suspeitos
        $data = mysqli_real_escape_string($conn, $_POST['data']);
        $valorIngresso = mysqli_real_escape_string($conn, $_POST['valorIngresso']);
        $capacidade = mysqli_real_escape_string($conn, $_POST['capacidade']);
        //Criando a query
        $sql = "INSERT INTO datahorashow(dataHora,  valorIngresso, capacidade, idShow) VALUES('$data',$valorIngresso ,$capacidade, $id_show)";

        //Salva no banco de dados
        if (mysqli_query($conn, $sql)) {
            //Sucesso
            header('Location: index.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    function SetarDados($idvalue, $idShowvalue, $capacidadevalue,$dataHoravalue,  )
    {
        $data = $dataHoravalue;
        $capacidade = $capacidadevalue;
        echo $capacidadevalue;
    }
}
?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="container center">
    <?php if ($show) : ?>
        <h4> <?php echo $show['nome']; ?></h4>
        <h5>local </h5>
        <p> <?php echo $show['local']; ?></p>
        <h5>Descrição</h5>
        <p><?php echo $show['descricao'] . $id; ?></p>

        <div>
            <form class="white" action="datahora.php" method="POST">

                <label>Data</label>
                <input type="date" name="data" value="<?php echo date($data) ?>">

                <label>Valor Ingresso</label>
                <input type="text" name="valorIngresso" value="<?php echo $valorIngresso ?>">

                <label>Capacidade</label>
                <input type="number" name="capacidade" value="<?php echo $capacidade ?>">


                <form action="datahora.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                    <input type="submit" name="enviar" value="Cadastrar" class="btn brand z-depth-0">
                </form>
            </form>
        </div>

        <div>

            <?php
            foreach ($datahorashow as $datahora) { ?>
                <ul>
                    <li> <?php echo "Capacidade: " . $datahora['capacidade'] . "</br>"; ?> </li>
                    <li> <?php echo "Data e Hora: " . $datahora['dataHora'] . "</br>"; ?></li>
                    <li> <?php echo "Valor: " . $datahora['valorIngresso'] . "</br>"; ?></li>

                    <form style="display: flex; justify-content: space-between;" action="datahora.php" method="POST">
                        <div>
                            <input type="hidden" name="id" value="<?php echo $datahora['id']; ?>">
                            <input type="hidden" name="idShow" value="<?php echo $datahora['idShow']; ?>">
                            <input type="submit" name="delete" value="Remover" class="btn brand z-depth-0">
                        </div>
                        <div>
                            <input type="hidden" name="id" value="<?php echo $datahora['id']; ?>">
                            <input type="hidden" name="idShow" value="<?php echo $datahora['idShow']; ?>">
                            <input type="hidden" name="capacidade" value="<?php echo $datahora['capacidade']; ?>">
                            <input type="hidden" name="dataHora" value="<?php echo $datahora['dataHora']; ?>">
                            <input type="hidden" name="valorIngresso" value="<?php echo $datahora['valorIngresso']; ?>">
                            <input type="button" name="edit" value="Editar" onclick="SetarDados($datahora['id'], $datahora['idShow'], $datahora['capacidade'], $datahora['dataHora'])" class="btn brand z-depth-0">
                        </div>
                    </form>

                </ul>
            <?php } ?>
        </div>

    <?php else : ?>
        <h5>Show não encontrado</h5>
    <?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>