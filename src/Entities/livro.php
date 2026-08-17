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
     
    public function marcarComoEmprestado(): void {
        if ($this->status === 'emprestado') {
            throw new Exception("O livro '{$this->titulo}' já se encontra emprestado.");
        }
        if ($this->status === 'manutencao') {
            throw new Exception("O livro está em manutenção e não pode ser emprestado.");
        }
        $this->status = 'emprestado';
    }

    public function devolver(): void {
        $this->status = 'disponivel';
    }




























    }