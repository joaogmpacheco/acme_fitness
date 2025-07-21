<?php

namespace App\Controller;

use App\Service\ItemVendaService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ItemVendaController {

    private ItemVendaService $itemVendaService;

    public function __construct(ItemVendaService $itemVendaService) {
        $this->itemVendaService = $itemVendaService;
    }

    public function listar(Request $request, Response $response): Response {
        $itemVenda = $this->itemVendaService->listar();
        $response->getBody()->write(json_encode($itemVenda));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $itemVenda = $this->itemVendaService->listarPorId($id);

        if (!$itemVenda) {
            $response->getBody()->write(json_encode(['erro' => 'Endereco não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($itemVenda));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->itemVendaService->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Endereco criado com sucesso'] : ['erro' => 'Erro ao criar itemVenda'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $sucesso = $this->itemVendaService->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco atualizado com sucesso'] : ['erro' => 'Erro ao atualizar itemVenda'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->itemVendaService->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco deletado com sucesso'] : ['erro' => 'Erro ao deletar itemVenda'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
