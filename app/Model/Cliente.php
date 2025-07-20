<?php
namespace App\Model;
use JsonSerializable;

class Cliente implements JsonSerializable{
    private ?int $id;
    private string $nomeCompleto;
    private string $cpf;
    private string $dataNascimento;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getNomeCompleto(){
        return $this->nomeCompleto;
    }
    public function getCpf(){
        return $this->cpf;
    }
    public function getDataNascimento(){
        return $this->dataNascimento;
    }

    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setNomeCompleto(string $nomeCompleto){
        $this->nomeCompleto = $nomeCompleto;
    }
    public function setCpf(string $cpf){
        $this->cpf = $cpf;
    }
    public function setDataNascimento(string $dataNascimento){
        $this->dataNascimento = $dataNascimento;
    }

    public function __construct(array $data = []){
        if(!empty($data)){
            $this->id = $data['id'] ?? null;
            $this->setNomeCompleto($data['nomeCompleto'] ?? '');
            $this->setCpf($data['cpf'] ?? '');
            $this->setDataNascimento($data['dataNascimento'] ?? '');
        }
    }

    public function jsonSerialize(){
        return $this->toArray();
    }

    public function toArray(): array {
        return [
            'id'    => $this->id,
            'nomeCompleto'  => $this->nomeCompleto,
            'cpf' => $this->cpf,
            'dataNascimento' => $this->dataNascimento,
        ];
    }
}