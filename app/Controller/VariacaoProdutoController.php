<?php

namespace App\Controller;

use App\Service\VariacaoProdutoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VariacaoProdutoController {

    private VariacaoProdutoService $variacaoProdutoService;

    public function __construct(VariacaoProdutoService $variacaoProdutoService) {
        $this->variacaoProdutoService = $variacaoProdutoService;
    }

    public function listar(Request $request, Response $response): Response {
        $variacaoProduto = $this->variacaoProdutoService->listar();
        $response->getBody()->write(json_encode($variacaoProduto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $variacaoProduto = $this->variacaoProdutoService->listarPorId($id);

        if (!$variacaoProduto) {
            $response->getBody()->write(json_encode(['erro' => 'VariacaoProduto não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($variacaoProduto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->variacaoProdutoService->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'VariacaoProduto criado com sucesso'] : ['erro' => 'Erro ao criar VariacaoProduto'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $sucesso = $this->variacaoProdutoService->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'VariacaoProduto atualizado com sucesso'] : ['erro' => 'Erro ao atualizar VariacaoProduto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->variacaoProdutoService->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'VariacaoProduto deletado com sucesso'] : ['erro' => 'Erro ao deletar VariacaoProduto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}