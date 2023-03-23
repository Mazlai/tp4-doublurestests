<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use iut\GestionEauService;

use \Mockery\Adapter\Phpunit\MockeryTestCase;

require __DIR__ . '/../vendor/autoload.php';

class GestionEauServiceTest extends MockeryTestCase
{
    public function testRestrictionEau()
    {
        //GIVEN
        $mockEau = \Mockery::mock('InfoSecheresseService');
        $mockEau->shouldReceive('previsionDureeSecheresse')->andReturn(15);

        $mockEtatService = \Mockery::mock('EtatService');
        $spyMunicipal = \Mockery::spy('MunicipalServices');

        $gestionEau = new GestionEauService($mockEau, $mockEtatService, $spyMunicipal);

        //WHEN
        $gestionEau->checkEtatSecheresse();
        
        //THEN
        $spyMunicipal->shouldHaveReceived()->sendRestrictionEauInformation();
    }

    public function testLivraisonEau() {
        //GIVEN
        $mockEau = \Mockery::mock('InfoSecheresseService');
        $mockEau->shouldReceive('previsionDureeSecheresse')->andReturn(25);
        $mockEau->shouldReceive('reserveEauMunicipale')->andReturn(80.0);

        $mockEtatService = \Mockery::mock('EtatService');
        $spyMunicipal = \Mockery::spy('MunicipalServices');

        $gestionEau = new GestionEauService($mockEau, $mockEtatService, $spyMunicipal);

        //WHEN
        $gestionEau->checkEtatSecheresse();

        //THEN
        $spyMunicipal->shouldHaveReceived()->callLivraisonCiterneEau();

    }

}
