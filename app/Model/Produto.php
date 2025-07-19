<?php

namespace App\Model;
use JsonSerializable;

class Produto implements JsonSerializable{
    private ?int $id;
    private string $nome;
    private string $imagem;
    private float $precoBase;
    private string $cor;
    private string $data_cadastro;
    private float $peso;
    private string $descricao;
    private ?int $categoria_id;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->setNome($data['nome'] ?? '');
            $this->setImagem($data['image'] ?? '');
            $this->setPrecoBase($data['precoBase'] ?? 0);
            $this->setCor($data['cor'] ?? '');
            $this->setPeso((float)($data['peso'] ?? 0));
            $this->setDataCadastro($data['data_cadastro'] ?? date('Y-m-d'));
            $this->setDescricao($data['descricao'] ?? '');
            $this->setCategoriaId((int)($data['categoria_id'] ?? 0));
        }
    }

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getImagem(){
        return $this->imagem;
    }
    public function getPrecoBase(){
        return $this->precoBase;
    }
    public function getCor(){
        return $this->cor;
    }
    public function getDataCadastro(){
        return $this->data_cadastro;
    }
    public function getPeso(){
        return $this->peso;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function getCategoriaId(){
        return $this->categoria_id;
    }


    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setNome(string $nome){
        $this->nome = $nome;
    }
    public function setImagem(string $imagem){
        $this->imagem = $imagem;
    }
    public function setPrecoBase(float $precoBase){
        $this->precoBase = $precoBase;
    }
    public function setCor(string $cor){
        $this->cor = $cor;
    }
    public function setDataCadastro(string $data_cadastro){
        $this->data_cadastro = $data_cadastro;
    }
    public function setPeso(float $peso){
        if ($peso <= 0) {
            throw new \InvalidArgumentException("Peso inválido");
        }
        $this->peso = $peso;
    }
    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }
    public function setCategoriaId(int $categoria_id): void {
        if ($categoria_id <= 0) {
            throw new \InvalidArgumentException("Categoria inválida");
        }
        $this->categoria_id = $categoria_id;
    }

    public function toArray(): array {
        return [
            'id'    => $this->id,
            'name'  => $this->nome,
            'imagem'=> $this->imagem,
            'precoBase'=> $this->precoBase,
            'cor' => $this->cor,
            'descricao' => $this->descricao,
            'peso' => $this->peso,
            'data_cadastro' => $this->data_cadastro,
        ];
    }
}