<?php
 require_once 'DataBase.php';
 require_once 'Tags.php';

 class TagsDAO{

    private $pdo;
    private $erro;

    public function getErro(){
        return $this->erro;
    }

    public function __construct()
    {
        try {
            $this->pdo = (new DataBase())->connection();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
            die;
        }
    }

    public function insert(Tags $tags): Tags|bool{
    $stmt = $this->pdo->prepare("INSERT INTO tags (nome) VALUES (:nome)");
    try {
        $stmt->execute(['nome' => $tags->nome]);
        return $this->selectById($this->pdo->lastInsertId());
    } catch (\PDOException $e) {
        $this->erro = 'Erro ao inserir tag: ' . $e->getMessage();
        return false;
    }
}

public function selectById($id): Tags|bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tags WHERE tags.id = :id");
        try {
            if($stmt->execute(['id'=>$id])){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return (new Tags(true, $row['id'],$row['nome'], $row['creation_time'], $row['modification_time']));
            }
            return false;   

        } catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar tags: ' . $e->getMessage();
            return false;
        }
    }

    public function listarTodos(){
        $cmdSql = "SELECT * FROM tags";
        $cx = $this->pdo->prepare($cmdSql);
        $cx->execute();
        if($cx->rowCount() > 0){
            $cx->setFetchMode(PDO::FETCH_CLASS, 'Tags');
            return $cx->fetchAll();
        }
        return false;
    }


    public function select($filtro=""):array|bool{
        $cmdSql = 'SELECT * FROM tags WHERE   nome LIKE :nome ';
        try{
            $cx = $this->pdo->prepare($cmdSql);
            $cx->bindValue(':nome',"%$filtro%");
            $cx->execute();
            $cx->setFetchMode(PDO::FETCH_CLASS, 'Tags');
            return $cx->fetchAll();
        }
        catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar tags: ' . $e->getMessage();
            return false;
        }
    }

    public function selectByNome($nome="")
    {
        $stmt = $this->pdo->prepare("SELECT * FROm WHERE nome LIKE :nome");
        $nome = '%' . $nome . '%';
        try {
            $stmt->execute(['nome'=>$nome]);
            return $stmt->fetchAll(PDO::FETCH_CLASS,"Tags");
            // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $usuarios = [];
            // foreach ($rows as $row) {
            //     $usuarios[] = new Usuario($row['id'], $row['email'], $row['senha'], $row['nome'], $row['foto'], $row['tel'], $row['endereco'], $row['cpf'], $row['creation_time'], $row['modification_time']);
            // }
            // return $usuarios;
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar tags por nome: ' . $e->getMessage());
        }
    }

    public function update(Usuario $usuario)
    {
        $stmt = $this->pdo->prepare("UPDATE tags SET  nome = ? WHERE id = ?");
        $nome = $usuario->nome;
        $id = $usuario->id;
        try {
            $stmt->execute([ $nome, $id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Erro ao atualizar tags: ' . $e->getMessage());
        }
    }

    
    public function deleteById($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tags WHERE id = ?");
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Erro ao excluir tags: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
 }
 