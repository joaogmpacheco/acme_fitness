<?php
namespace App\Model;
use JsonSerializable;

class Endereco implements JsonSerializable{
    private ?int $id;
    private string $logradouro;
    private string $cidade;
    private string $bairro;
    private string $numero;
    private string $cep;
    private string $complemento;
    private int $clienteId;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getLogradouro(){
        return $this->logradouro;
    }
    public function getCidade(){
        return $this->cidade;
    }
    public function getBairro(){
        return $this->bairro;
    }
    public function getNumero(){
        return $this->numero;
    }
    public function getCep(){
        return $this->cep;
    }
    public function getComplemento(){
        return $this->complemento;
    }
    public function getClienteId(){
        return $this->clienteId;
    }

    /*Setters*/
    public function setId(int $id): void{
        $this->id = $id;
    }
    public function setLogradouro(string $logradouro): void{
        $this->logradouro = $logradouro;
    }
    public function setCidade(string $cidade): void{
        $this->cidade = $cidade;
    }
    public function setBairro(string $bairro): void{
        $this->bairro = $bairro;
    }
    public function setNumero(int $numero): void{
        $this->numero = $numero;
    }
    public function setCep(string $cep): void{
        $this->cep = $cep;
    }
    public function setComplemento(string $complemento): void{
        $this->complemento = $complemento;
    }
    public function setClienteId(int $clienteId): void{
        if ($clienteId <= 0) {
            throw new \InvalidArgumentException("Cliente inválido");
        }
        $this->clienteId = $clienteId;
    }
    public function __construct(array $data = []){
        if(!empty($data)){
            $this->id = $data['id'] ?? null;
            $this->setLogradouro($data['logradouro'] ?? '');
            $this->setCidade($data['cidade'] ?? '');
            $this->setBairro($data['bairro'] ?? '');
            $this->setNumero($data['numero'] ?? '');
            $this->setCep($data['cep'] ?? '');
            $this->setComplemento($data['complemento'] ?? '');
            $this->setClienteId((int)($data['clienteId'] ?? 0));
        }
    }

    public function jsonSerialize(){
        return $this->toArray();
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'logradouro' => $this->logradouro,
            'cidade' => $this->cidade,
            'bairro' => $this->bairro,
            'cep'=> $this->cep,
            'complemento'=> $this->complemento,
            'clienteId'=> $this->clienteId,
        ];
    }

}

?>