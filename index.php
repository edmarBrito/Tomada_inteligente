<?php
// Muda o fuso horário do PHP para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Variáveis para guardar os parâmetros GET
$umidade = $_GET['u'];
$temperatura = $_GET['t'];
$corrente = $_GET['c'];
$chave = $_GET['key'];
// Verifica se a chave enviada é válida
if($chave != 'secreto'){ 
    echo 'chave invalida' ;
    die();
}

// Variáveis do PDO:
//Database handler para se conectar e gerenciar o banco de dados
$dbh;
// Statement para armazenar uma query do banco e executa-la
$stmt;

// String de conexão do banco de dados
$connStr = 'mysql:host=localhost:3306;dbname=testEsp32'; // testEsp32
// Comando que tenta se conectar ao banco (try, catch)
try{
    // Se conecta ao banco da string
    //com usuário root e senha em branco (padrões do XAMPP)
    $dbh = new PDO($connStr, 'root', '@123Comida'); //@123Comida
}
catch(PDOException $e){
    // Caso ocorra erro o retorna e encerra a execução (função die)
    echo $e->getMessage();
    die();
}
// Prepara uma query com três parâmetros nomeados
$stmt = $dbh->prepare('INSERT INTO medicoes_dht11(umidade, temperatura, data_hora, corrente) VALUES (:umidade, :temperatura, :data_hora, :corrente)'); //, :corrente)'

// Define os valores das variáveis aos parâmetros nomeados da query
//no último define formato yyyy-mm-dd hh:ii:ss
$stmt->bindValue(':umidade', $umidade);
$stmt->bindValue(':temperatura', $temperatura); 
//$stmt->bindvalue(':data_hora','2022-01-18 09:31:10');
$stmt->bindValue(':data_hora', date("Y-m-d H:i:s"));
$stmt->bindValue(':corrente', $corrente);

// Tenta executar o comando e retorna sucesso ou erro
if($stmt->execute()){
    echo 'sucesso';
}else{
    echo 'erro';
}
