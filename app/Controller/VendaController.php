<?php

namespace App\Controller;

use App\DAO\VendaDAO;
use App\Model\Venda;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VendaController {

    public function listar(Request $request, Response $response): Response {
        $dao = new VendaDAO();
        $venda = $dao->listar();
        $response->getBody()->write(json_encode($venda));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new VendaDAO();
        $venda = $dao->listarPorId($id);

        if (!$venda) {
            $response->getBody()->write(json_encode(['erro' => 'Venda não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($venda));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $venda = new Venda($data);

        $dao = new VendaDAO();
        $sucesso = $dao->inserir($venda);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Venda criado com sucesso'] : ['erro' => 'Erro ao criar venda'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $venda = new Venda($data);
        $venda->setId($id);

        $dao = new VendaDAO();
        $sucesso = $dao->atualizar($venda);

        $mensagem = $sucesso ? ['mensagem' => 'Venda atualizado com sucesso'] : ['erro' => 'Erro ao atualizar venda'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new VendaDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Venda deletado com sucesso'] : ['erro' => 'Erro ao deletar venda'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
