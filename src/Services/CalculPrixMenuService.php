<?php

namespace App\Services;

use App\Entity\Menu;
use App\Entity\MenuBurger;
use App\Entity\MenuPortion;
use App\Entity\MenuTaille;
use App\Entity\Portionfrite;
use App\Entity\Taille;
use Doctrine\ORM\EntityManagerInterface;

Class CalculPrixMenuService
{
    public function calculprix($data)
    {
        $prix=0;
        if ($data instanceof Portionfrite or $data instanceof Taille)
        {
            $data->setPrix($prix);
            
        }
        elseif ($data instanceof Menu) 
        {
            foreach($data->getMenuburgers() as $menuburger)
            {
                $prix += $menuburger->getBurger()->getPrix()*$menuburger->getQuantiterburger();
            }
            foreach($data->getMenuportions() as $menuportion)
            {
                $prix+=$menuportion->getPortionfrite()->getPrix()*$menuportion->getQuantitefrite();
            }
            foreach($data->getMenuTailles() as $menutaille)
            {
                $prix+=$menutaille->getTaille()->getPrix()*$menutaille->getQuantitetaille();
        
            }
            
            
        }
        return $prix;
    }
       


}