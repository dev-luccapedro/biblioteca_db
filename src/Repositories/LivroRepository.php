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
 













 }