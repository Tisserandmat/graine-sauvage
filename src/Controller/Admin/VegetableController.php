<?php

namespace App\Controller\Admin;

use App\Entity\Vegetable;
use App\Form\VegetableType;
use App\Repository\VegeteableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administrateur/legumes")
 */
class VegetableController extends AbstractController
{
    /**
     * @Route("/", name="vegetable_index", methods={"GET"})
     * @param VegeteableRepository $vegeteableRepository
     * @return Response
     */
    public function index(VegeteableRepository $vegeteableRepository): Response
    {
        return $this->render('admin/vegetable/index.html.twig', [
            'vegetables' => $vegeteableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajouts", name="vegetable_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $vegetable = new Vegetable();
        $form = $this->createForm(VegetableType::class, $vegetable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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
     * @return Response
     */
    public function edit(Request $request, Vegetable $vegetable): Response
    {
        $form = $this->createForm(VegetableType::class, $vegetable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
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
        if ($this->isCsrfTokenValid('delete'.$vegetable->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vegetable);
            $entityManager->flush();
            $this->addFlash('danger', 'Le légume a été supprimer.');
        }

        return $this->redirectToRoute('vegetable_index');
    }
}
