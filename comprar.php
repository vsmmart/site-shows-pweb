<?php 

include('config/bd_conexao.php');

    //query para buscar
    $sql = 'SELECT nome, local, descricao, id FROM shows ORDER BY nome';

    //resultado como um conjunto de linhas
    $result = mysqli_query($conn,$sql);

    //busca a query
    $shows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //limpa a memória de $result
    mysqli_free_result($result);

    //fechar conexão
    mysqli_close($conn);


?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>
<?php if(isset($shows)){ ?>
<h4 class="center grey-text">Shows Disponíveis para Compra de Ingresso</h4>
<div class ="container">
    <div class="row">
        <?php foreach($shows as $show){ ?>
            <div class ="col s6 md3">
                <div class="card z-depth-0">
                    <div class="card-content center">
                        <h6><?php echo htmlspecialchars($show['nome']);?> </h6>

                        <ul class="grey-text">                           
                                <li> <?php echo htmlspecialchars($show['local']); ?></li>
                                <li> <?php echo htmlspecialchars($show['descricao']); ?></li>                                                      
                        </ul>

                    </div>
                    <div class="card-action right-align">
                        <a class="brand-text" href="detalhes.php?id=<?php echo $show['id'] ?>">Mais informações</a>
                        <a class="brand-text" href="guiche.php?id=<?php echo $show['id'] ?>">Comprar Ingressos</a>

                    </div>
                  
                </div>
            </div>

        <?php } ?>

    </div>
</div>
<?php } else{ ?>
    <h4 class="center grey-text">Nenhum Show Disponível</h4>
    <?php } ?>
<?php include('templates/footer.php'); ?>

</html>