<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $username = null;
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email = null;
    #[ORM\Column(type: 'integer')]
    private ?int $nbBooks = null;
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'author')]
    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }


    public function getBooks()
    {
        return $this->books;
    }

    public function setBooks($books): self
    {
        $this->books = $books;

        return $this;
    }


    public function getNbBooks(): ?int
    {
        return $this->nbBooks;
    }

    public function setNbBooks(int $nbBooks): self
    {
        $this->nbBooks = $nbBooks;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
