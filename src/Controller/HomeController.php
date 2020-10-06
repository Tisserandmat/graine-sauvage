<?php

namespace App\Controller;

use App\Repository\VegeteableRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param VegeteableRepository $vegeteableRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(VegeteableRepository $vegeteableRepo)
    {
        $vegeteableRandom = $vegeteableRepo->getRandomVegeteableMonth();

        return $this->render('home/index.html.twig', [
            'vegetables' => $vegeteableRandom,
        ]);
    }
}
