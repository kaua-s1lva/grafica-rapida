-- CREATE DATABASE grafica-rapida

-- USE grafica-rapida;

CREATE TABLE servico (
	idServico int primary key AUTO_INCREMENT,
	nome varchar(1000) NOT NULL,
    descricao text,
    valor decimal(10, 2) NOT NULL,
    unidadeMedida varchar(50) NOT NULL,
    categoria varchar(200) NOT NULL,
    tamanho varchar(50),
    material varchar(100),
    tipoMaterial varchar(100),
    cor varchar(100)
);

CREATE TABLE usuario (
	idUsuario INT PRIMARY KEY auto_increment,
    nome varchar(500) NOT NULL,
    email varchar(500) UNIQUE NOT NULL,
    senha varchar(100) NOT NULL,
    cargo varchar(100) NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL,
    dataNascimento DATE NOT NULL,
    logradouro TEXT,
    cidade VARCHAR(500),
    estado CHAR(2),
    cep CHAR(8),
    telefone VARCHAR(12) UNIQUE
);

CREATE TABLE venda (
	idVenda INT PRIMARY KEY AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    data DATE NOT NULL,
    valorTotal DECIMAL(10, 2) NOT NULL,
    
    CONSTRAINT fk_venda_usuario 
		FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
        ON DELETE CASCADE
);

CREATE TABLE itemVenda (
	idServico INT NOT NULL,
    idVenda INT NOT NULL,
    quant INT NOT NULL,
    valorUnit DECIMAL(10, 2),
    
    CONSTRAINT fk_itemVenda_servico
		FOREIGN KEY (idServico) REFERENCES servico(idServico)
        ON DELETE CASCADE,
	CONSTRAINT fk_itemVenda_venda
		FOREIGN KEY (idVenda) REFERENCES venda(idVenda)
        ON DELETE CASCADE
);

INSERT INTO usuario(nome, email, senha, cpf, dataNascimento, cargo) VALUES ("Admin", "admin@email", "1234", "11111111111", "2001-01-01", "admin");

INSERT INTO servico (nome, descricao, valor, unidadeMedida, categoria, tamanho, material, tipoMaterial, cor) 
VALUES 
(
    'Cartão de Visita Premium', 
    'Cartão de visita com acabamento impecável, verniz localizado frente e verso e corte reto.', 
    85.00, 
    'cento', 
    'Papelaria Corporativa', 
    '9x5 cm', 
    'Papel Couchê', 
    '300g', 
    '4x4 (Colorido F/V)'
),
(
    'Banner para Eventos', 
    'Comunicação visual de alto impacto para ambientes internos. Acompanha bastão e cordão.', 
    120.00, 
    'unidade', 
    'Banners e Lonas', 
    '90x120 cm', 
    'Lona', 
    '440g Brilho', 
    'Colorido'
),
(
    'Caneca Personalizada Branca', 
    'Caneca ideal para presentes ou brindes corporativos. Estampa de alta durabilidade (sublimação).', 
    35.00, 
    'unidade', 
    'Brindes', 
    '325 ml', 
    'Cerâmica', 
    'Qualidade AAA', 
    'Branca (Estampa Colorida)'
),
(
    'Impressão Simples P&B', 
    'Cópias e impressões a laser de alta velocidade para documentos e apostilas do dia a dia.', 
    0.50, 
    'página', 
    'Reproduções', 
    'A4 (21x29,7 cm)', 
    'Sulfite', 
    '75g Offset', 
    'Preto e Branco'
),
(
    'Panfleto Promocional', 
    'Material de divulgação em massa ideal para campanhas rápidas.', 
    150.00, 
    'milheiro', 
    'Papelaria Corporativa', 
    '10x15 cm', 
    'Papel Couchê', 
    '90g Brilho', 
    '4x0 (Colorido Frente)'
),
(
    'Cartaz Alta Resolução', 
    'Impressão fotográfica em grande formato para murais, vitrines ou decoração.', 
    15.00, 
    'unidade', 
    'Impressões Especiais', 
    'A3 (29,7x42 cm)', 
    'Papel Fotográfico', 
    '180g Glossy', 
    'Colorido (Alta Definição)'
),
(
    'Adesivo em Vinil com Recorte', 
    'Adesivo resistente à água, ideal para rótulos e vitrines. Já entregue recortado.', 
    65.00, 
    'metro quadrado', 
    'Banners e Lonas', 
    'Personalizado', 
    'Vinil Adesivo', 
    'Fosco ou Brilho', 
    'Colorido'
),
(
    'Encadernação Espiral', 
    'Acabamento para apostilas com capa plástica transparente e contra-capa preta.', 
    5.00, 
    'unidade', 
    'Acabamentos', 
    'A4 ou Ofício', 
    'Espiral Plástico', 
    'Até 100 folhas', 
    'Transparente/Preto'
);