<?php

namespace App\Controller\Admin;

use App\Entity\Seed;
use App\Form\SeedType;
use App\Repository\SeedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administrateur/graines")
 */
class SeedController extends AbstractController
{
    /**
     * @Route("/", name="seed_index", methods={"GET"})
     * @param SeedRepository $seedRepository
     * @return Response
     */
    public function index(SeedRepository $seedRepository): Response
    {
        return $this->render('admin/seed/index.html.twig', [
            'seeds' => $seedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajouts", name="seed_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $seed = new Seed();
        $form = $this->createForm(SeedType::class, $seed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($seed);
            $entityManager->flush();

            $this->addFlash('success', 'Une nouvelle graine a été créée.');

            return $this->redirectToRoute('seed_index');
        }

        return $this->render('admin/seed/new.html.twig', [
            'seed' => $seed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="seed_show", methods={"GET"})
     * @param Seed $seed
     * @return Response
     */
    public function show(Seed $seed): Response
    {
        return $this->render('admin/seed/show.html.twig', [
            'seed' => $seed,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="seed_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Seed $seed
     * @return Response
     */
    public function edit(Request $request, Seed $seed): Response
    {
        $form = $this->createForm(SeedType::class, $seed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La graine a bien été modifiée.');

            return $this->redirectToRoute('seed_index');
        }

        return $this->render('admin/seed/edit.html.twig', [
            'seed' => $seed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="seed_delete", methods={"DELETE"})
     * @param Request $request
     * @param Seed $seed
     * @return Response
     */
    public function delete(Request $request, Seed $seed): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seed->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seed);
            $entityManager->flush();
            $this->addFlash('danger', 'La graine à bien été supprimée.');
        }

        return $this->redirectToRoute('seed_index');
    }
}
