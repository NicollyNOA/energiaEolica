<?php

// Classe do formato de dados que irá para o banco de dados

class DadosEnergia {
    public $tensao;
    public $corrente;
    public $voltagem;

    public function __construct($tensao, $corrente, $voltagem) {
        $this->tensao = $tensao;
        $this->corrente = $corrente;
        $this->voltagem = $voltagem;
    }
}

// Dados recebidos pela requisição POST

$conteudo_requisicao = file_get_contents("php://input");
$json_requisicao = json_decode($conteudo_requisicao);

// Criação do objeto que sera gravado no banco de dados

$tensao = $json_requisicao->tensao;
$corrente = $json_requisicao->corrente;
$voltagem = $json_requisicao->voltagem;

$dados_a_cadastrar = new DadosEnergia($tensao, $corrente, $voltagem);
$json = json_encode($dados_a_cadastrar);

// Configuração da conexão com o banco de dados

$servidor = 'localhost';
$usuario = "root";
$senha = "nini";
$nomebanco = "energiaEolica";

// Gravação dos dados no banco

$conexao = new mysqli($servidor, $usuario, $senha, $nomebanco);
$sql = "INSERT INTO dadosEnergia (tensao, corrente, voltagem) VALUES ('$tensao', '$corrente', '$voltagem')";

$conexao->query($sql);

$resposta = [
    "mensagem" => "Dados inseridos com sucesso",
    "tensao" => $tensao,
    "corrente" => $corrente,
    "voltagem" => $voltagem
];

// Envio de resposta de confirmação

echo json_encode($resposta);

// Fechamento da conexão

$conexao->close();

?>