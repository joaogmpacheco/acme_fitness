<?php

namespace App\Controller;

use App\Service\ConfiguracaoSistemaService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConfiguracaoSistemaController {

    private ConfiguracaoSistemaService $configuracaoSistemaService;

    public function __construct(ConfiguracaoSistemaService $configuracaoSistemaService) {
        $this->configuracaoSistemaService = $configuracaoSistemaService;
    }

    public function listar(Request $request, Response $response): Response {
        $configuracaoSistemas = $this->configuracaoSistemaService->listar();
        $response->getBody()->write(json_encode($configuracaoSistemas));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $configuracaoSistema = $this->configuracaoSistemaService->listarPorId($id);

        if (!$configuracaoSistema) {
            $response->getBody()->write(json_encode(['erro' => 'ConfiguracaoSistema não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($configuracaoSistema));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->configuracaoSistemaService->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'ConfiguracaoSistema criado com sucesso'] : ['erro' => 'Erro ao criar configuracaoSistema'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $sucesso = $this->configuracaoSistemaService->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'ConfiguracaoSistema atualizado com sucesso'] : ['erro' => 'Erro ao atualizar configuracaoSistema'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->configuracaoSistemaService->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'ConfiguracaoSistema deletado com sucesso'] : ['erro' => 'Erro ao deletar configuracaoSistema'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
