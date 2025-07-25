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
    public function index(Request $request, BookRepository $bookrepository): Response
    {

        $bookid = $request->query->get('id');

        $book = null;

        if ($bookid !== null) {
            $book = $bookrepository->find($bookid);
        }

        return $this->render('book_details/index.html.twig', [
            'controller_name' => 'BookDetailsController',
            'book' => $book
        ]);
    }

    #[Route('/book/search', name: 'app_books_search')]
    public function search(Request $request, BookRepository $bookRepository): Response
    {
        $searchTerm = $request->query->get('q', '');
        $books = [];
        $allBooks = [];

        if ($searchTerm !== '') {
            $books = $bookRepository->searchByTitle($searchTerm);
        } else {
            $allBooks = $bookRepository->findAll();
        }

        return $this->render('book_details/search.html.twig', [
            'books' => $books,
            'allBooks' => $allBooks,
            'searchTerm' => $searchTerm,
        ]);
    }

}
