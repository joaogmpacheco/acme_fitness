<?php

namespace App\Model;

use JsonSerializable;

class Categoria implements JsonSerializable{
    private ?int $id;
    private string $nome;
    private string $descricao;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getDescricao(){
        return $this->descricao;
    }

    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setNome(string $nome){
        $this->nome = $nome;
    }
    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }

    public function __construct(array $data = []){
        $this->id = $data['id'] ?? null;
        $this->setNome($data['nome'] ?? '');
        $this->setDescricao($data['descricao'] ?? '');
    }

    public function jsonSerialize(){
        return $this->toArray();
    }

    public function toArray(): array {
        return [
            'id'    => $this->id,
            'nome'  => $this->nome,
            'descricao' => $this->descricao,
        ];
    }
}