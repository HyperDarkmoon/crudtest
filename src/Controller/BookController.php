<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    

    #[Route('/book/add', name: 'book_add')]
    public function add(Request $request, EntityManagerInterface $em): Response {
        $book = new Book();
        $book->setPublished(true);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $this->getAuthor();
            if (!$author) {
                $author->setNbBooks($author->getNbBooks() + 1);
            }
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
