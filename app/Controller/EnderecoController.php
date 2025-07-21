<?php

namespace App\Controller;

use App\Service\EnderecoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EnderecoController {

    private EnderecoService $enderecoService;

    public function __construct(EnderecoService $enderecoService) {
        $this->enderecoService = $enderecoService;
    }

    public function listar(Request $request, Response $response): Response {
        $endereco = $this->enderecoService->listar();
        $response->getBody()->write(json_encode($endereco));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $endereco = $this->enderecoService->listarPorId($id);

        if (!$endereco) {
            $response->getBody()->write(json_encode(['erro' => 'Endereco não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($endereco));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->enderecoService->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Endereco criado com sucesso'] : ['erro' => 'Erro ao criar endereco'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $sucesso = $this->enderecoService->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco atualizado com sucesso'] : ['erro' => 'Erro ao atualizar endereco'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->enderecoService->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco deletado com sucesso'] : ['erro' => 'Erro ao deletar endereco'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
