<?php

include('config/bd_conexao.php');

//query para buscar
$sql = 'SELECT nome, local, descricao, id FROM shows ORDER BY nome';

//resultado como um conjunto de linhas
$result = mysqli_query($conn, $sql);

//busca a query
$shows = mysqli_fetch_all($result, MYSQLI_ASSOC);

//limpa a memória de $result
mysqli_free_result($result);

//fechar conexão
mysqli_close($conn);

// if (isset($_POST['filtrar'])) {

    
//     $data = mysqli_real_escape_string($conn, $_POST['data']);
//     //Montando a query
//     $sql = "SELECT DISTINCT id FROM datahorashow WHERE dataHora = $data";

//     $result = mysqli_query($conn, $sql);

//     //busca a query
//     $ids = mysqli_fetch_all($result, MYSQLI_ASSOC);

//     echo var_dump($ids);

//     //Removendo do banco
//     if (mysqli_query($conn, $sql)) {

//         //Sucesso
//         header('Location: index.php');
//     } else {
//         echo 'query error: ' . mysqli_error($conn);
//     }
// }

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>
<?php if(isset($shows)){ ?>
<h4 class="center grey-text">Eventos</h4>
<div class="w3-content" style="max-width:1200px">
  <img class="mySlides" src="images/racionais.jpg" style="width:100%;display:none">
  <img class="mySlides" src="images/slipknot.jpg" style="width:100%">
  <img class="mySlides" src="images/racanegra.jpg" style="width:100%;display:none">

  <div class="w3-row-padding w3-section">
    <div class="w3-col s4">
      <img class="demo w3-opacity w3-hover-opacity-off" src="images/racionais.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(1)">
    </div>
    <div class="w3-col s4">
      <img class="demo w3-opacity w3-hover-opacity-off" src="images/slipknot.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(2)">
    </div>
    <div class="w3-col s4">
      <img class="demo w3-opacity w3-hover-opacity-off" src="images/racanegra.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(3)">
    </div>
  </div>
</div>

<script>
function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";
}
</script>

<div class ="container">
    <div class="row">
        <?php foreach($shows as $show){ ?>
            <div class ="col s6 md3">
                <div class="card z-depth-0 teste">
                    <div class="card-content center">
                        <h6><?php echo htmlspecialchars($show['nome']);?> </h6>

                        <ul class="grey-text">
                           
<?php if (isset($shows)) { ?>
    <h4 class="center grey-text">Shows Disponíveis</h4>
    <div class="container">
        <form class="white" action="index.php" method="POST">

            <label>Data</label>

            <form action="index.php" method="POST">
                <input type="date" name="data" value="<?php echo date($data) ?>">

                <input type="submit" name="filtrar" value="Filtrar" class="btn brand z-depth-0">
            </form>
        </form>
        <div class="row">
            <?php foreach ($shows as $show) { ?>
                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($show['nome']); ?> </h6>

                            <ul class="grey-text">

                                <li> <?php echo htmlspecialchars($show['local']); ?></li>
                                <li> <?php echo htmlspecialchars($show['descricao']); ?></li>


                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="card-action">
                                <a class="brand-text" href="datahora.php?id=<?php echo $show['id'] ?>">Cadastrar Data/hora</a>
                            </div>
                            <div class="card-action">
                                <a class="brand-text" href="detalhes.php?id=<?php echo $show['id'] ?>">Mais informações</a>
                            </div>
                        </div>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
<?php } else { ?>
    <h4 class="center grey-text">Nenhum Show Disponível</h4>
<?php } ?>
<?php include('templates/footer.php'); ?>

</html>