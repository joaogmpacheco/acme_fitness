<?php

namespace App\Controller;

use App\DAO\EnderecoDAO;
use App\Model\Endereco;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EnderecoController {

    public function listar(Request $request, Response $response): Response {
        $dao = new EnderecoDAO();
        $endereco = $dao->listar();
        $response->getBody()->write(json_encode($endereco));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new EnderecoDAO();
        $endereco = $dao->listarPorId($id);

        if (!$endereco) {
            $response->getBody()->write(json_encode(['erro' => 'Endereco não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($endereco));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $endereco = new Endereco($data);

        $dao = new EnderecoDAO();
        $sucesso = $dao->inserir($endereco);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Endereco criado com sucesso'] : ['erro' => 'Erro ao criar endereco'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $endereco = new Endereco($data);
        $endereco->setId($id);

        $dao = new EnderecoDAO();
        $sucesso = $dao->atualizar($endereco);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco atualizado com sucesso'] : ['erro' => 'Erro ao atualizar endereco'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new EnderecoDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Endereco deletado com sucesso'] : ['erro' => 'Erro ao deletar endereco'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
