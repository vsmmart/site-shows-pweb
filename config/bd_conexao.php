<?php 
$conn = mysqli_connect('localhost','super','123456','site_shows');

if(!$conn){
    echo 'Erro na conexão: '.mysqli_connect_error();
}

?>