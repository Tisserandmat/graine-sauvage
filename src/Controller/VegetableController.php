<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Repository\VegetableRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VegetableController extends AbstractController
{
    /**
     * @Route("fiche-legume/{slug}", name="vegetable")
     * @param Vegetable $vegetable
     * @return Response
     */
    public function index(Vegetable $vegetable)
    {

        return $this->render('vegetable/vegetable_sheet.html.twig', [
            'vegetable' => $vegetable,
        ]);
    }

    /**
     * @Route("index-legumes", name="index_vegetable")
     * @param VegetableRepository $vegetableRepo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function vegetableIndex(
        VegetableRepository $vegetableRepo,
        PaginatorInterface $paginator,
        Request $request
    ) {

        $allVegetablesRepo = $vegetableRepo->findAll();
        $vegetables = $paginator->paginate(
            $allVegetablesRepo, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );

        return $this->render('vegetable/vegetable_index.html.twig', [
            'vegetables' => $vegetables,
        ]);
    }
}
