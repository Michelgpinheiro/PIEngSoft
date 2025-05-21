-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/05/2025 às 23:47
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pi-plataforma-leilao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `lancamento`
--

CREATE TABLE `lancamento` (
  `ID_USUARIO` int(11) NOT NULL,
  `ID_LEILAO` int(11) NOT NULL,
  `VALOR` double NOT NULL,
  `CONTATO` varchar(30) NOT NULL,
  `OBSERVACOES` varchar(250) NOT NULL,
  `ID_PRODUTO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lancamento`
--

INSERT INTO `lancamento` (`ID_USUARIO`, `ID_LEILAO`, `VALOR`, `CONTATO`, `OBSERVACOES`, `ID_PRODUTO`) VALUES
(1, 1, 1500, '(88)99917-9001', 'Vou comprar essa caramba sim', 1),
(2, 2, 696969, '55 (88) 99741-1580', '112121223231', 2),
(2, 3, 1200, '55 (88) 99741-1580', 'Me dê papai', 1),
(2, 5, 2500, '55 (88) 99741-1580', 'Gostei tanto dessa bagaça que quero pra hoje!!!!!!!!', 6),
(2, 8, 10000, '55 (88) 99741-1580', 'dasdsadsadsad', 4),
(3, 9, 4500, '55 (88) 99741-1580', 'Boa', 9),
(3, 10, 30, '55 (88) 99741-1580', 'Olá pessoal', 11);

-- --------------------------------------------------------

--
-- Estrutura para tabela `leilao`
--

CREATE TABLE `leilao` (
  `ID` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_PRODUTO` int(11) NOT NULL,
  `TITULO` varchar(60) NOT NULL,
  `DATA_INICIO` datetime NOT NULL,
  `DATA_FINAL` datetime NOT NULL,
  `NUMERO_PARACAS` float NOT NULL,
  `REDUCAO_PRACA` int(11) NOT NULL,
  `DIFERENCA_PRACA` int(11) NOT NULL,
  `VALOR_INCREMENTO` double NOT NULL,
  `CONTATO` varchar(50) NOT NULL,
  `DESCRICAO` varchar(500) NOT NULL,
  `FOTO_1` longblob DEFAULT NULL,
  `FOTO_2` longblob DEFAULT NULL,
  `FOTO_3` longblob DEFAULT NULL,
  `FOTO_4` longblob DEFAULT NULL,
  `MOTIVO_RECUSA` varchar(255) DEFAULT NULL,
  `VERIFICADO` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `leilao`
--

INSERT INTO `leilao` (`ID`, `ID_USUARIO`, `ID_PRODUTO`, `TITULO`, `DATA_INICIO`, `DATA_FINAL`, `NUMERO_PARACAS`, `REDUCAO_PRACA`, `DIFERENCA_PRACA`, `VALOR_INCREMENTO`, `CONTATO`, `DESCRICAO`, `FOTO_1`, `FOTO_2`, `FOTO_3`, `FOTO_4`, `MOTIVO_RECUSA`, `VERIFICADO`) VALUES
(1, 1, 0, 'Samsung Galaxy A35', '2025-05-01 13:50:00', '2025-05-22 10:30:00', 2, 20, 15, 500, '(88)99917-9001', 'Tô vendendo vey, e é isso', 0x696d6167656e732f6c65696c616f2f666f746f5f315f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f315f322e6a7067, NULL, NULL, NULL, 1),
(2, 2, 2, 'Produto 3', '2025-05-03 11:34:00', '2025-05-30 11:34:00', 1, 2, 21, 12, '55 (88) 99741-1580', '12', 0x696d6167656e732f6c65696c616f2f666f746f5f325f312e6a7067, NULL, NULL, NULL, NULL, 1),
(3, 2, 1, 'Produto 1', '2025-05-01 11:41:00', '2025-05-21 11:41:00', 1, 1, 1221, 12, '55 (88) 99741-1580', '11111', 0x696d6167656e732f6c65696c616f2f666f746f5f315f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f315f322e6a7067, NULL, NULL, NULL, 1),
(4, 2, 3, 'Produto 3', '2025-05-01 11:42:00', '2025-05-24 11:42:00', 1, 1, 12, 11, '55 (88) 99741-1580', '121221', 0x696d6167656e732f6c65696c616f2f666f746f5f335f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f335f322e6a7067, NULL, NULL, 'Sua oferta é muito ruim!!!', 1),
(5, 2, 6, 'Roupa 1', '2025-05-01 15:56:00', '2025-05-31 15:56:00', 2, 1, 6, 1000, '55 (88) 99741-1580', '!!!', 0x696d6167656e732f6c65696c616f2f666f746f5f365f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f365f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f365f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f365f342e6a7067, NULL, 1),
(6, 2, 7, 'Móvel 1', '2025-05-01 15:57:00', '2025-05-31 15:57:00', 1, 1, 10, 1, '55 (88) 99741-1580', '!!!', 0x696d6167656e732f6c65696c616f2f666f746f5f375f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f375f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f375f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f375f342e6a7067, 'Não é aceito coisas de segunda não, tente ser mais cético próxima vez ', 1),
(7, 2, 5, 'Antiguidade 1', '2025-05-19 19:58:00', '2025-05-09 19:58:00', -8, -1, 2, 123456, '55 (88) 99741-1580', 'sdasdasdasdsasa', 0x696d6167656e732f6c65696c616f2f666f746f5f355f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f355f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f355f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f355f342e6a7067, 'Não é bom', 1),
(8, 2, 4, 'Carro 1', '2025-06-18 15:04:00', '2025-07-25 15:05:00', 2, 50, 60, 5000, '55 (88) 99741-1580', 'Isso deva da bom!', 0x696d6167656e732f6c65696c616f2f666f746f5f345f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f345f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f345f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f345f342e6a7067, NULL, 1),
(9, 3, 9, 'Eletrônico Admin 1', '2025-05-01 09:33:00', '2025-05-31 09:33:00', 2, 15, 50, 500, '55 (88) 99741-1580', '!!!', 0x696d6167656e732f6c65696c616f2f666f746f5f395f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f395f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f395f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f395f342e6a7067, NULL, 1),
(10, 3, 11, 'Antiguidade Admin 1', '2025-05-01 09:46:00', '2025-05-31 09:46:00', 2, 20, 23, 677, '55 (88) 99741-1580', 'ahahaahahahaahahahhhahhhaa', 0x696d6167656e732f6c65696c616f2f666f746f5f31315f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31315f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31315f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31315f342e6a7067, NULL, 1),
(11, 3, 12, 'Antiguidade Admin 2', '2025-05-09 09:59:00', '2025-05-24 09:59:00', 2, 13, 32, 1300, '55 (88) 99741-1580', '!!!', 0x696d6167656e732f6c65696c616f2f666f746f5f31325f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31325f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31325f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31325f342e6a7067, NULL, 0),
(12, 3, 14, 'Móvel Admin 1', '2025-05-02 10:03:00', '2025-05-17 10:03:00', 1, 69, 40, 1223, '55 (88) 99741-1580', 'Nada', 0x696d6167656e732f6c65696c616f2f666f746f5f31345f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31345f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31345f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31345f342e6a7067, NULL, 0),
(13, 3, 15, 'Outros Admin 1', '2025-05-03 10:21:00', '2025-05-15 10:22:00', 2, 12, 20, 1221, '55 (88) 99741-1580', '1resenha', 0x696d6167656e732f6c65696c616f2f666f746f5f31355f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31355f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31355f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31355f342e6a7067, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissao_usu`
--

CREATE TABLE `permissao_usu` (
  `ID` int(11) NOT NULL,
  `ID_TP_USU` int(11) NOT NULL,
  `PERMISSAO` varchar(100) NOT NULL,
  `AUTORIZA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `permissao_usu`
--

INSERT INTO `permissao_usu` (`ID`, `ID_TP_USU`, `PERMISSAO`, `AUTORIZA`) VALUES
(1, 2, 'CADASTRA USUARIO', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `praca`
--

CREATE TABLE `praca` (
  `ID` int(11) NOT NULL,
  `ID_LEILAO` int(11) NOT NULL,
  `NUM_PRACA` int(11) NOT NULL,
  `DATA_INICIO` datetime NOT NULL,
  `DATA_FINAL` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `ID` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `NOME` varchar(60) DEFAULT NULL,
  `MARCA` varchar(50) DEFAULT NULL,
  `QUANT` int(11) DEFAULT NULL,
  `MODELO` varchar(30) DEFAULT NULL,
  `CONDICAO` varchar(20) DEFAULT NULL,
  `MATERIAL` varchar(50) DEFAULT NULL,
  `TAMANHO` varchar(20) DEFAULT NULL,
  `COR` varchar(20) DEFAULT NULL,
  `ESTILO` varchar(20) DEFAULT NULL,
  `ANO_FABRICACAO` date DEFAULT NULL,
  `DIMENSOES` varchar(50) DEFAULT NULL,
  `PLACA` char(7) DEFAULT NULL,
  `QUILOMETRAGEM` double DEFAULT NULL,
  `LANCE_INICIAL` double DEFAULT NULL,
  `DADOS_ADICIONAIS` varchar(500) DEFAULT NULL,
  `FOTO` longblob DEFAULT NULL,
  `STATUS_PRODUTO` int(5) DEFAULT NULL COMMENT '1 = A ser leiloado, 2 = Em leilão, 3 = Recusado, 4 = Resultado, 5 = Em análise',
  `CATEGORIA` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`ID`, `ID_USUARIO`, `NOME`, `MARCA`, `QUANT`, `MODELO`, `CONDICAO`, `MATERIAL`, `TAMANHO`, `COR`, `ESTILO`, `ANO_FABRICACAO`, `DIMENSOES`, `PLACA`, `QUILOMETRAGEM`, `LANCE_INICIAL`, `DADOS_ADICIONAIS`, `FOTO`, `STATUS_PRODUTO`, `CATEGORIA`) VALUES
(1, 2, 'Produto 1', '1', 1, '1', 'Novo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '12', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f312e6a7067, 4, 'Eletrônico'),
(2, 2, 'Produto 2', '1', 1, '1', 'Novo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '111', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f322e6a7067, 4, 'Eletrônico'),
(3, 2, 'Produto 3', '1', 1, '1', 'Novo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '111111', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f332e6a7067, 3, 'Eletrônico'),
(4, 2, 'Carro', '12', NULL, '12', NULL, NULL, NULL, '12', NULL, '0000-00-00', NULL, 'LRC-776', 12, 12, '12', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f342e6a7067, 4, 'Veículo'),
(5, 2, 'Antiguidade 1', '1', 1, NULL, 'Novo', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, 11, '!!!', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f352e6a7067, 3, 'Antiguidade'),
(6, 2, 'Roupa 1', '1', NULL, NULL, NULL, '1', '1', '1', '1', NULL, NULL, NULL, NULL, 1, '!!!', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f362e6a7067, 4, 'Roupa'),
(7, 2, 'Móvel 1', '1', NULL, NULL, 'Com defeito', '1', NULL, '1', NULL, NULL, '1', NULL, NULL, 1, '!!!', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f372e6a7067, 3, 'Móvel'),
(8, 2, 'Outros 1', '1', NULL, NULL, 'Usado (seminovo)', '1', NULL, '1', NULL, NULL, '1', NULL, NULL, 1, '1234', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f382e6a7067, 1, 'Outros'),
(9, 3, 'Eletrônico Admin 1', 'Boa', 1, 'Galaxy A15', 'Usado (seminovo)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4000, 'Nenhuma', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f392e6a7067, 4, 'Eletrônico'),
(10, 3, 'Veículo Admin 1', '12', NULL, '12', NULL, NULL, NULL, 'Rosa', NULL, '0000-00-00', NULL, 'LRC-776', 12, 12, 'João', 0x696d6167656e732f7065726669732f70657266696c5f31302e6a7067, 1, 'Veículo'),
(11, 3, 'Antiguidade Admin 1', '1', 1, NULL, 'Recondicionado', '1', NULL, NULL, NULL, NULL, '1', NULL, NULL, 1, 'Antiguidade Admin 1', 0x696d6167656e732f7065726669732f70657266696c5f31312e6a7067, 4, 'Antiguidade'),
(12, 3, 'Antiguidade Admin 2', '12', 12, NULL, 'Novo', '12', NULL, NULL, NULL, NULL, '12', NULL, NULL, 12, 'Antiguidade Admin 2', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31322e6a7067, 5, 'Antiguidade'),
(13, 3, 'Roupas', '123', NULL, NULL, NULL, '12', '123', '13', '12', NULL, NULL, NULL, NULL, 12, 'Olá mundo', 0x70726f6475746f732f7065726669732f70726f6475746f735f31332e6a7067, 1, 'Roupa'),
(14, 3, 'Móvel Admin 1', '12', NULL, NULL, 'Com defeito', '12', NULL, '12', NULL, NULL, '12', NULL, NULL, 12, 'asdasdasddas', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31342e6a7067, 5, 'Móvel'),
(15, 3, 'Outros Admin 1', '12', NULL, NULL, 'Com defeito', '2', NULL, '12', NULL, NULL, '12', NULL, NULL, 12, 'Maldade pura', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31352e6a7067, 5, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `ID` int(11) NOT NULL,
  `TP_USUARIO` int(11) NOT NULL,
  `GRUPO` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`ID`, `TP_USUARIO`, `GRUPO`) VALUES
(1, 1, 'PADRAO'),
(2, 2, 'ADMIN');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `ID_TP_USU` int(11) NOT NULL,
  `NOME` varchar(70) DEFAULT NULL,
  `CPF` varchar(15) DEFAULT NULL,
  `RG` varchar(10) DEFAULT NULL,
  `RAZAO_SOCIAL` varchar(100) DEFAULT NULL,
  `NOME_FANTASIA` varchar(100) DEFAULT NULL,
  `CNPJ` char(14) DEFAULT NULL,
  `FONE` varchar(20) DEFAULT NULL,
  `LOGRADOURO` varchar(100) DEFAULT NULL,
  `BAIRRO` varchar(30) DEFAULT NULL,
  `NUMERO` char(5) DEFAULT NULL,
  `UF` varchar(20) DEFAULT NULL,
  `CIDADE` varchar(100) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `SENHA` varchar(255) DEFAULT NULL,
  `ST_USUARIO` int(11) DEFAULT NULL,
  `FOTO` longblob DEFAULT NULL,
  `ID_USU_PAI` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`ID`, `ID_TP_USU`, `NOME`, `CPF`, `RG`, `RAZAO_SOCIAL`, `NOME_FANTASIA`, `CNPJ`, `FONE`, `LOGRADOURO`, `BAIRRO`, `NUMERO`, `UF`, `CIDADE`, `EMAIL`, `SENHA`, `ST_USUARIO`, `FOTO`, `ID_USU_PAI`) VALUES
(1, 2, 'Morya Samyak', '000000000', '0000000000', NULL, NULL, NULL, '(88)99917-9001', 'Rua João Luciano Moreira', 'Tiradentes', '64A', 'CE', 'Juazeiro do Norte', 'teste@email.com', 'testeLeilao', 1, NULL, NULL),
(2, 1, 'Leony Leandro Barros', '078.123.324-23', '', NULL, NULL, NULL, '(55) 12 93456-7890', 'Rua Carlos Gomes', 'Salesiano', '678', 'Ceará', 'Juazeiro do Norte', 'leonyleandrobarros@gmail.com', '$2y$10$u9BmNVqRW0EFi/Z0Q3ycl.aA6e328IGL6dWM8l8XT9vXkFAZWHPB6', 1, 0x696d6167656e732f7065726669732f70657266696c5f322e6a7067, NULL),
(3, 2, NULL, NULL, NULL, 'Meu nome é ari e não tô nem aí', 'Lerico Tenebras Chesky', '12.345.784/781', '(55) 12 93456-7890', 'Rua Carlos Gomes', 'Salesiano', '678A', 'Ceará', 'Juazeiro do Norte', 'lericotchesky@gmail.com', '$2y$10$TqpwZSZ2mJ2SjDNKAaP6Re482YcsYKbl1q/CPRds3jjelCAvNryTq', 1, 0x696d6167656e732f7065726669732f70657266696c5f332e6a7067, NULL),
(4, 2, NULL, NULL, NULL, 'A que se faz aqui se paga', 'João Messias Queiroz', '12.345.784/781', '(55) 12 93456-7890', 'Rua São Benedito', 'Guanaripe', '678A', 'Ceará', 'Juazeiro do Norte', 'joaomessias@gmail.com', '$2y$10$WyBUwre1VyLuD2Zyf5mGoelA718v5TfB2DxxnijNQCKahZ9g/gjxq', 1, 0x696d6167656e732f7065726669732f70657266696c5f342e6a7067, 3),
(5, 1, 'Henrique Eduardo da Silva', '078.123.324-23', '', NULL, NULL, NULL, '55 (88) 99123-4567', 'Rua São Benedito', 'Salesiano', '454', 'Mato Grosso', 'Juazeiro do Norte', 'henriquesilva@gmail.com', '$2y$10$yXWNB2BLvvRCDo4iVf600.zNfJuV6YgY3ULQ19EZqYtKBv/nTKVPG', 1, 0x696d6167656e732f7065726669732f70657266696c5f352e6a7067, 3),
(6, 2, NULL, NULL, NULL, 'Meu nome é ari e não tô nem aí', 'Zé das ideia versão 2', '12.345.784/789', '55 (88) 99123-4567', 'Rua Carlos Gomes', 'Salesiano', '454', 'Goiás', 'Recife', 'zezao@gmail.com', '$2y$10$Qg42htTPVuG.svVfZI83R.bFdiW0z15sWCwATKNRRzpZN6ZohFlo6', 1, 0x696d6167656e732f7065726669732f70657266696c5f362e6a7067, 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `lancamento`
--
ALTER TABLE `lancamento`
  ADD PRIMARY KEY (`ID_USUARIO`,`ID_LEILAO`),
  ADD UNIQUE KEY `ID_LEILAO` (`ID_LEILAO`);

--
-- Índices de tabela `leilao`
--
ALTER TABLE `leilao`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`),
  ADD KEY `ID_PRODUTO` (`ID_PRODUTO`);

--
-- Índices de tabela `permissao_usu`
--
ALTER TABLE `permissao_usu`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_TP_USU` (`ID_TP_USU`);

--
-- Índices de tabela `praca`
--
ALTER TABLE `praca`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_LEILAO` (`ID_LEILAO`,`NUM_PRACA`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `produto_ibfk_1` (`ID_USUARIO`);

--
-- Índices de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_usuario_tipo` (`ID_TP_USU`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `leilao`
--
ALTER TABLE `leilao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `permissao_usu`
--
ALTER TABLE `permissao_usu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `praca`
--
ALTER TABLE `praca`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `lancamento`
--
ALTER TABLE `lancamento`
  ADD CONSTRAINT `lancamento_ibfk_1` FOREIGN KEY (`ID_LEILAO`) REFERENCES `leilao` (`ID`);

--
-- Restrições para tabelas `permissao_usu`
--
ALTER TABLE `permissao_usu`
  ADD CONSTRAINT `permissao_usu_ibfk_1` FOREIGN KEY (`ID_TP_USU`) REFERENCES `tipo_usuario` (`ID`);

--
-- Restrições para tabelas `praca`
--
ALTER TABLE `praca`
  ADD CONSTRAINT `praca_ibfk_1` FOREIGN KEY (`ID_LEILAO`) REFERENCES `leilao` (`ID`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_tipo` FOREIGN KEY (`ID_TP_USU`) REFERENCES `tipo_usuario` (`ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
