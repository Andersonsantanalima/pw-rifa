<?php
require_once 'DataBase.php';
require_once 'Usuario.php';
class UsuarioDAO
{
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



    public function insert(Usuario $usuario): Usuario|bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO Usuario (email, senha, nome, foto, tel, endereco, cpf) VALUES (:email,:senha,:nome,:foto,:tel,:endereco,:cpf)");
        $dados = [
            'email'     => $usuario->getEmail(),
            'senha'     => $usuario->getSenha(),
            'nome'      => $usuario->getNome(),
            'foto'      => $usuario->getFoto(),
            'tel'       => $usuario->getTel(),
            'endereco'  => $usuario->getEndereco(),
            'cpf'       => $usuario->getCpf()
        ];
        try {
            $stmt->execute($dados);
            return $this->selectById($this->pdo->lastInsertId());
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao inserir usuário: ' . $e->getMessage();
            return false;
        }
    }

    public function selectById($id): Usuario|bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuario WHERE Usuario.id = :id");
        try {
            if($stmt->execute(['id'=>$id])){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return (new Usuario($row['id'], $row['email'], $row['senha'], $row['nome'], $row['foto'], $row['tel'], $row['endereco'], $row['cpf'], $row['creation_time'], $row['modification_time']));
            }
            return false;   

        } catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar usuário: ' . $e->getMessage();
            return false;
        }
    }

    public function listarTodos(){
        $cmdSql = "SELECT * FROM Usuario";
        $cx = $this->pdo->prepare($cmdSql);
        $cx->execute();
        if($cx->rowCount() > 0){
            $cx->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            return $cx->fetchAll();
        }
        return false;
    }

    public function select($filtro=""){
        $cmdSql = "SELECT * FROM usuario WHERE email LIKE '%%' OR nome LIKE '%%' or cpf LIKE '%%' or tel LIKE '%%'";
        $cx = $this->pdo->prepare($cmdSql);
        $cx->bindValue('email',"%$filtro%");
        $cx->bindValue('nome',"%$filtro%");
        $cx->bindValue('cpf',"%$filtro%");
        $cx->bindValue('tel',"%$filtro%");

        $cx->execute();
        if ($cx->rowCont()>0) {
            $cx->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            return $cx->fetchAll();
        }    
       return false;




    }

    public function selectByNome($nome="")
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuario WHERE nome LIKE :nome");
        $nome = '%' . $nome . '%';
        try {
            $stmt->execute(['nome'=>$nome]);
            return $stmt->fetchAll(PDO::FETCH_CLASS,"Usuario");
            // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $usuarios = [];
            // foreach ($rows as $row) {
            //     $usuarios[] = new Usuario($row['id'], $row['email'], $row['senha'], $row['nome'], $row['foto'], $row['tel'], $row['endereco'], $row['cpf'], $row['creation_time'], $row['modification_time']);
            // }
            // return $usuarios;
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar usuários por nome: ' . $e->getMessage());
        }
    }
      

    public function update(Usuario $usuario)
    {
        $stmt = $this->pdo->prepare("UPDATE Usuario SET email = ?, senha = ?, nome = ?, foto = ?, tel = ?, endereco = ?, cpf = ? WHERE id = ?");
        $email = $usuario->getEmail();
        $senha = $usuario->getSenha();
        $nome = $usuario->getNome();
        $foto = $usuario->getFoto();
        $tel = $usuario->getTel();
        $endereco = $usuario->getEndereco();
        $cpf = $usuario->getCpf();
        $id = $usuario->getId();
        try {
            $stmt->execute([$email, $senha, $nome, $foto, $tel, $endereco, $cpf, $id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    public function deleteById($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Usuario WHERE id = ?");
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Erro ao excluir usuário: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
