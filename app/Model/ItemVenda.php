<?php
namespace App\Model;
use JsonSerializable;

class ItemVenda implements JsonSerializable{
    private ?int $id;
    private int $vendaId;
    private int $variacaoId;
    private float $precoVenda;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getVendaId(){
        return $this->vendaId;
    }
    public function getVariacaoId(){
        return $this->variacaoId;
    }
    public function getPrecoVenda(){
        return $this->precoVenda;
    }

    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setVendaId(int $vendaId){
        if ($vendaId <= 0) {
            throw new \InvalidArgumentException("Venda inválida");
        }
        $this->vendaId = $vendaId;
    }
    public function setVariacaoId(int $variacaoId){
        if ($variacaoId <= 0) {
            throw new \InvalidArgumentException("Variacão inválida");
        }
        $this->variacaoId = $variacaoId;
    }
    public function setPrecoVenda(float $precoVenda){
        $this->precoVenda = $precoVenda;
    }

    public function __construct(array $data = []){
        if(!empty($data)){
            $this->id = $data["id"] ?? null;
            $this->setVendaId((int)($data["vendaId"] ?? 0));
            $this->setVariacaoId((int)($data["variacaoId"] ?? 0));
            $this->setPrecoVenda((float)($data["precoVenda"] ?? 0));
        }
    }
    public function jsonSerialize(){
        return $this->toArray();
    }

    public function toArray(): array {
        return [
            'id'    => $this->id,
            'vendaId'=> $this->vendaId,
            'variacaoId'=> $this->variacaoId,
            'precoVenda'=> $this->precoVenda
        ];
    }


}

?>