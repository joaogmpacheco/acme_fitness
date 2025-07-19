<?php

namespace App\Controller;

use App\DAO\ProdutoDAO;
use App\Model\Produto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProdutoController {

    public function listar(Request $request, Response $response): Response {
        $dao = new ProdutoDAO();
        $produtos = $dao->listar();
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new ProdutoDAO();
        $produto = $dao->listarPorId($id);

        if (!$produto) {
            $response->getBody()->write(json_encode(['erro' => 'Produto não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($produto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $produto = new Produto($data);

        $dao = new ProdutoDAO();
        $sucesso = $dao->inserir($produto);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Produto criado com sucesso'] : ['erro' => 'Erro ao criar produto'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $produto = new Produto($data);
        $produto->setId($id);

        $dao = new ProdutoDAO();
        $sucesso = $dao->atualizar($produto);

        $mensagem = $sucesso ? ['mensagem' => 'Produto atualizado com sucesso'] : ['erro' => 'Erro ao atualizar produto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new ProdutoDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Produto deletado com sucesso'] : ['erro' => 'Erro ao deletar produto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
