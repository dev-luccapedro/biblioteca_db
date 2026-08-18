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


     public function buscarPorId(int $id): ?array {
         $sql = "SELECT l.*, c.nome as categoria_nome FROM livros l 
                 JOIN categorias c ON l.categoria_id = c.id 
                 WHERE l.id = :id";
         $stmt = $this->db->prepare($sql);
         $stmt->execute([':id' => $id]);
         $livro = $stmt->fetch();
 
         if (!$livro) return null;
         $sqlAutores = "SELECT a.id, a.nome FROM autores a 
                        JOIN livro_autor la ON a.id = la.autor_id 
                        WHERE la.livro_id = :livro_id";
         $stmtAutores = $this->db->prepare($sqlAutores);
         $stmtAutores->execute([':livro_id' => $id]);
         $livro['autores'] = $stmtAutores->fetchAll();
 
         return $livro;
     }



     public function listarTodos(string $busca = '', string $categoriaId = ''): array {
         $sql = "SELECT l.*, c.nome as categoria_nome, GROUP_CONCAT(a.nome SEPARATOR ', ') as autores 
                 FROM livros l
                 JOIN categorias c ON l.categoria_id = c.id
                 LEFT JOIN livro_autor la ON l.id = la.livro_id
                 LEFT JOIN autores a ON la.autor_id = a.id
                 WHERE 1=1";
         $params = [];
         if (!empty($busca)) {
             $sql .= " AND (l.titulo LIKE :busca OR l.isbn LIKE :busca)";
             $params[':busca'] = "%{$busca}%";
         }
 
         if (!empty($categoriaId)) {
             $sql .= " AND l.categoria_id = :categoria_id";
             $params[':categoria_id'] = $categoriaId;
         }
         $sql .= " GROUP BY l.id ORDER BY l.id DESC";
         $stmt = $this->db->prepare($sql);
         $stmt->execute($params);
         return $stmt->fetchAll();
     }






















 }