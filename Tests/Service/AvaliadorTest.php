<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

class AvaliadorTest extends TestCase
{
    public function testAvaliadorDeveEncontrarOMaiorValorDeLancesEmOrdemCrescente()
    {
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
        self::assertEquals(2500, $maiorValor);
    }

    public function testAvaliadorDeveEncontrarOMaiorValorDeLancesEmOrdemcDecrescente()
    {
        // Arrange - Given
        $leilao = new Leilao(descricao: 'Fiat 147 0KM');

        $maria = new Usuario(nome: 'Maria');
        $joao = new Usuario(nome: 'João');

        $leilao->recebeLance(new Lance($maria, valor: 2500));
        $leilao->recebeLance(new Lance($joao, valor: 2000));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        // Act - When
        $maiorValor = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(2500, $maiorValor);
    }

    public function testAvaliadorDeveEncontrarOMenorValorDeLancesEmOrdemcDecrescente()
    {
        // Arrange - Given
        $leilao = new Leilao(descricao: 'Fiat 147 0KM');

        $maria = new Usuario(nome: 'Maria');
        $joao = new Usuario(nome: 'João');

        $leilao->recebeLance(new Lance($maria, valor: 2500));
        $leilao->recebeLance(new Lance($joao, valor: 2000));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        // Act - When
        $menorValor = $leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(2000, $menorValor);
    }

    public function testAvaliadorDeveEncontrarOMenorValorDeLancesEmOrdemCrescente()
    {
        // Arrange - Given
        $leilao = new Leilao(descricao: 'Fiat 147 0KM');

        $maria = new Usuario(nome: 'Maria');
        $joao = new Usuario(nome: 'João');

        $leilao->recebeLance(new Lance($joao, valor: 2000));
        $leilao->recebeLance(new Lance($maria, valor: 2500));

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);

        // Act - When
        $menorValor = $leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(2000, $menorValor);
    }

}
