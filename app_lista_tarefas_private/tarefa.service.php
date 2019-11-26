<?php
class TarefaService
{
  private $conexao;
  private $tarefa;

  public function __construct(Conexao $conexao, Tarefa $tarefa)
  {
    $this->conexao = $conexao->conectar();
    $this->tarefa = $tarefa;
  }

  public function inserir()
  {
    print_r($this->tarefa->__get('tarefa'));
    $query = '
      INSERT INTO tb_tarefas(tarefa) VALUES(:tarefa);
    ';

    $stmt = $this->conexao->prepare($query);
    $stmt->bindValue(':tarefa',  $this->tarefa->__get('tarefa'));
    $stmt->execute();
  }

  public function recuperar()
  {
    $query = '
      SELECT 
        t.id, s.status, t.tarefa 
      FROM tb_tarefas as t
      LEFT JOIN tb_status as s ON (t.id_status = s.id)
      ORDER BY t.data_cadastrado DESC;
    ';

    $stmt = $this->conexao->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function atualizar()
  {
    $query = '
      UPDATE tb_tarefas SET tarefa = ? WHERE id = ?;
    ';

    $stmt = $this->conexao->prepare($query);
    $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
    $stmt->bindValue(2, $this->tarefa->__get('id'));
    return $stmt->execute();
  }

  public function remover()
  {
    $query = '
      DELETE FROM tb_tarefas WHERE id = ?;
    ';

    $stmt = $this->conexao->prepare($query);
    $stmt->bindValue(1, $this->tarefa->__get('id'));

    return $stmt->execute();
  }

  public function realizada()
  {
    $query = '
      UPDATE tb_tarefas SET id_status = ? WHERE id = ?;
    ';

    $stmt = $this->conexao->prepare($query);
    $stmt->bindValue(1, $this->tarefa->__get('id_status'));
    $stmt->bindValue(2, $this->tarefa->__get('id'));
    return $stmt->execute();
  }

  public function pendentes()
  {
    $query = '
      SELECT t.id, t.tarefa, s.status 
      FROM tb_tarefas AS t
      LEFT JOIN tb_status AS s ON (t.id_status = s.id)
      WHERE s.status = "pendente"
      ORDER BY t.data_cadastrado DESC;
    ';

    $stmt = $this->conexao->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
