<?php
 require_once __DIR__ . '/../../config/database.php';

 class UsuarioRepository {
     private PDO $db;
 
     public function __construct() {
         $this->db = Database::getConnection();
     }
 
     public function buscarPorEmail(string $email): ?array {
         $sql = "SELECT * FROM usuarios WHERE email = :email";
         $stmt = $this->db->prepare($sql);
         $stmt->execute([':email' => $email]);
         $user = $stmt->fetch();
         return $user ?: null;
     }
 }