<?php

namespace App\Controller;

use App\Repository\VegetableRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param VegetableRepository $vegeteableRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(VegetableRepository $vegetableRepo)
    {
        $vegetableRandom = $vegetableRepo->getRandomVegeteableMonth();

        return $this->render('home/index.html.twig', [
            'vegetables' => $vegetableRandom,
        ]);
    }
}
