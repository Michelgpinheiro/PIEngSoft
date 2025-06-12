-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/06/2025 às 22:16
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
  `VISTO` int(11) DEFAULT NULL,
  `MSG_SUSPENSAO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `MOTIVO_SUSPENSAO_CONTA` varchar(255) DEFAULT NULL,
  `DIAS_DESATIVAR` int(11) DEFAULT NULL,
  `DATA_SEM_LEILAO` datetime DEFAULT NULL,
  `DESAT_VOLUNTARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`ID`, `ID_TP_USU`, `NOME`, `CPF`, `RAZAO_SOCIAL`, `NOME_FANTASIA`, `CNPJ`, `FONE`, `LOGRADOURO`, `BAIRRO`, `NUMERO`, `UF`, `CIDADE`, `EMAIL`, `SENHA`, `ST_USUARIO`, `FOTO`, `ID_USU_PAI`, `PERGUNTA_1`, `PERGUNTA_2`, `PERGUNTA_3`, `RG`, `MOTIVO_SUSPENSAO_CONTA`, `DIAS_DESATIVAR`, `DATA_SEM_LEILAO`, `DESAT_VOLUNTARIO`) VALUES
(1, 2, 'Administrador', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', '$2y$10$oLaAO43DKBW3/wbSZF9XhelR/GMy6RW6RJH7x5weNsnYJKuApus4.', 1, 0x696d6167656e732f7065726669732f70657266696c5f312e6a7067, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(2, 1, 'Leony Leandro Barros', '068.729.263-84', NULL, NULL, NULL, '55 (88) 99845-2542', 'Rua Santa Rosa', 'Salesianos', '776', 'Ceará', 'Juazeiro do Norte', 'leonyleandrobarros@gmail.com', '$2y$10$LhopruZ91.RO9KAsiS1IiO8/wtTaKqa/ui64Gsn8LXgyj.DKcxuT.', 1, 0x696d6167656e732f7065726669732f70657266696c5f362e6a7067, NULL, '$2y$10$JxxvZCfksaz9yUer.zFJHOnXNHhVFYt7djT3Ozy7YrV8nj4zBCgRe', '$2y$10$pOtM/lKPv4hluS3hWGt4NO0sUOaCb2irjkYaA/V2t1nBL8fD.cxny', '$2y$10$RefPD7ph9Q6eYcFGrLNm/OD3OzAvlQaoT9lfybZr.tyshX9EXxgXq', '', NULL, 0, '2025-06-12 00:00:00', NULL);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
