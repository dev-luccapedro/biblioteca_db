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


     private function atualizar(Livro $livro): bool {
         $sql = "UPDATE livros SET titulo = :titulo, isbn = :isbn, categoria_id = :categoria_id, status = :status, imagem = :imagem WHERE id = :id";
         $stmt = $this->db->prepare($sql);
         $sucesso = $stmt->execute([
             ':id' => $livro->getId(),
             ':titulo' => $livro->getTitulo(),
             ':isbn' => $livro->getIsbn(),
             ':categoria_id' => $livro->getCategoriaId(),
             ':status' => $livro->getStatus(),
             ':imagem' => $livro->getImagem()
         ]);
         if ($sucesso) {
             $this->sincronizarAutores($livro->getId(), $livro->getAutoresIds());
         }
         return $sucesso;
     }


     private function sincronizarAutores(int $livroId, array $autoresIds): void {
         $sqlDelete = "DELETE FROM livro_autor WHERE livro_id = :livro_id";
         $stmtDelete = $this->db->prepare($sqlDelete);
         $stmtDelete->execute([':livro_id' => $livroId]);
         if (!empty($autoresIds)) {
             $sqlInsert = "INSERT INTO livro_autor (livro_id, autor_id) VALUES (:livro_id, :autor_id)";
             $stmtInsert = $this->db->prepare($sqlInsert);
             foreach ($autoresIds as $autorId) {
                 $stmtInsert->execute([':livro_id' => $livroId, ':autor_id' => $autorId]);
             }
         }
     }

     





 }