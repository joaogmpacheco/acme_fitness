<?php

namespace App\Controller;

use App\Service\VendaService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VendaController {

    private VendaService $vendaService;

    public function __construct(VendaService $vendaService) {
        $this->vendaService = $vendaService;
    }

    public function listar(Request $request, Response $response): Response {
        $venda = $this->vendaService->listar();
        $response->getBody()->write(json_encode($venda));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $venda = $this->vendaService->listarPorId($id);

        if (!$venda) {
            $response->getBody()->write(json_encode(['erro' => 'Venda não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($venda));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->vendaService->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Venda criado com sucesso'] : ['erro' => 'Erro ao criar Venda'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $sucesso = $this->vendaService->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'Venda atualizado com sucesso'] : ['erro' => 'Erro ao atualizar Venda'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->vendaService->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Venda deletado com sucesso'] : ['erro' => 'Erro ao deletar Venda'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}