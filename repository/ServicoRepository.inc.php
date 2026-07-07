<?php
include_once "Repository.inc.php";
include_once "../model/Servico.inc.php";

class ServicoRepository extends Repository
{
    public function listarTodos(string $busca = '', string $categoria = ''): array
    {
        $sqlBase = "SELECT * FROM servico WHERE 1=1";
        $parametros = [];

        if (!empty($busca)) {
            $sqlBase .= " AND (nome LIKE :busca OR idServico = :idBusca)";
            $parametros[':busca'] = "%" . $busca . "%";
            $parametros[':idBusca'] = (int)$busca;
        }

        if (!empty($categoria)) {
            $sqlBase .= " AND categoria = :categoria";
            $parametros[':categoria'] = $categoria;
        }

        $sqlBase .= " ORDER BY nome ASC";

        $sql = $this->con->prepare($sqlBase);

        foreach ($parametros as $chave => $valor) {
            $sql->bindValue($chave, $valor);
        }

        $sql->execute();

        $servicos = [];
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $servicos[] = new Servico(
                $row->nome, 
                (float)$row->valor, 
                $row->unidadeMedida, 
                $row->categoria,
                $row->descricao,
                $row->tamanho, 
                $row->material, 
                $row->tipoMaterial, 
                $row->cor, 
                (int)$row->idServico
            );
        }
        return $servicos;
    }

    public function listarTodasCategorias()
    {
        $sql = $this->con->query("SELECT DISTINCT categoria FROM servico");

        $categorias = [];
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $categorias[] = $row->categoria;
        }
        return $categorias;
    }

    public function buscarPorId(int $idServico): ?Servico
    {
        $sql = $this->con->prepare("SELECT * FROM servico WHERE idServico = :idServico");
        $sql->bindValue(":idServico", $idServico);
        $sql->execute();

        if ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            return new Servico(
                $row->nome,
                $row->valor,
                $row->unidadeMedida,
                $row->categoria,
                $row->descricao,
                $row->tamanho,
                $row->material,
                $row->tipoMaterial,
                $row->cor,
                $row->idServico
            );
        }
        return null;
    }

    public function inserir(Servico $servico): void
    {
        $sql = $this->con->prepare("
            INSERT INTO servico (nome, descricao, valor, unidadeMedida, categoria, tamanho, material, tipoMaterial, cor)
            VALUES (:nome, :descricao, :valor, :unidadeMedida, :categoria, :tamanho, :material, :tipoMaterial, :cor)
        ");

        $sql->bindValue(":nome", $servico->getNome());
        $sql->bindValue(":descricao", $servico->getDescricao());
        $sql->bindValue(":valor", $servico->getValor());
        $sql->bindValue(":unidadeMedida", $servico->getUnidadeMedida());
        $sql->bindValue(":categoria", $servico->getCategoria());
        $sql->bindValue(":tamanho", $servico->getTamanho());
        $sql->bindValue(":material", $servico->getMaterial());
        $sql->bindValue(":tipoMaterial", $servico->getTipoMaterial());
        $sql->bindValue(":cor", $servico->getCor());

        $sql->execute();
    }

    public function atualizar(Servico $servico): void
    {
        $sql = $this->con->prepare("
            UPDATE servico SET 
                nome = :nome, descricao = :descricao, valor = :valor, 
                unidadeMedida = :unidadeMedida, categoria = :categoria, 
                tamanho = :tamanho, material = :material, 
                tipoMaterial = :tipoMaterial, cor = :cor
            WHERE idServico = :idServico
        ");

        $sql->bindValue(":nome", $servico->getNome());
        $sql->bindValue(":descricao", $servico->getDescricao());
        $sql->bindValue(":valor", $servico->getValor());
        $sql->bindValue(":unidadeMedida", $servico->getUnidadeMedida());
        $sql->bindValue(":categoria", $servico->getCategoria());
        $sql->bindValue(":tamanho", $servico->getTamanho());
        $sql->bindValue(":material", $servico->getMaterial());
        $sql->bindValue(":tipoMaterial", $servico->getTipoMaterial());
        $sql->bindValue(":cor", $servico->getCor());
        $sql->bindValue(":idServico", $servico->getIdServico());

        $sql->execute();
    }

    public function excluir(int $idServico): void
    {
        $sql = $this->con->prepare("DELETE FROM servico WHERE idServico = :idServico");
        $sql->bindValue(":idServico", $idServico);
        $sql->execute();
    }
}
