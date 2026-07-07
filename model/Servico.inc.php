<?php

class Servico {
    // Atributos privados mapeados da tabela
    private ?int $idServico; // O '?' indica que pode ser nulo (pois é Auto Increment no banco)
    private string $nome;
    private ?string $descricao;
    private float $valor;
    private string $unidadeMedida;
    private string $categoria;
    private ?string $tamanho;
    private ?string $material;
    private ?string $tipoMaterial;
    private ?string $cor;

    // Construtor
    // Os campos NOT NULL vêm primeiro, os opcionais/nuláveis vêm depois com valor padrão nulo
    public function __construct(
        string $nome,
        float $valor,
        string $unidadeMedida,
        string $categoria,
        ?string $descricao = null,
        ?string $tamanho = null,
        ?string $material = null,
        ?string $tipoMaterial = null,
        ?string $cor = null,
        ?int $idServico = null
    ) {
        $this->nome = $nome;
        $this->valor = $valor;
        $this->unidadeMedida = $unidadeMedida;
        $this->categoria = $categoria;
        $this->descricao = $descricao;
        $this->tamanho = $tamanho;
        $this->material = $material;
        $this->tipoMaterial = $tipoMaterial;
        $this->cor = $cor;
        $this->idServico = $idServico;
    }

    // ==========================================
    // GETTERS (Para acessar os dados)
    // ==========================================
    public function getIdServico(): ?int { return $this->idServico; }
    public function getNome(): string { return $this->nome; }
    public function getDescricao(): ?string { return $this->descricao; }
    public function getValor(): float { return $this->valor; }
    public function getUnidadeMedida(): string { return $this->unidadeMedida; }
    public function getCategoria(): string { return $this->categoria; }
    public function getTamanho(): ?string { return $this->tamanho; }
    public function getMaterial(): ?string { return $this->material; }
    public function getTipoMaterial(): ?string { return $this->tipoMaterial; }
    public function getCor(): ?string { return $this->cor; }

    // ==========================================
    // SETTERS (Para alterar os dados)
    // ==========================================
    public function setIdServico(?int $idServico): void { $this->idServico = $idServico; }
    public function setNome(string $nome): void { $this->nome = $nome; }
    public function setDescricao(?string $descricao): void { $this->descricao = $descricao; }
    public function setValor(float $valor): void { $this->valor = $valor; }
    public function setUnidadeMedida(string $unidadeMedida): void { $this->unidadeMedida = $unidadeMedida; }
    public function setCategoria(string $categoria): void { $this->categoria = $categoria; }
    public function setTamanho(?string $tamanho): void { $this->tamanho = $tamanho; }
    public function setMaterial(?string $material): void { $this->material = $material; }
    public function setTipoMaterial(?string $tipoMaterial): void { $this->tipoMaterial = $tipoMaterial; }
    public function setCor(?string $cor): void { $this->cor = $cor; }

    public function getCodigo() {
        $cod = $this->idServico + 100;
        return "CK$cod";
    }
}
?>