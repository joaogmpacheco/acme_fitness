<?php

namespace App\Controller;

use App\DAO\CategoriaDAO;
use App\Model\Categoria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriaController {

    public function listar(Request $request, Response $response): Response {
        $dao = new CategoriaDAO();
        $categoria = $dao->listar();
        $response->getBody()->write(json_encode($categoria));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new CategoriaDAO();
        $categoria = $dao->listarPorId($id);

        if (!$categoria) {
            $response->getBody()->write(json_encode(['erro' => 'Categoria não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($categoria));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $categoria = new Categoria($data);

        $dao = new CategoriaDAO();
        $sucesso = $dao->inserir($categoria);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Categoria criado com sucesso'] : ['erro' => 'Erro ao criar categoria'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $categoria = new Categoria($data);
        $categoria->setId($id);

        $dao = new CategoriaDAO();
        $sucesso = $dao->atualizar($categoria);

        $mensagem = $sucesso ? ['mensagem' => 'Categoria atualizado com sucesso'] : ['erro' => 'Erro ao atualizar categoria'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new CategoriaDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Categoria deletado com sucesso'] : ['erro' => 'Erro ao deletar categoria'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
