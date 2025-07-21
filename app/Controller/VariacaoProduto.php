<?php

namespace App\Controller;

use App\Service\VariacaoProdutoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VariacaoProdutoController {

    private VariacaoProdutoService $variacaoprodutoService;

    public function __construct(VariacaoProdutoService $variacaoprodutoService) {
        $this->variacaoProdutoService = $variacaoprodutoService;
    }

    public function listar(Request $request, Response $response): Response {
        $variacaoproduto = $this->variacaoProdutoService->listar();
        $response->getBody()->write(json_encode($variacaoproduto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $variacaoproduto = $this->variacaoprodutoService->listarPorId($id);

        if (!$variacaoproduto) {
            $response->getBody()->write(json_encode(['erro' => 'Produto não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($variacaoproduto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->variacaoprodutoService->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Produto criado com sucesso'] : ['erro' => 'Erro ao criar produto'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $sucesso = $this->variacaoprodutoService->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'Produto atualizado com sucesso'] : ['erro' => 'Erro ao atualizar produto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->produtoService->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco deletado com sucesso'] : ['erro' => 'Erro ao deletar produto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}