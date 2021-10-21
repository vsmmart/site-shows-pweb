<?php 

	include('config/bd_conexao.php');

	$erros = array('artista'=>'','data'=>'','local'=>'','ingressos'=>'','preco'=>'');
	$artista = $data = $local = $ingressos = $preco = '';
	
	if (isset($_POST['enviar'])){
		
		//Verificar o artista a se apresentar
		if (empty($_POST['artista'])){
			$erros['artista'] = 'O artista a se apresentar é obrigatório';
		} else{
			$artista = $_POST['artista'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',$artista)){
				$erros['artista'] = 'O nome deve conter somente letras';	
                $artista = '';		
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
		
		//Verificar data
		if (empty($_POST['data'])){
			$erros['data'] = 'A data é obrigatória </br>';
		} else{
			$data = $_POST['data'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',$data)){
				$erros['data'] = 'O nome deve conter somente letras e separados por vírgula';
                $data = '';			
			}
		}

		//Verificar Numero de Ingressos
		if (empty($_POST['ingressos'])){
			$erros['ingressos'] = 'Deve conter ao menos um ingresso </br>';
		} else{
			$ingressos = $_POST['ingressos'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',$ingressos)){
				$erros['ingressos'] = 'O nome deve conter somente letras e separados por vírgula';
                $ingressos = '';			
			}
		}

		//Verificar Preço

		if (empty($_POST['preco'])){
			$erros['preco'] = 'Deve conter ao menos um ingrediente </br>';
		} else{
			$preco = $_POST['preco'];
			if (!preg_match('/^([a-zA-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]+)(,\s*[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÔÕÖÚÇÑ\s]*)*$/',$preco)){
				$erros['preco'] = 'O nome deve conter somente letras e separados por vírgula';
                $preco = '';			
			}
		}
        if(array_filter($erros)){
            //echo 'Erro no formulário';
        } else{
			//Limpando codigos suspeitos
			$artista = mysqli_real_escape_string($conn,$_POST['artista']);
			$local = mysqli_real_escape_string($conn,$_POST['local']);
			$data = mysqli_real_escape_string($conn,$_POST['data']);
			$ingressos = mysqli_real_escape_string($conn,$_POST['ingressos']);
			$preco = mysqli_real_escape_string($conn,$_POST['preco']);

			//Criando a query
			$sql = "INSERT INTO shows(artista, data, local, ingressos, preco) VALUES('$artista','$data','$local' ,'$ingressos' ,'$preco')";
           
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

            <label>Artista</label>
            <input type="text" name="artista" value="<?php echo $artista ?>">
            <div class="red-text"><?php echo $erros['artista'].'</br>';?>
            
            <label> Data do Show</label>
            <input type="text" name="data" value="<?php echo $data ?>">
            <div class="red-text"><?php echo $erros['data'].'</br>';?>
           
            <label>Localização</label>
            <input type="text" name="local" value="<?php echo $local ?>">
            <div class="red-text"><?php echo $erros['local'].'</br>';?>

			<label>Quantidade de Ingressos</label>
            <input type="text" name="ingressos" value="<?php echo $ingressos ?>">
            <div class="red-text"><?php echo $erros['ingressos'].'</br>';?>

			<label>Preço(Inteira)</label>
            <input type="text" name="preco" value="<?php echo $preco ?>">
            <div class="red-text"><?php echo $erros['preco'].'</br>';?>

            <div class="center">
                <input type="submit" name="enviar" value="Enviar" class="btn brand z-depth-0">
            </div>
        </form>
    </section>
    <?php include('Templates/footer.php')?>
</html>