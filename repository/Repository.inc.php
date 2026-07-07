<?php
include_once "../Conexao.inc.php";

abstract class Repository {
    protected $con;

    function __construct() {
        $conexao = new Conexao();
        $this->con = $conexao->getConexao();
    }
}
?>