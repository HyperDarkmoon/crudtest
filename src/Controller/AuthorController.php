<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Author;
use App\Form\AuthorType;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/authors', name: 'authors_list')]
    public function listAuthors(EntityManagerInterface $em): Response
    {
        $authors = $em->getRepository(Author::class)->findAll();
    
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }
    
    #[Route('/author/add', name: 'author_add')]
    public function addAuthor(Request $request, EntityManagerInterface $em) :Response {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('authors_list');
        }
        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/author/edit/{id}', name: 'author_edit')]
    public function editAuthor(Request $request, EntityManagerInterface $em, $id): Response {
        $author = $em->getRepository(Author::class)->find($id);
        if (!$author) {
            throw $this->createNotFoundException('The author does not exist');
        }

        $form = $this->createForm(AuthorType::Class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('authors_list');
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/author/delete/{id}', name: 'author_delete')]
    public function deleteAuthor(EntityManagerInterface $em, $id): Response {
        $author = $em->getRepository(Author::class)->find($id);
        if (!$author) {
            throw $this->createNotFoundException('The author does not exist');
        }

        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('authors_list');
    }
}
