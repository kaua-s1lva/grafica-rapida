<?php 
require_once "Servico.inc.php";
require_once "Venda.inc.php";

class ItemVenda {
    private Servico $servico;
    private ?Venda $venda;
    private int $quantidade;
    private float $valorUnit;

    public function __construct(Servico $servico, int $quantidade, float $valorUnit, ?Venda $venda = null) {
        $this->servico = $servico;
        $this->quantidade = $quantidade;
        $this->valorUnit = $valorUnit;
        $this->venda = $venda;
    }

    public function getServico(): Servico { return $this->servico; }
    public function getVenda(): ?Venda { return $this->venda; }
    public function getQuantidade(): int { return $this->quantidade; }
    public function getValorUnit(): float { return $this->valorUnit; }

    public function getValorItem(): float {
        return $this->quantidade * $this->valorUnit;
    }

    public function setServico(Servico $servico): void { $this->servico = $servico; }
    public function setVenda(Venda $venda): void { $this->venda = $venda; }
    public function setQuantidade(int $quantidade): void { $this->quantidade = $quantidade; }
    public function setValorUnit(float $valorUnit): void { $this->valorUnit = $valorUnit; }
}
?>