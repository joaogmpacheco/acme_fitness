<?php
namespace App\Controller;

use App\Service\CategoriaService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriaController {
    private CategoriaService $service;

    public function __construct(CategoriaService $service) {
        $this->service = $service;
    }

    public function listar(Request $request, Response $response): Response {
        $categorias = $this->service->listar();
        $response->getBody()->write(json_encode($categorias));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $categoria = $this->service->listarPorId($id);

        if (!$categoria) {
            $response->getBody()->write(json_encode(['erro' => 'Categoria não encontrada']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($categoria));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $sucesso = $this->service->criar($data);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Categoria criada com sucesso'] : ['erro' => 'Erro ao criar categoria'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();
        $sucesso = $this->service->atualizar($id, $data);

        $mensagem = $sucesso ? ['mensagem' => 'Categoria atualizada com sucesso'] : ['erro' => 'Erro ao atualizar categoria'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $sucesso = $this->service->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Categoria deletada com sucesso'] : ['erro' => 'Erro ao deletar categoria'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
