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

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getTitulo(): string { return $this->titulo; }
    public function setTitulo(string $titulo): void {
        if (empty(trim($titulo))) throw new InvalidArgumentException("O título não pode ser vazio.");
        $this->titulo = $titulo;
    }

    public function getIsbn(): string { return $this->isbn; }
    public function setIsbn(string $isbn): void {
        if (empty(trim($isbn))) throw new InvalidArgumentException("O ISBN é obrigatório.");
        $this->isbn = $isbn;
    }

    public function getCategoriaId(): int { return $this->categoriaId; }
    public function setCategoriaId(int $categoriaId): void { $this->categoriaId = $categoriaId; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): void {
        $statusPermitidos = ['disponivel', 'emprestado', 'manutencao'];
        if (!in_array($status, $statusPermitidos)) {
            throw new InvalidArgumentException("Status inválido.");
        }
        $this->status = $status;
    }

    public function getImagem(): ?string { return $this->imagem; }
    public function setImagem(?string $imagem): void { $this->imagem = $imagem; }

    public function getAutoresIds(): array { return $this->autoresIds; }
    public function setAutoresIds(array $autoresIds): void { $this->autoresIds = $autoresIds; }

    }