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
    private $leiloeiro;

    public function setUp(): void
    {
        //echo "Executando setUp" . PHP_EOL;
        $this->leiloeiro = new Avaliador();
    }
    
    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);
        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */

    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);
        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */

    public function testeAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);
        $maiores = $this->leiloeiro->getMaioresLances();

        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }

    public function testLeilaoVazioNaoPodeSerAvaliado() 
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Não foi possível avaliar o leilão vazio");
        $leilao = new Leilao('Fusca Azul');
        $this->leiloeiro->avalia($leilao);
    }

    public function testLeilaoFinalizadoNaoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Leilão já finalizado");
        $leilao = new Leilao('Fiat 147 0KM');
        $leilao->recebeLance(new Lance(new Usuario('Teste'), 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
    }

    /********* Dados ********/

    public function leilaoEmOrdemCrescente()
    {
        //echo "Criando em ordem crescente" . PHP_EOL;
        $leilao = new Leilao(descricao: 'Fiat 147 0KM');

        $maria = new Usuario(nome: 'Maria');
        $joao = new Usuario(nome: 'João');
        $ana = new Usuario(nome: 'Ana');

        $leilao->recebeLance(new Lance($ana, valor: 1700));
        $leilao->recebeLance(new Lance($joao, valor: 2000));
        $leilao->recebeLance(new Lance($maria, valor: 2500));

        return [
            'ordem-crescente' => [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente()
    {
        //echo "Criando em ordem decrescente" . PHP_EOL;
        $leilao = new Leilao(descricao: 'Fiat 147 0KM');

        $maria = new Usuario(nome: 'Maria');
        $joao = new Usuario(nome: 'João');
        $ana = new Usuario(nome: 'Ana');

        $leilao->recebeLance(new Lance($ana, valor: 2500));
        $leilao->recebeLance(new Lance($joao, valor: 2000));
        $leilao->recebeLance(new Lance($maria, valor: 1700));

        return [
            'ordem-decrescente' => [$leilao]
        ];
    }

    public function leilaoEmOrdemAleatoria()
    {
        //echo "Criando em ordem aleatória" . PHP_EOL;
        $leilao = new Leilao(descricao: 'Fiat 147 0KM');

        $maria = new Usuario(nome: 'Maria');
        $joao = new Usuario(nome: 'João');
        $ana = new Usuario(nome: 'Ana');

        $leilao->recebeLance(new Lance($ana, valor: 2000));
        $leilao->recebeLance(new Lance($joao, valor: 2500));
        $leilao->recebeLance(new Lance($maria, valor: 1700));

        return [
            'ordem-aleatoria' => [$leilao]
        ];
    }
}

