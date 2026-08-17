<?php
class Livro {
    private ?int $id = null;
    private string $titulo;
    private string $isbn;
    private int $categoriaId;
    private string $status;
    private ?string $imagem = null;
    private array $autoresIds = [];

    public function __construct(string $titulo, string $isbn, int $categoriaId, string $status = 'disponivel', ?string $imagem = null, ?int $id = null) {
        $this->setId($id);
        $this->setTitulo($titulo);
        $this->setIsbn($isbn);
        $this->setCategoriaId($categoriaId);
        $this->setStatus($status);
        $this->imagem = $imagem;
    }






























    }