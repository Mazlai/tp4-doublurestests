<?php

namespace iut;

use InfoSecheresseService;
use EtatService;
use MunicipalServices;

class GestionEauService {

    private InfoSecheresseService $infoSecheresse;
    private EtatService $serviceEtat;
    private MunicipalServices $servicesMunicipaux;

    function __construct(InfoSecheresseService $infoSecheresse, EtatService $serviceEtat, MunicipalServices $servicesMunicipaux) {
        $this->infoSecheresse = $infoSecheresse;
        $this->serviceEtat = $serviceEtat;
        $this->servicesMunicipaux = $servicesMunicipaux;
    }

    public function checkEtatSecheresse() {
        if ($this->infoSecheresse->previsionDureeSecheresse() > 20 && $this->infoSecheresse->reserveEauMunicipale() < 100.0) {
            $this->servicesMunicipaux->callLivraisonCiterneEau();
        }

        if($this->infoSecheresse->previsionDureeSecheresse() > 10) {
            $this->servicesMunicipaux->sendRestrictionEauInformation();
        } 
    }
    
}

?>
