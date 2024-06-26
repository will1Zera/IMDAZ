<?php

namespace App\Services;

use App\Http\JWT;
use App\Utils\Validator;
use Exception;
use PDOException;
use App\Models\Aluno;

class AlunoService
{
    /**
    * Método estático responsável por buscar alunos.
    *
    * @param mixed $authorization Token.
    *
    * @return array Response.
    */
    public static function index(mixed $authorization)
    {
        try {
            if (isset($authorization['error'])) return ['unauthorized' => $authorization['error']];

            $userFromJWT = JWT::verify($authorization);

            if(!$userFromJWT) return ['unauthorized' => 'Realize o login para acessar esse recurso.'];

            $alunos = Aluno::index();

            if(!$alunos) return ['error' => 'Não foi possível encontrar os alunos.'];

            return $alunos;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === 'HY000') return ['error' => 'Não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Não foi possível encontrar a tabela.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
    * Método estático responsável por buscar um aluno.
    *
    * @param mixed $authorization Token.
    * @param int|string $id Identificador.
    *
    * @return array Response.
    */
    public static function fetch(mixed $authorization, int|string $id)
    {
        try {
            if (isset($authorization['error'])) return ['unauthorized' => $authorization['error']];

            $userFromJWT = JWT::verify($authorization);

            if(!$userFromJWT) return ['unauthorized' => 'Realize o login para acessar esse recurso.'];

            $aluno = Aluno::find($id);

            if(!$aluno) return ['error' => 'Não foi possível encontrar o aluno.'];

            return $aluno;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === 'HY000') return ['error' => 'Não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Não foi possível encontrar a tabela.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
    * Método estático responsável por criar um novo aluno.
    *
    * @param mixed $authorization Token.
    * @param object $data Conjunto de dados.
    *
    * @return array Response.
    */
    public static function create(mixed $authorization, array $data)
    {
        try {
            if (isset($authorization['error'])) return ['unauthorized' => $authorization['error']];

            $userFromJWT = JWT::verify($authorization);

            if(!$userFromJWT) return ['unauthorized' => 'Realize o login para acessar esse recurso.'];

            $fields = Validator::validate([
                'nome' => $data['nome'] ?? '',
                'cep' => $data['cep'] ?? '',
                'rua' => $data['rua'] ?? '',
                'bairro' => $data['bairro'] ?? '',
                'cidade' => $data['cidade'] ?? '',
                'numero' => $data['numero'] ?? '',
                'cpf' => $data['cpf'] ?? '',
                'rg' => $data['rg'] ?? '',
                'emissao_rg' => $data['emissao_rg'] ?? '',
                'nascimento' => $data['nascimento'] ?? '',
                'genero_id' => $data['genero_id'] ?? '',
                'etnia_id' => $data['etnia_id'] ?? '',
                'escola_id' => $data['escola_id'] ?? '',
                'tipo_residencia_id' => $data['tipo_residencia_id'] ?? '',
                'tipo_parentesco_id' => $data['tipo_parentesco_id'] ?? '',
                'nome_responsavel' => $data['nome_responsavel'] ?? '',
                'nome_mae' => $data['nome_mae'] ?? '',
                'alfabetizado' => $data['alfabetizado'] ?? ''
            ]);

            $fields['nis'] = $data['nis'] ?? null;
            $fields['telefone'] = $data['telefone'] ?? null;
            $fields['deficiencias'] = $data['deficiencias'] ?? null;
            $fields['mae_trabalha_fora'] = $data['mae_trabalha_fora'] ?? null;
            $fields['mae_interesse_projetos'] = $data['mae_interesse_projetos'] ?? null;
            $fields['renda_familiar_mensal'] = $data['renda_familiar_mensal'] ?? null;
            $fields['quantidade_filhos'] = $data['quantidade_filhos'] ?? null;
            $fields['possui_irmao_instituicao'] = $data['possui_irmao_instituicao'] ?? null;
            $fields['recebe_bolsa_familia'] = $data['recebe_bolsa_familia'] ?? null;
            $fields['direito_imagem'] = $data['direito_imagem'] ?? null;
            $fields['possui_banheiro'] = $data['possui_banheiro'] ?? null;
            $fields['possui_agua'] = $data['possui_agua'] ?? null;
            $fields['possui_luz'] = $data['possui_luz'] ?? null;
            $fields['nota_fiscal_gaucha'] = $data['nota_fiscal_gaucha'] ?? null;

            $aluno = Aluno::save($fields);

            if (!$aluno) return ['error' => 'Não foi possível criar o aluno.'];

            return "Aluno criado com sucesso!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === 'HY000') return ['error' => 'Não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Não foi possível encontrar a tabela.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
    * Método estático responsável por atualizar um aluno.
    *
    * @param mixed $authorization Token.
    * @param array $data Dados.
    * @param int|string $id Identificador.
    *
    * @return array Response.
    */
    public static function update(mixed $authorization, array $data, int|string $id)
    {
        try {
            if (isset($authorization['error'])) return ['unauthorized' => $authorization['error']];

            $userFromJWT = JWT::verify($authorization);

            if(!$userFromJWT) return ['unauthorized' => 'Realize o login para acessar esse recurso.'];

            $fields = Validator::validate([
                'nome' => $data['nome'] ?? '',
                'cep' => $data['cep'] ?? '',
                'rua' => $data['rua'] ?? '',
                'bairro' => $data['bairro'] ?? '',
                'cidade' => $data['cidade'] ?? '',
                'numero' => $data['numero'] ?? '',
                'cpf' => $data['cpf'] ?? '',
                'rg' => $data['rg'] ?? '',
                'emissao_rg' => $data['emissao_rg'] ?? '',
                'nascimento' => $data['nascimento'] ?? '',
                'genero_id' => $data['genero_id'] ?? '',
                'etnia_id' => $data['etnia_id'] ?? '',
                'escola_id' => $data['escola_id'] ?? '',
                'tipo_residencia_id' => $data['tipo_residencia_id'] ?? '',
                'tipo_parentesco_id' => $data['tipo_parentesco_id'] ?? '',
                'nome_responsavel' => $data['nome_responsavel'] ?? '',
                'nome_mae' => $data['nome_mae'] ?? '',
                'alfabetizado' => $data['alfabetizado'] ?? ''
            ]);

            $fields['nis'] = $data['nis'] ?? null;
            $fields['telefone'] = $data['telefone'] ?? null;
            $fields['deficiencias'] = $data['deficiencias'] ?? null;
            $fields['mae_trabalha_fora'] = $data['mae_trabalha_fora'] ?? null;
            $fields['mae_interesse_projetos'] = $data['mae_interesse_projetos'] ?? null;
            $fields['renda_familiar_mensal'] = $data['renda_familiar_mensal'] ?? null;
            $fields['quantidade_filhos'] = $data['quantidade_filhos'] ?? null;
            $fields['possui_irmao_instituicao'] = $data['possui_irmao_instituicao'] ?? null;
            $fields['recebe_bolsa_familia'] = $data['recebe_bolsa_familia'] ?? null;
            $fields['direito_imagem'] = $data['direito_imagem'] ?? null;
            $fields['possui_banheiro'] = $data['possui_banheiro'] ?? null;
            $fields['possui_agua'] = $data['possui_agua'] ?? null;
            $fields['possui_luz'] = $data['possui_luz'] ?? null;
            $fields['nota_fiscal_gaucha'] = $data['nota_fiscal_gaucha'] ?? null;

            $aluno = Aluno::update($id, $fields);

            if(!$aluno) return ['error' => 'Não foi possível atualizar o aluno.'];

            return "Aluno atualizado com sucesso.";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === 'HY000') return ['error' => 'Não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Não foi possível encontrar a tabela.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
    * Método estático responsável por deletar um aluno.
    *
    * @param mixed $authorization Token.
    * @param int|string $id Identificador.
    *
    * @return array Response.
    */
    public static function delete(mixed $authorization, int|string $id)
    {
        try {
            if (isset($authorization['error'])) return ['unauthorized' => $authorization['error']];
            
            $userFromJWT = JWT::verify($authorization);

            if(!$userFromJWT) return ['unauthorized' => 'Realize o login para acessar esse recurso.'];

            $aluno = Aluno::delete($id);

            if(!$aluno) return ['error' => 'Não foi possível remover o aluno.'];

            return "Aluno removido com sucesso.";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === 'HY000') return ['error' => 'Não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Não foi possível encontrar a tabela.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
    * Método estático responsável por buscar alunos aniversariantes.
    *
    * @param mixed $authorization Token.
    *
    * @return array Response.
    */
    public static function birthday(mixed $authorization)
    {
        try {
            if (isset($authorization['error'])) return ['unauthorized' => $authorization['error']];

            $userFromJWT = JWT::verify($authorization);

            if(!$userFromJWT) return ['unauthorized' => 'Realize o login para acessar esse recurso.'];

            $alunos = Aluno::birthday();

            if(!$alunos) return ['error' => 'Não foi possível encontrar os alunos aniversariantes da semana.'];

            return $alunos;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === 'HY000') return ['error' => 'Não foi possível conectar ao banco de dados.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Não foi possível encontrar a tabela.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}