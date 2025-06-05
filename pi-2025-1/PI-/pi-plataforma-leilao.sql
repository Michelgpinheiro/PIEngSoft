-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/06/2025 às 02:40
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
  `VALOR` decimal(10,2) NOT NULL,
  `CONTATO` varchar(30) NOT NULL,
  `OBSERVACOES` longtext NOT NULL,
  `ID_PRODUTO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lancamento`
--

INSERT INTO `lancamento` (`ID_USUARIO`, `ID_LEILAO`, `VALOR`, `CONTATO`, `OBSERVACOES`, `ID_PRODUTO`) VALUES
(2, 1, 9000.00, '55 (88) 99741-1580', 'Sempre quis esse tablet, agoraé minha chance, se alguém der uma lance maior que o meu, vai se ver comigo 🤬', 2),
(2, 2, 165601.00, '55 (88) 99741-1580', 'Eu quero isso aí em!', 3),
(2, 4, 3000.00, '55 (88) 99741-1580', 'Essa calça é top mermão, quero ela pra agora!', 5),
(2, 7, 80000.00, '55 (88) 99741-1580', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 8),
(2, 8, 17000.00, '55 (88) 99741-1580', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 10),
(2, 9, 350.00, '55 (88) 99741-1580', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 11);

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
  `DESCRICAO` longtext NOT NULL,
  `FOTO_1` longblob DEFAULT NULL,
  `FOTO_2` longblob DEFAULT NULL,
  `FOTO_3` longblob DEFAULT NULL,
  `FOTO_4` longblob DEFAULT NULL,
  `MOTIVO_RECUSA` longtext DEFAULT NULL,
  `VERIFICADO` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `leilao`
--

