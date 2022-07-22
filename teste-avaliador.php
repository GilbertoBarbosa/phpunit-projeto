<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

// Arrange - Given
$leilao = new Leilao(descricao: 'Fiat 147 0KM');

$maria = new Usuario(nome: 'Maria');
$joao = new Usuario(nome: 'João');

$leilao->recebeLance(new Lance($joao, valor: 2000));
$leilao->recebeLance(new Lance($maria, valor: 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

// Act - When
$maiorValor = $leiloeiro->getMaiorValor();

// Assert - Then
$valorEsperado = 2500;

if ($valorEsperado == $maiorValor) {
    echo "TESTE OK";
} else {
    echo "TESTE FALHOU";
}