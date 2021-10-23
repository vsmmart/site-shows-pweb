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


    while ($row = mysqli_fetch_assoc($resultHorarios)) {
        $horarios[] = $row;
    }

    mysqli_free_result($resultArtista);
    mysqli_free_result($resultHorarios);

    mysqli_close($conn);
}
$meia = "A Lei Federal nº 12933/2013, também conhecida como Lei da Meia-Entrada, garante o benefício do pagamento de Meia-Entrada para estudantes, pessoas com deficiência e jovens, de baixa renda, com idade entre 15 e 29 anos.
Somente farão jus ao benefício alunos da educação básica e educação superior, conforme previsto no Título V da Lei no 9.394, de 20.12.1996. A lei não estende o benefício a cursos livres, tais como cursos de inglês e informática.
Pessoas com deficiência e quando necessário, seus acompanhantes, têm direito ao benefício.
Jovens de 15 a 29 anos, cuja renda familiar mensal seja de até 02 salários mínimos, desde que inscritos no Cadastro Único para Programas Sociais do Governo Federal, podem adquirir os ingressos com 50% de desconto."
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

        <?php

        foreach ($horarios as $h) { ?>

            <form action="guiche2.php " method="POST">
                <p> <?php echo "Data: " . (date($h['dataHora'])) . "</br>" . "Preço Inteira: R$" . $h['valorIngresso'] . "</br>" . " Capacidade: " . $h['capacidade'] . "</br>"; ?>
                    <label>
                        <input type="number" min="0" id="cbInteira" />
                        <span> Inteira </span>
                    </label>
                <div></div>
                <label>
                    <input type="number" min="0" id="cbMeia" />
                    <span> Meia </span>
                    <p> <?php echo $meia; ?></p>
                </label>
                </p>
            </form>

            <!-- Formulario de Edição -->
            <form action="guiche2.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $show['id']; ?>">
                <input type="hidden" name="id" value="<?php echo $h['id']; ?>">
                <input type="submit" name="comprar" value="Comprar" class="btn brand z-depth-0">
            </form>

        <?php } ?>



</div>





<?php else : ?>
    <h5>Show não encontrado</h5>
<?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>