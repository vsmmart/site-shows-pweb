<?php 

	include('config/bd_conexao.php');

	$erros = array('nome'=>'','local'=>'','descricao'=>'');
	$nome = $local = $descricao = '';
	

	if (isset($_POST['enviar'])){
		
		//Verificar o nome do evento 
		if (empty($_POST['nome'])){
			$erros['nome'] = 'O nome do evento é obrigatório';
		} else{
			$nome = $_POST['nome'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',$nome)){
				$erros['nome'] = 'O nome deve conter somente letras';	
                $nome = '';		
			}
		}
		
		//Verificar local
		if (empty($_POST['local'])){
			$erros['local'] = 'O local do show é obrigatório';
		} else{
			$local = $_POST['local'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',$local)){
				$erros['local'] = 'O nome deve conter somente letras';	
                $local = '';		
			}
		}
		
		//Verificar Descricao
		if (empty($_POST['descricao'])){
			$erros['descricao'] = 'Descrição do evento deve ser informada </br>';
		} else{
			$descricao = $_POST['descricao'];
		}

        if(array_filter($erros)){
            //echo 'Erro no formulário';
        } else{
			//Limpando codigos suspeitos
			$nome = mysqli_real_escape_string($conn,$_POST['nome']);
			$local = mysqli_real_escape_string($conn,$_POST['local']);
			$descricao = mysqli_real_escape_string($conn,$_POST['descricao']);
	// teste
			//Criando a query
			$sql = "INSERT INTO shows(nome,  local, descricao) VALUES('$nome','$local' ,'$descricao')";
           
			//Salva no banco de dados
			if(mysqli_query($conn, $sql)){
				//Sucesso
				header('Location: index.php');
			} else{
				echo 'query error: '.mysqli_error($conn);
			}
        }		
	}
?>


<!DOCTYPE html>
<html>
    <?php include('Templates/header.php');?>

    <section class="container grey-text">
        <h4 class="center">Adicionar Novo Show</h4>
        <form class="white" action="adicionar.php" method="POST">

            <label>Nome</label>
            <input type="text" name="nome" value="<?php echo $nome ?>">
            <div class="red-text"><?php echo $erros['nome'].'</br>';?>
			
            <label>Localização</label>
            <input type="text" name="local" value="<?php echo $local ?>">
            <div class="red-text"><?php echo $erros['local'].'</br>';?>

			<label>Descrição</label>
            <input type="text" name="descricao" value="<?php echo $descricao ?>">
            <div class="red-text"><?php echo $erros['descricao'].'</br>';?>

			<label>Imagem</label><br><br>
			<li><a href="imagem.php" class="btn brand z-depth-0">Adicionar</a></li>
            
            <div class="center">
                <input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0">
            </div>
        </form>
    </section>
    <?php include('Templates/footer.php')?>
</html>