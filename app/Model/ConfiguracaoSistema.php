<?php

namespace App\Model;
use JsonSerializable;

class ConfiguracaoSistema implements JsonSerializable{
    private ?int $id;
    private float $valorFretePadrao;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getValorFretePadrao(){
        return $this->valorFretePadrao;
    }

    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setValorFretePadrao(float $valorFretePadrao){
        $this->valorFretePadrao = $valorFretePadrao;
    }

    public function __construct($data = []){
        $this->id = $data['id'] ?? null;
        $this->setValorFretePadrao((float)($data['valorFretePadrao'] ?? 0));
    }
    public function toArray(): array {
        return [
            'id'    => $this->id,
            'valorFretePadrao'  => $this->valorFretePadrao,
        ];
    }
}