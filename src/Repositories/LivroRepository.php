<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Entities/Livro.php';


 class LivroRepository {
     private PDO $db;
 
     public function __construct() {
         $this->db = Database::getConnection();
     }


    public function salvar(Livro $livro): bool {
       if ($livro->getId() === null) {
           return $this->criar($livro);
        } else {
            return $this->atualizar($livro);
        }
    
        }

     private function criar(Livro $livro): bool {
         $sql = "INSERT INTO livros (titulo, isbn, categoria_id, status, imagem) VALUES (:titulo, :isbn, :categoria_id, :status, :imagem)";
         $stmt = $this->db->prepare($sql);
         $sucesso = $stmt->execute([
             ':titulo' => $livro->getTitulo(),
             ':isbn' => $livro->getIsbn(),
             ':categoria_id' => $livro->getCategoriaId(),
             ':status' => $livro->getStatus(),
             ':imagem' => $livro->getImagem()
         ]);

         if ($sucesso) {
             $livroId = (int)$this->db->lastInsertId();
             $livro->setId($livroId);
             $this->sincronizarAutores($livroId, $livro->getAutoresIds());
         }
         return $sucesso;
     }











 }