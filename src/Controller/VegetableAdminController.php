<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Form\VegetableType;
use App\Repository\VegetableRepository;
use App\Services\Slugify;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administrateur/legumes")
 */
class VegetableAdminController extends AbstractController
{
    const SEASONS = [
        "Printemps" => [ "Avril" => "Avril", "Mai" =>"Mai", "Juin" => "Juin"],
        "Été" => [ "Juillet", "Août", "Septembre"],
        "Automne" => [ "Octobre", "Novembre", "Decembre"],
        "Hiver" => [ "Janvier", "Février", "Mars" => "Mars"]
    ];

    /**
     * @Route("/", name="vegetable_index", methods={"GET"})
     * @param VegetableRepository $vegetableRepo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(
        VegetableRepository $vegetableRepo,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $allVegetables = $vegetableRepo->findAll();
        $vegetables = $paginator->paginate(
            $allVegetables, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->render('admin/vegetable/index.html.twig', [
            'vegetables' => $vegetables,
        ]);
    }

    /**
     * @Route("/ajouts", name="vegetable_new", methods={"GET","POST"})
     * @param Request $request
     * @param Slugify $slugify
     * @return Response
     */
    public function new(Request $request, Slugify $slugify): Response
    {
        $vegetable = new Vegetable();
        $form = $this->createForm(VegetableType::class, $vegetable);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($vegetable->getName());
            $vegetable->setSlug($slug);

            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Printemps"])) {
                $vegetable->setSeason("Printemps");
            }
            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Été"])) {
                $vegetable->setSeason("Été");
            }
            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Automne"])) {
                $vegetable->setSeason("Automne");
            }
            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Hiver"])) {
                $vegetable->setSeason("Hiver");
            }

            $entityManager->persist($vegetable);
            $entityManager->flush();


            $this->addFlash('success', 'Un nouveau légume a été créer.');

            return $this->redirectToRoute('vegetable_index');
        }

        return $this->render('admin/vegetable/new.html.twig', [
            'vegetable' => $vegetable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vegetable_show", methods={"GET"})
     * @param Vegetable $vegetable
     * @return Response
     */
    public function show(Vegetable $vegetable): Response
    {
        return $this->render('admin/vegetable/show.html.twig', [
            'vegetable' => $vegetable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vegetable_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Vegetable $vegetable
     * @param Slugify $slugify
     * @return Response
     */
    public function edit(Request $request, Vegetable $vegetable, Slugify $slugify): Response
    {
        $form = $this->createForm(VegetableType::class, $vegetable);
        $form->handleRequest($request);

        $slug = $slugify->generate($vegetable->getName());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $vegetable->setSlug($slug);

            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Printemps"])) {
                $vegetable->setSeason("Printemps");
            }
            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Été"])) {
                $vegetable->setSeason("Été");
            }
            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Automne"])) {
                $vegetable->setSeason("Automne");
            }
            if (in_array($vegetable->getHarvestMonth(), self::SEASONS["Hiver"])) {
                $vegetable->setSeason("Hiver");
            }
            $entityManager->persist($vegetable);
            $entityManager->flush();
            $this->addFlash('success', 'Le légume a bien été modifier.');

            return $this->redirectToRoute('vegetable_index');
        }

        return $this->render('admin/vegetable/edit.html.twig', [
            'vegetable' => $vegetable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vegetable_delete", methods={"DELETE"})
     * @param Request $request
     * @param Vegetable $vegetable
     * @return Response
     */
    public function delete(Request $request, Vegetable $vegetable): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vegetable->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vegetable);
            $entityManager->flush();
            $this->addFlash('danger', 'Le légume a été supprimer.');
        }

        return $this->redirectToRoute('vegetable_index');
    }
}
