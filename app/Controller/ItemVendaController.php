<?php

namespace App\Controller;

use App\DAO\ItemVendaDAO;
use App\Model\ItemVenda;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ItemVendaController {

    public function listar(Request $request, Response $response): Response {
        $dao = new ItemVendaDAO();
        $categoria = $dao->listar();
        $response->getBody()->write(json_encode($categoria));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new ItemVendaDAO();
        $categoria = $dao->listarPorId($id);

        if (!$categoria) {
            $response->getBody()->write(json_encode(['erro' => 'Item Venda não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($categoria));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $categoria = new ItemVenda($data);

        $dao = new ItemVendaDAO();
        $sucesso = $dao->inserir($categoria);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Item Venda criado com sucesso'] : ['erro' => 'Erro ao criar categoria'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $categoria = new ItemVenda($data);
        $categoria->setId($id);

        $dao = new ItemVendaDAO();
        $sucesso = $dao->atualizar($categoria);

        $mensagem = $sucesso ? ['mensagem' => 'Item Venda atualizado com sucesso'] : ['erro' => 'Erro ao atualizar categoria'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new ItemVendaDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Item Venda deletado com sucesso'] : ['erro' => 'Erro ao deletar categoria'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
