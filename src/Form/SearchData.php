<?php


namespace App\Form;

class SearchData
{
    private $dateArrivee;
    private $dateDepart;
    private $capaciteAdulte;
    private $capaciteEnfant;

    public function getDateArrivee()
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee($dateArrivee)
    {
        $this->dateArrivee = $dateArrivee;
    }

    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    public function setDateDepart($dateDepart)
    {
        $this->dateDepart = $dateDepart;
    }

    public function getCapaciteAdulte()
    {
        return $this->capaciteAdulte;
    }

    public function setCapaciteAdulte($capaciteAdulte)
    {
        return $this->capaciteAdulte = $capaciteAdulte;
    }

    public function getCapaciteEnfant()
    {
        return $this->capaciteEnfant;
    }

    public function setCapaciteEnfant($capaciteEnfant)
    {
       return $this->capaciteEnfant = $capaciteEnfant;
    }
}