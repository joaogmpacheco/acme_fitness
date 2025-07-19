<?php
namespace App\Model;
use JsonSerializable;
class Venda implements JsonSerializable{
    private ?int $id;
    private int $clienteId;
    private int $enderecoId;
    private float $valorFrete;
    private float $valorTotal;
    private string $formaPagamento;
    private array $formaPagamentoValidas;//Não está na tabela.
    private float $desconto;
    private string $data_venda;

    /*Getters*/
    public function getId(){
        return $this->id;
    }
    public function getClienteId(){
        return $this->clienteId;
    }
    public function getFormaPagamento(){
        return $this->formaPagamento;
    }
    public function getEnderecoId(){
        return $this->enderecoId;
    }
    public function getValorFrete(){
        return $this->valorFrete;
    }
    public function getValorTotal(){
        return $this->valorTotal;
    }
    public function getDesconto(){
        return $this->desconto;
    }
    public function getDataVenda(){
        return $this->data_venda;
    }

    /*Setters*/
    public function setId(int $id){
        $this->id = $id;
    }
    public function setClienteId(int $clienteId){
        if ($clienteId <= 0) {
            throw new \InvalidArgumentException("Cliente inválida");
        }
        $this->clienteId = $clienteId;
    }

    public function setEnderecoId(int $enderecoId){
        $this->enderecoId = $enderecoId;
    }
    public function setValorFrete(float $valorFrete){
        $this->valorFrete = $valorFrete;
    }
    public function setValorTotal(float $valorTotal){
        $this->valorTotal = $valorTotal;
    }
    public function setDesconto(float $desconto){
        $this->desconto = $desconto;
    }
    public function setDataVenda(string $data_venda){
        $this->data_venda = $data_venda;
    }
    public function setFormaPagamento(string $formaPagamento){
        $formaPagamentoValidas = ['pix', 'boleto', 'cartao'];
        $formaPagamento = strtolower($formaPagamento);

        if (in_array($formaPagamento, $this->formaPagamentoValidas, true)) {
            $this->formaPagamento = $formaPagamento;

            $this->desconto = ($formaPagamento === 'pix' ) ? 0.10:0.0;

        }else{
            throw new \InvalidArgumentException("Forma de pagamento inválida: $formaPagamento");
        }
        $this->formaPagamento = $formaPagamento;
    }
    public function calcularValorTotal(float $valorTotal, float $desconto){
        $this->valorTotal = $valorTotal*$desconto;
    }

    public function jsonSerialize(){
        return $this->toArray();
    }

    public function __construct(array $data = []){
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->setClienteId((int)($data['clienteId'] ?? 0));
            $this->setEnderecoId((int)($data['enderecoId'] ?? 0));
            $this->setValorFrete((float)($data['valorFrete'] ?? 0));
            $this->calcularValorTotal((float)($data['valorTotal'] ?? 0), (float)($data['desconto'] ?? 0));
            $this->setDesconto((float)($data['desconto'] ?? 0));
            $this->setFormaPagamento($data['formaPagamento'] ?? '');
            $this->setDataVenda($data['data_venda'] ?? date('Y-m-d'));
        }
    }

    public function toArray(): array {
        return [
            'id'    => $this->id,
            'clienteId'  => $this->clienteId,
            'enderecoId' => $this->enderecoId,
            'valorTotal' => $this->valorTotal,
            'valorFrete' => $this->valorFrete,
            'desconto' => $this->desconto,
            'formaPagamento' => $this->formaPagamento,
            'data_venda' => $this->data_venda,
        ];
    }
}