INSERT INTO `leilao` (`ID`, `ID_USUARIO`, `ID_PRODUTO`, `TITULO`, `DATA_INICIO`, `DATA_FINAL`, `NUMERO_PARACAS`, `REDUCAO_PRACA`, `DIFERENCA_PRACA`, `VALOR_INCREMENTO`, `CONTATO`, `DESCRICAO`, `FOTO_1`, `FOTO_2`, `FOTO_3`, `FOTO_4`, `MOTIVO_RECUSA`, `VERIFICADO`) VALUES
(1, 2, 2, 'Eletrônico 1', '2025-06-01 18:27:00', '2025-06-20 18:27:00', 1, 40, 30, 1000, '55 (88) 99741-1580', 'Pegue', 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f666f746f5f325f322e6a7067, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, NULL, 1),
(2, 2, 3, 'Veículo 1', '2025-06-01 18:34:00', '2025-06-02 18:34:00', 1, 20, 45, 5600, '55 (88) 99741-1580', 'QUero', 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f666f746f5f335f342e6a7067, NULL, 1),
(4, 2, 5, 'Roupas 1', '2025-06-01 18:41:00', '2025-06-20 18:41:00', 2, 20, 30, 20, '55 (88) 99741-1580', 'Bla bla bla', 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f666f746f5f355f322e6a7067, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, NULL, 1),
(5, 2, 6, 'Móvel 1', '2025-06-01 18:41:00', '2025-06-28 18:41:00', 1, 34, 30, 767, '55 (88) 99741-1580', 'Poweq', 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f666f746f5f365f322e6a7067, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 'Fodase', 1),
(6, 2, 7, 'Outros 1', '2025-06-01 18:46:00', '2025-06-04 18:46:00', 1, 21, 45, 23, '2323', '232332', 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f666f746f5f375f322e6a7067, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 'Não', 1),
(7, 2, 8, 'Antiguidade 2', '2025-06-04 17:23:00', '2025-06-05 17:23:00', 1, 10, 30, 400, '55 (88) 99741-1580', 'Esse item é extremente raro, recomendo para quem for dar o lance, fique esperto, pois se for arrematado no final, pode ser que você se foda!', 0x696d6167656e732f6c65696c616f2f666f746f5f385f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f385f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f385f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f385f342e6a7067, NULL, 1),
(8, 2, 10, 'Móvel 1', '2025-06-04 17:28:00', '2025-06-11 17:28:00', 2, 40, 20, 1400, '55 (88) 99741-1580', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores, aut alias pariatur tempora blanditiis omnis consequuntur ab. Laudantium beatae veniam sed! Exercitationem dolorum, laboriosam quas rem officia praesentium alias ab unde vero aliquid voluptates illo tempore rerum mollitia doloribus quo quam sed eos consectetur omnis a inventore et. Neque nihil deserunt, ex dolor optio placeat. Dolor fugiat porro ipsam, aperiam quibusdam laudantium necessitatibus iste autem. Illo, assumenda! Nobis,', 0x696d6167656e732f6c65696c616f2f666f746f5f31305f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31305f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31305f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31305f342e6a7067, NULL, 1),
(9, 2, 11, 'Outros 1', '2025-06-04 17:30:00', '2025-07-04 17:30:00', 2, 20, 30, 150, '55 (88) 99741-1580', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores, aut alias pariatur tempora blanditiis omnis consequuntur ab. Laudantium beatae veniam sed! Exercitationem dolorum, laboriosam quas rem officia praesentium alias ab unde vero aliquid voluptates illo tempore rerum mollitia doloribus quo quam sed eos consectetur omnis a inventore et. Neque nihil deserunt, ex dolor optio placeat. Dolor fugiat porro ipsam, aperiam quibusdam laudantium necessitatibus iste autem.', 0x696d6167656e732f6c65696c616f2f666f746f5f31315f312e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31315f322e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31315f332e6a7067, 0x696d6167656e732f6c65696c616f2f666f746f5f31315f342e6a7067, NULL, 1),
(10, 2, 12, 'Audi R8', '2025-06-04 17:40:00', '2025-07-04 17:40:00', 2, 35, 30, 15000, '55 (88) 99741-1580', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores, aut alias pariatur tempora blanditiis omnis consequuntur ab. Laudantium beatae veniam sed! Exercitationem dolorum, laboriosam quas rem officia praesentium alias ab unde vero aliquid voluptates illo tempore rerum mollitia doloribus quo quam sed eos consectetur omnis a inventore et. Neque nihil deserunt, ex dolor optio placeat. Dolor fugiat porro ipsam, aperiam quibusdam laudantium necessitatibus iste autem. Illo, assumenda! Nobis,', 0x696d6167656e732f6c65696c616f2f666f746f5f31325f312e6a7067, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, NULL, 1),
(11, 3, 13, 'Eletrônico 3', '2025-06-05 21:22:00', '2025-06-26 21:23:00', 1, 12, 30, 232323, '55 (88) 99741-1580', 'adasddddddddddddddddjasbdjsbadkjsbhadkjsadbkasbdsadbss', 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f666f746f5f31335f322e6a7067, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, 0x696d6167656e732f6c65696c616f2f6e6f2d696d6167652e737667, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `ID` int(11) NOT NULL,
  `ID_USUARIO` int(11) DEFAULT NULL,
  `MENSAGEM` longtext DEFAULT NULL,
  `VERIFICADO` int(11) DEFAULT NULL,
  `RESPOSTA` longtext DEFAULT NULL,
  `ID_ADMIN` int(11) DEFAULT NULL,
  `VISTO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mensagem`
--

INSERT INTO `mensagem` (`ID`, `ID_USUARIO`, `MENSAGEM`, `VERIFICADO`, `RESPOSTA`, `ID_ADMIN`, `VISTO`) VALUES
(3, 3, 'dkjasndkjasdkjasndkj kjasdkaljsndkasn kjasdknsakdnaksl nakdjnaskdnaksjd', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `ID` int(11) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `TIPO_MOVIMENTACAO` varchar(255) DEFAULT NULL,
  `VALOR` int(11) DEFAULT NULL,
  `NOME_PRODUTO` varchar(255) DEFAULT NULL,
  `NOME_CADASTRADO` varchar(255) DEFAULT NULL,
  `GRAU` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacao`
--

INSERT INTO `movimentacao` (`ID`, `ID_USUARIO`, `TIPO_MOVIMENTACAO`, `VALOR`, `NOME_PRODUTO`, `NOME_CADASTRADO`, `GRAU`) VALUES
(1, 1, 'Produto Cadastrado', 10000, 'Eletrônico Padrão 1', NULL, NULL),
(2, 2, 'Produto Cadastrado', 7500, 'Eletrônico 1', NULL, NULL),
(3, 2, 'Produto Cadastrado', 150000, 'Veículo 1', NULL, NULL),
(4, 2, 'Produto Cadastrado', 4578, 'Antiguidade 1', NULL, NULL),
(5, 2, 'Produto Cadastrado', 54, 'Roupas 1', NULL, NULL),
(6, 2, 'Produto Cadastrado', 6780, 'Móvel 1', NULL, NULL),
(7, 2, 'Produto Cadastrado', 76, 'Outros 1', NULL, NULL),
(8, 2, 'Produto Cadastrado', 75000, 'Antiguidade 2', NULL, NULL),
(9, 2, 'Produto Cadastrado', 123213, '2131233', NULL, NULL),
(10, 2, 'Solicitação de leilão', 7500, 'Eletrônico 1', NULL, NULL),
(11, 2, 'Solicitação de leilão', 150000, 'Veículo 1', NULL, NULL),
(12, 2, 'Solicitação de leilão', 4578, 'Antiguidade 1', NULL, NULL),
(13, 2, 'Solicitação de leilão', 54, 'Roupas 1', NULL, NULL),
(14, 2, 'Solicitação de leilão', 6780, 'Móvel 1', NULL, NULL),
(15, 2, 'Solicitação de leilão', 76, 'Outros 1', NULL, NULL),
(16, 1, 'Lance Dado', 160000, 'Veículo 1', NULL, NULL),
(17, 1, 'Lance Dado', 2323, 'Roupas 1', NULL, NULL),
(18, 3, 'Lance Dado', 165601, 'Veículo 1', NULL, NULL),
(19, 3, 'Lance Dado', 3000, 'Roupas 1', NULL, NULL),
(20, 3, 'Lance Dado', 9000, 'Eletrônico 1', NULL, NULL),
(21, 2, 'Solicitação de leilão', 75000, 'Antiguidade 2', NULL, NULL),
(22, 2, 'Produto Cadastrado', 15000, 'Móvel 1', NULL, NULL),
(23, 2, 'Produto Cadastrado', 150, 'Outros 1', NULL, NULL),
(24, 2, 'Solicitação de leilão', 15000, 'Móvel 1', NULL, NULL),
(25, 2, 'Solicitação de leilão', 150, 'Outros 1', NULL, NULL),
(26, 3, 'Lance Dado', 80000, 'Antiguidade 2', NULL, NULL),
(27, 3, 'Lance Dado', 17000, 'Móvel 1', NULL, NULL),
(28, 3, 'Lance Dado', 350, 'Outros 1', NULL, NULL),
(29, 2, 'Produto Cadastrado', 450000, 'Audi R8', NULL, NULL),
(30, 2, 'Solicitação de leilão', 450000, 'Audi R8', NULL, NULL),
(31, 3, 'Produto Cadastrado', 45678, 'Eletrônico 3', NULL, NULL),
(32, 3, 'Solicitação de leilão', 45678, 'Eletrônico 3', NULL, NULL),
(33, 1, 'Produto Cadastrado', 4500, 'Eletrônico I', NULL, NULL),
(34, 2, 'Produto Cadastrado', 6788, 'Eletronico 1', NULL, NULL);

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
  `DADOS_ADICIONAIS` longtext DEFAULT NULL,
  `FOTO` longblob DEFAULT NULL,
  `STATUS_PRODUTO` int(5) DEFAULT NULL COMMENT '1 = A ser leiloado, 2 = Em leilão, 3 = Recusado, 4 = Resultado, 5 = Em análise, 6 = Suspenso, 7 = Deletado',
  `CATEGORIA` varchar(255) DEFAULT NULL,
  `MOTIVO_SUSPENSAO` varchar(255) DEFAULT NULL,
  `MOTIVO_EXCLUSAO` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`ID`, `ID_USUARIO`, `NOME`, `MARCA`, `QUANT`, `MODELO`, `CONDICAO`, `MATERIAL`, `TAMANHO`, `COR`, `ESTILO`, `ANO_FABRICACAO`, `DIMENSOES`, `PLACA`, `QUILOMETRAGEM`, `LANCE_INICIAL`, `DADOS_ADICIONAIS`, `FOTO`, `STATUS_PRODUTO`, `CATEGORIA`, `MOTIVO_SUSPENSAO`, `MOTIVO_EXCLUSAO`) VALUES
(1, 1, 'Eletrônico Admin 1', 'Eletrônico ', 1, 'Admin', 'Novo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10000, 'Melhor que essa bagaça não existe!', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f312e6a7067, 1, 'Eletrônico', NULL, NULL),
(2, 2, 'Eletrônico 1', 'Eletrônco', 1, '1', 'Usado (seminovo)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7500, 'Eu quero, eu posso!', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f322e6a7067, 4, 'Eletrônico', NULL, NULL),
(3, 2, 'Veículo 1', 'Veículo', NULL, '1', NULL, NULL, NULL, 'Verde', NULL, '0000-00-00', NULL, 'LRC-776', 750000, 150000, 'Carro foda!', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f332e6a7067, 4, 'Veículo', NULL, NULL),
(5, 2, 'Roupas 1', 'Roupa', NULL, NULL, NULL, 'Lã', '', 'Vermelha', 'Casual', NULL, NULL, NULL, NULL, 54, 'Roupa fitness', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f352e6a7067, 4, 'Roupa', NULL, NULL),
(8, 2, 'Antiguidade 2', 'Antiguidade', 2, NULL, 'Novo', 'Madeira', NULL, NULL, NULL, NULL, 'Grande', NULL, NULL, 75000, 'Yeah', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f382e6a7067, 4, 'Antiguidade', NULL, NULL),
(10, 2, 'Móvel 1', 'Móvel', NULL, NULL, 'Usado (seminovo)', 'Madeira', NULL, 'Marrom', NULL, NULL, 'Médio', NULL, NULL, 15000, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores, aut alias pariatur tempora blanditiis omnis consequuntur ab. Laudantium beatae veniam sed! Exercitationem dolorum, laboriosam quas rem officia praesentium alias ab unde vero aliquid voluptates illo tempore rerum mollitia doloribus quo quam sed eos consectetur omnis a inventore et. Neque nihil deserunt, ex dolor optio placeat. Dolor fugiat porro ipsam, aperiam quibusdam laudantium necessitatibus iste autem. Illo, assumenda! Nobis,', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31302e6a7067, 4, 'Móvel', NULL, NULL),
(11, 2, 'Outros 1', 'Outros', NULL, NULL, 'Usado (seminovo)', 'Metal', NULL, 'Branco', NULL, NULL, 'Pequeno', NULL, NULL, 150, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores, aut alias pariatur tempora blanditiis omnis consequuntur ab. Laudantium beatae veniam sed! Exercitationem dolorum, laboriosam quas rem officia praesentium alias ab unde vero aliquid voluptates illo tempore rerum mollitia doloribus quo quam sed eos consectetur omnis a inventore et. Neque nihil deserunt, ex dolor optio placeat. Dolor fugiat porro ipsam, aperiam quibusdam laudantium necessitatibus iste autem. Illo, assumenda! Nobis,', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31312e6a7067, 4, 'Outros', NULL, NULL),
(12, 2, 'Audi R8', 'Audi', NULL, 'R8', NULL, NULL, NULL, 'Branco', NULL, '0000-00-00', NULL, 'KHR-699', 567800, 450000, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Maiores, aut alias pariatur tempora blanditiis omnis consequuntur ab. Laudantium beatae veniam sed! Exercitationem dolorum, laboriosam quas rem officia praesentium alias ab unde vero aliquid voluptates illo tempore rerum mollitia doloribus quo quam sed eos consectetur omnis a inventore et. Neque nihil deserunt, ex dolor optio placeat. Dolor fugiat porro ipsam, aperiam quibusdam laudantium necessitatibus iste autem. Illo, assumenda! Nobis,', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31322e6a7067, 2, 'Veículo', NULL, NULL),
(13, 3, 'Eletrônico 3', 'Eletronico', 1, 'Galaxy A15', 'Novo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 45678, 'sndakjdnsklandkndakljsndlkjasndkansldksandkljsnakdlnsaksssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31332e6a7067, 5, 'Eletrônico', NULL, NULL),
(14, 1, 'Eletrônico I', 'Eletronico', 23, 'Galaxy A15', 'Novo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4500, 'asdasdsadsda', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31342e6a7067, 1, 'Eletrônico', NULL, NULL),
(15, 2, 'Eletronico 1', 'Eletrônico', 2, 'Galaxy A15', 'Usado (seminovo)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6788, 'sajkdsandansknsansadnjdd', 0x696d6167656e732f70726f6475746f732f70726f6475746f735f31352e6a7067, 1, 'Eletrônico', NULL, NULL);

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
  `RAZAO_SOCIAL` varchar(100) DEFAULT NULL,
  `NOME_FANTASIA` varchar(100) DEFAULT NULL,
  `CNPJ` char(20) DEFAULT NULL,
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
  `ID_USU_PAI` int(11) DEFAULT NULL,
  `PERGUNTA_1` varchar(255) DEFAULT NULL,
  `PERGUNTA_2` varchar(255) DEFAULT NULL,
  `PERGUNTA_3` varchar(255) DEFAULT NULL,
  `RG` varchar(20) DEFAULT NULL,
  `MOTIVO_SUSPENSAO_CONTA` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`ID`, `ID_TP_USU`, `NOME`, `CPF`, `RAZAO_SOCIAL`, `NOME_FANTASIA`, `CNPJ`, `FONE`, `LOGRADOURO`, `BAIRRO`, `NUMERO`, `UF`, `CIDADE`, `EMAIL`, `SENHA`, `ST_USUARIO`, `FOTO`, `ID_USU_PAI`, `PERGUNTA_1`, `PERGUNTA_2`, `PERGUNTA_3`, `RG`, `MOTIVO_SUSPENSAO_CONTA`) VALUES
(1, 2, 'Administrador', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', '$2y$10$oLaAO43DKBW3/wbSZF9XhelR/GMy6RW6RJH7x5weNsnYJKuApus4.', 1, 0x696d6167656e732f7065726669732f70657266696c5f312e6a7067, NULL, NULL, NULL, NULL, '', NULL),
(2, 1, 'Leony Leandro Barros', '089.041.560-92', NULL, NULL, NULL, '55 (88) 99741-1588', 'Rua Santa Rosa', 'Salesianos', '776', 'Ceará', 'Juazeiro do Norte', 'leonyleandrobarros@gmail.com', '$2y$10$MQ.2rbS0afm8pEKuIX/lYO3dDSkkZN1/KdHW4RhmdlvCQRaHwd.qK', 1, 0x696d6167656e732f7065726669732f70657266696c5f322e6a7067, NULL, '$2y$10$TXqJto/3i6hf1AaEkczw3ud6OMDDAHqxmZYvE6XQkmZx9AdWcjTfi', '$2y$10$EuVRJAugxT.FtlARCwKKf.Z8jDo.pXPhyIFWUTD5aS1GF5yzVFuDu', '$2y$10$WchrOiH6XkC/rfK0lH5sxuHm0NKcNDOrSj4FT8jgOBZ4vuNVhg.re', '', NULL),
(3, 1, NULL, NULL, 'Nós movemos montanhas Inc', 'Montanha movemos', '45.010.662/0001-80', '(55) 12 93456-7890', 'Rua Afonso Melo', 'Salesianos', '678A', 'Ceará', 'Juazeiro do Norte', 'montanhasmovemos@gmail.com', '$2y$10$RBM24j7EVWm66bBoKyAwtu4fduMOA8ziMkNlkjEmjFRX.KM6dg91q', 1, 0x696d6167656e732f7065726669732f70657266696c5f332e6a7067, NULL, '$2y$10$Px4Sl93jt.6wCokNWpE0wuzW/0lux8KvzrRX8awUShNvy2gGAZ8fm', '$2y$10$0h5eQl21vVwJKjtdNhRaY.txGVIDlUzDeY5qiwARXB0IXbCUuMgG2', '$2y$10$JWw.oubxsPbjWGYpiaBEN.RGwRELXucs6KrFKyzKgbwnv3a1oxEqG', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `lancamento`
--
ALTER TABLE `lancamento`
  ADD PRIMARY KEY (`ID_USUARIO`,`ID_LEILAO`),
  ADD UNIQUE KEY `ID_LEILAO_2` (`ID_LEILAO`);

--
-- Índices de tabela `leilao`
--
ALTER TABLE `leilao`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`),
  ADD KEY `ID_PRODUTO` (`ID_PRODUTO`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

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
