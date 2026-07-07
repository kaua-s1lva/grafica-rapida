<?php
require_once "Servico.inc.php";

class ItemCarrinho {
    private Servico $servico;
    private int $quantidade;
    private float $valorItem;

    function __construct(Servico $servico) {
        $this->servico = $servico;
        $this->quantidade = 1;
        $this->valorItem = $this->servico->getValor();
    }

    public function getValorItem() {
        return $this->valorItem;
    }

    public function setValorItem() {
        $this->valorItem = $this->quantidade * $this->servico->getValor();
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade() {
        $this->quantidade++;
    }

    public function diminuir() {
        $this->quantidade--;
    }

    public function getServico() {
        return $this->servico;
    }
}
?>