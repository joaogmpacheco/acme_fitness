<?php

namespace App\Controller;

use App\DAO\VariacaoProdutoDAO;
use App\Model\VariacaoProduto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VariacaoProdutoController {

    public function listar(Request $request, Response $response): Response {
        $dao = new VariacaoProdutoDAO();
        $variacaoProduto = $dao->listar();
        $response->getBody()->write(json_encode($variacaoProduto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new VariacaoProdutoDAO();
        $variacaoProduto = $dao->listarPorId($id);

        if (!$variacaoProduto) {
            $response->getBody()->write(json_encode(['erro' => 'Variacao Produto não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($variacaoProduto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $variacaoProduto = new VariacaoProduto($data);

        $dao = new VariacaoProdutoDAO();
        $sucesso = $dao->inserir($variacaoProduto);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Variacao Produto criado com sucesso'] : ['erro' => 'Erro ao criar variacaoProduto'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $variacaoProduto = new VariacaoProduto($data);
        $variacaoProduto->setId($id);

        $dao = new VariacaoProdutoDAO();
        $sucesso = $dao->atualizar($variacaoProduto);

        $mensagem = $sucesso ? ['mensagem' => 'Variacao Produto atualizado com sucesso'] : ['erro' => 'Erro ao atualizar variacaoProduto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new VariacaoProdutoDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Variacao Produto deletado com sucesso'] : ['erro' => 'Erro ao deletar variacaoProduto'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}