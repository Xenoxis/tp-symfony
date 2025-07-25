<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use App\Entity\Book;

final class BookDetailsController extends AbstractController
{
    #[Route('/book/details', name: 'app_book_details')]
    public function index(): Response
    {
        return $this->render('book_details/index.html.twig', [
            'controller_name' => 'BookDetailsController',
        ]);
    }

    #[Route('/books/search', name: 'app_books_search')]
    public function search(Request $request, BookRepository $bookRepository): Response
    {
        $searchTerm = $request->query->get('q', '');
        $books = [];
        if ($searchTerm !== '') {
            $books = $bookRepository->searchByTitle($searchTerm);
        }
        return $this->render('book_details/search.html.twig', [
            'books' => $books,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/books/{id}', name: 'app_book_show', requirements: ['id' => '\\d+'])]
    public function show(Book $book): Response
    {
        return $this->render('book_details/show.html.twig', [
            'book' => $book,
        ]);
    }
}
