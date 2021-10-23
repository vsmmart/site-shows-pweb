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

    //Limpa a query sql
    $id_datahora = mysqli_real_escape_string($conn, $_POST['id']);

    //Montando a query
    $sql = "DELETE FROM datahorashow WHERE id = $id_datahora";

    //Removendo do banco
    if (mysqli_query($conn, $sql)) {

        //Sucesso
        header('Location: index.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
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

                    <select name="cars" id="cars">
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select>

                    <div class="card-action">
                        <a class="brand-text" href="detalhes.php?id=<?php echo $datahora['id'] ?>">Editar</a>
                        <a type="submit" name="delete" value="Remover" href="detalhes.php?id=<?php echo $datahora['id'] ?>">Excluir</a>
                    </div>
                </ul>
            <?php } ?>
        </div>

    <?php else : ?>
        <h5>Show não encontrado</h5>
    <?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>