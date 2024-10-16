<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Aeroport;
use App\Form\AeroportType;

class AeroportController extends AbstractController
{
    #[Route('/aeroport', name: 'app_aeroport')]
    public function index(): Response
    {
        return $this->render('aeroport/index.html.twig', [
            'controller_name' => 'AeroportController',
        ]);
    }

    #[Route('/aeroports', name: 'aeroport_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $aeroports = $entityManager->getRepository(Aeroport::class)->findAll();

        return $this->render('aeroport/list.html.twig', [
            'aeroports' => $aeroports,
        ]);
    }

    #[Route('/aeroport/new', name: 'aeroport_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aeroport = new Aeroport();
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aeroport);
            $entityManager->flush();

            return $this->redirectToRoute('aeroport_list');
        }

        return $this->render('aeroport/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/aeroport/edit/{id}', name: 'aeroport_edit')]
    public function edit(Request $request, Aeroport $aeroport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('aeroport_list');
        }

        return $this->render('aeroport/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
