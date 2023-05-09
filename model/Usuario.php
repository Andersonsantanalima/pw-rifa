<?php

class Usuario {
  private int     $id;
  private string  $email;
  private string  $senha;
  private string  $nome;
  private string  $foto;
  private string  $tel;
  private string  $endereco;
  private string  $cpf;
  private string  $creation_time;
  private string  $modification_time;

  // public function __construct($id=1, $email="", $senha="", $nome="", $foto="", $tel="", $endereco="", $cpf="", $creation_time="", $modification_time="") {
  //   $this->id = $id;
  //   $this->email = $email;
  //   $this->senha = $senha;
  //   $this->nome = $nome;
  //   $this->foto = $foto;
  //   $this->tel = $tel;
  //   $this->endereco = $endereco;
  //   $this->cpf = $cpf;
  //   $this->creation_time = $creation_time;
  //   $this->modification_time = $modification_time;
  // }



  // Getters e Setters
  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getSenha() {
    return $this->senha;
  }

  public function setSenha($senha) {
    $this->senha = $senha;
  }

  public function getNome() {
    return $this->nome;
  }

  public function setNome($nome) {
    $this->nome = $nome;
  }

  public function getFoto() {
    return $this->foto;
  }

  public function setFoto($foto) {
    $this->foto = $foto;
  }

  public function getTel() {
    return $this->tel;
  }

  public function setTel($tel) {
    $this->tel = $tel;
  }

  public function getEndereco() {
    return $this->endereco;
  }

  public function setEndereco($endereco) {
    $this->endereco = $endereco;
  }

  public function getCpf() {
    return $this->cpf;
  }

  public function setCpf($cpf) {
    $this->cpf = $cpf;
  }

  public function getCreationTime() {
    return $this->creation_time;
  }

  public function setCreationTime($creation_time) {
    $this->creation_time = $creation_time;
  }

  public function getModificationTime() {
    return $this->modification_time;
  }

  public function setModificationTime($modification_time) {
    $this->modification_time = $modification_time;
  }

  // public function cadastrar(){
    
  //   require_once 'DataBase.php';
  //   $conexao = (new DataBase())->connection();
  //   $query = "INSERT INTO usuarios (email, senha, nome, foto, tel, endereco, cpf, creation_time, modification_time)
  //             VALUES (:email, :senha, :nome, :foto, :tel, :endereco, :cpf, :creation_time, :modification_time)";

  //   $stmt = $conexao->prepare($query);
  //   $stmt->bindValue(':email', $this->getEmail());
  //   $stmt->bindValue(':senha', $this->getSenha());
  //   $stmt->bindValue(':nome', $this->getNome());
  //   $stmt->bindValue(':foto', $this->getFoto());
  //   $stmt->bindValue(':tel', $this->getTel());
  //   $stmt->bindValue(':endereco', $this->getEndereco());
  //   $stmt->bindValue(':cpf', $this->getCpf());
  //   $stmt->bindValue(':creation_time', $this->getCreationTime());
  //   $stmt->bindValue(':modification_time', $this->getModificationTime());

  //   $resultado = $stmt->execute();

  //   if ($resultado) {
  //     $this->setId($conexao->lastInsertId());
  //     return true;
  //   } else {
  //     return false;
  //   }
  // }
}
