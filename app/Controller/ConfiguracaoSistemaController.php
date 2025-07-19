<?php

namespace App\Controller;

use App\DAO\ConfiguracaoSistemaDAO;
use App\Model\ConfiguracaoSistema;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConfiguracaoSistemaController {

    public function listar(Request $request, Response $response): Response {
        $dao = new ConfiguracaoSistemaDAO();
        $configuracaoSistema = $dao->listar();
        $response->getBody()->write(json_encode($configuracaoSistema));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $dao = new ConfiguracaoSistemaDAO();
        $configuracaoSistema = $dao->listarPorId($id);

        if (!$configuracaoSistema) {
            $response->getBody()->write(json_encode(['erro' => 'Configuração Sistema não encontrado']));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($configuracaoSistema));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function criar(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $configuracaoSistema = new ConfiguracaoSistema($data);

        $dao = new ConfiguracaoSistemaDAO();
        $sucesso = $dao->inserir($configuracaoSistema);

        $status = $sucesso ? 201 : 500;
        $mensagem = $sucesso ? ['mensagem' => 'Configuração Sistema criado com sucesso'] : ['erro' => 'Erro ao criar configuracaoSistema'];

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function atualizar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $configuracaoSistema = new ConfiguracaoSistema($data);
        $configuracaoSistema->setId($id);

        $dao = new ConfiguracaoSistemaDAO();
        $sucesso = $dao->atualizar($configuracaoSistema);

        $mensagem = $sucesso ? ['mensagem' => 'Configuração Sistema atualizado com sucesso'] : ['erro' => 'Erro ao atualizar configuracaoSistema'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }

    public function deletar(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id'];

        $dao = new ConfiguracaoSistemaDAO();
        $sucesso = $dao->deletar($id);

        $mensagem = $sucesso ? ['mensagem' => 'Configuracao Sistema deletado com sucesso'] : ['erro' => 'Erro ao deletar configuracaoSistema'];
        $status = $sucesso ? 200 : 500;

        $response->getBody()->write(json_encode($mensagem));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
