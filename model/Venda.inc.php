<?php
require_once "Usuario.inc.php";

class Venda {
    private int $idVenda;
    private Usuario $usuario;
    private int $data;
    private float $valorTotal;

    public function __construct(Usuario $usuario, float $valorTotal, int $idVenda = 0)
    {
        $this->idVenda = $idVenda;
        $this->usuario = $usuario;
        $this->data = time();
        $this->valorTotal = $valorTotal;
    }

    public function getIdVenda(): int {
        return $this->idVenda;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getData() {
        return $this->data;
    }

    public function getValorTotal() {
        return $this->valorTotal;
    }

    public function setData(int $data) {
        $this->data = $data;
    }
}
?>