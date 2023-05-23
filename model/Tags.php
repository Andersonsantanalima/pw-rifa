<?php
class Tags{
    public int     $id;
    public string  $nome;
    public string  $creation_time;
    public string  $modification_time;

    public function __construct($c=0, $id=0, $nome="", $creation_time="", $modification_time="") {
      if($c){
        $this->id = $id;
        $this->nome = $nome;
        $this->creation_time = $creation_time;
        $this->modification_time = $modification_time;
        } 
    }
}