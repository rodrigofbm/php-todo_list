<?php
class Conexao
{
  private $host = 'localhost';
  private $dbname = 'php_pdo';
  private $user = 'admin';
  private $password = 'hackers20';

  public function conectar()
  {
    try {
      $conexao = new PDO(
        "mysql:host=$this->host;dbname=$this->dbname",
        $this->user,
        $this->password
      );

      return $conexao;
    } catch (PDOException $e) {
      echo '<p>' . $e->getMessage() . '</p>';
    }
  }
}
