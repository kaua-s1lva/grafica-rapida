<?php
include_once "Repository.inc.php";
include_once "../model/Venda.inc.php";
include_once "../model/ItemCarrinho.inc.php";
include_once "../model/ItemVenda.inc.php";

class VendaRepository extends Repository
{
    public function inserirVenda(Venda $venda, array $carrinho)
    {
        $sql = $this->con->prepare("
            INSERT INTO venda(idUsuario, data, valorTotal)
            VALUES (:idUsuario, :data, :valorTotal)
        ");

        $sql->bindValue(":idUsuario", $venda->getUsuario()->getIdUsuario());
        $sql->bindValue(":data", date("Y-m-d", $venda->getData()));
        $sql->bindValue(":valorTotal", $venda->getValorTotal());

        $sql->execute();
        $idVenda = $this->con->lastInsertId();

        $this->inserirItens($idVenda, $carrinho);
    }

    private function inserirItens(int $idVenda, array $carrinho)
    {
        foreach ($carrinho as $item) {
            $sql = $this->con->prepare("
                INSERT INTO itemVenda(idServico, idVenda, quant, valorUnit)
                VALUES (:idServico, :idVenda, :quant, :valorUnit)
            ");

            $sql->bindValue(":idServico", $item->getServico()->getIdServico());
            $sql->bindValue(":idVenda", $idVenda);
            $sql->bindValue(":quant", $item->getQuantidade());
            $sql->bindValue(":valorUnit", $item->getServico()->getValor());

            $sql->execute();
        }
    }

    public function listarTodas(string $dataInicio = '', string $dataFim = ''): array
    {
        $sqlBase = "
            SELECT v.idVenda, v.data AS dataVenda, v.valorTotal,
                u.idUsuario, u.nome, u.email, u.senha, u.cpf, u.dataNascimento, u.cargo,
                u.logradouro, u.cidade, u.estado, u.cep, u.telefone
            FROM venda v
            INNER JOIN usuario u ON v.idUsuario = u.idUsuario
            WHERE 1=1
        ";
        
        $parametros = [];

        if (!empty($dataInicio)) {
            $sqlBase .= " AND DATE(v.data) >= :dataInicio";
            $parametros[':dataInicio'] = $dataInicio;
        }

        if (!empty($dataFim)) {
            $sqlBase .= " AND DATE(v.data) <= :dataFim";
            $parametros[':dataFim'] = $dataFim;
        }

        $sqlBase .= " ORDER BY v.data DESC, v.idVenda DESC";

        $sql = $this->con->prepare($sqlBase);

        foreach ($parametros as $chave => $valor) {
            $sql->bindValue($chave, $valor);
        }

        $sql->execute();

        $vendas = [];
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $usuario = new Usuario(
                $row->nome,
                $row->email,
                $row->senha,
                $row->cpf,
                $row->dataNascimento,
                $row->cargo,
                $row->logradouro,
                $row->cidade,
                $row->estado,
                $row->cep,
                $row->telefone,
                $row->idUsuario
            );

            $venda = new Venda($usuario, $row->valorTotal, $row->idVenda);
            $venda->setData(strtotime($row->dataVenda));

            $vendas[] = $venda;
        }

        return $vendas;
    }

    public function buscarVendaPorId(int $idVenda): ?Venda
    {
        $sql = $this->con->prepare("
            SELECT v.idVenda, v.data AS dataVenda, v.valorTotal,
                   u.idUsuario, u.nome, u.email, u.senha, u.cpf, u.dataNascimento, u.cargo,
                   u.logradouro, u.cidade, u.estado, u.cep, u.telefone
            FROM venda v
            INNER JOIN usuario u ON v.idUsuario = u.idUsuario
            WHERE v.idVenda = :idVenda
        ");

        $sql->bindValue(":idVenda", $idVenda);
        $sql->execute();

        if ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $usuario = new Usuario(
                $row->nome,
                $row->email,
                $row->senha,
                $row->cpf,
                $row->dataNascimento,
                $row->cargo,
                $row->logradouro,
                $row->cidade,
                $row->estado,
                $row->cep,
                $row->telefone,
                $row->idUsuario
            );

            $venda = new Venda($usuario, $row->valorTotal, $row->idVenda);
            $venda->setData(strtotime($row->dataVenda));

            return $venda;
        }

        return null;
    }

    public function buscarItensDaVenda(int $idVenda, ?Venda $venda = null): array
    {
        $sql = $this->con->prepare("
            SELECT iv.quant, iv.valorUnit,
                   s.idServico, s.nome, s.descricao, s.valor, s.unidadeMedida, 
                   s.categoria, s.tamanho, s.material, s.tipoMaterial, s.cor
            FROM itemVenda iv
            INNER JOIN servico s ON iv.idServico = s.idServico
            WHERE iv.idVenda = :idVenda
        ");

        $sql->bindValue(":idVenda", $idVenda);
        $sql->execute();

        $itens = [];

        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $servico = new Servico(
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

            $itemVenda = new ItemVenda($servico, $row->quant, $row->valorUnit, $venda);

            $itens[] = $itemVenda;
        }

        return $itens;
    }

    public function buscarVendasPorUsuario(Usuario $usuario): array
    {
        $sql = $this->con->prepare("
            SELECT * FROM venda 
            WHERE idUsuario = :idUsuario 
            ORDER BY data DESC, idVenda DESC
        ");
        $sql->bindValue(":idUsuario", $usuario->getIdUsuario());
        $sql->execute();

        $vendas = [];
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $venda = new Venda($usuario, (float)$row->valorTotal, (int)$row->idVenda);
            $venda->setData(strtotime($row->data));

            $vendas[] = $venda;
        }
        return $vendas;
    }
}
