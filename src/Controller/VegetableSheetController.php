<?php

namespace App\Controller;

use App\Entity\Vegetable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VegetableSheetController extends AbstractController
{
    /**
     * @Route("fiche-legume/{slug}", name="vegetable_sheet")
     * @param Vegetable $vegetable
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Vegetable $vegetable)
    {

        return $this->render('vegetable_sheet/index.html.twig', [
            'vegetanle' => $vegetable,
        ]);
    }
}
