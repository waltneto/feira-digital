-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Nov-2025 às 03:19
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `feira_digital`
--
CREATE DATABASE IF NOT EXISTS `feira_digital` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `feira_digital`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

CREATE TABLE `carrinhos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consumidor_id` bigint(20) UNSIGNED NOT NULL,
  `feira_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho_items`
--

CREATE TABLE `carrinho_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `carrinho_id` bigint(20) UNSIGNED NOT NULL,
  `produto_id` bigint(20) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `consumidores`
--

CREATE TABLE `consumidores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email_contato` varchar(255) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `consumidores`
--

INSERT INTO `consumidores` (`id`, `user_id`, `nome`, `cpf`, `telefone`, `email_contato`, `endereco`, `cidade`, `estado`, `cep`, `created_at`, `updated_at`) VALUES
(1, 3, 'Carlos Consumidor', '111.222.333-44', '(11) 97777-7777', 'carlos@email.com', 'Rua das Flores, 123', 'São Paulo', 'SP', '01234-567', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(2, 4, 'Ana Consumidora', '555.666.777-88', '(11) 96666-6666', 'ana@email.com', 'Avenida Brasil, 456', 'São Paulo', 'SP', '01234-568', '2025-11-26 02:18:50', '2025-11-26 02:18:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feiras`
--

CREATE TABLE `feiras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produtor_id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `ativa` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('agendada','em_andamento','concluida','cancelada') NOT NULL DEFAULT 'agendada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `feiras`
--

INSERT INTO `feiras` (`id`, `produtor_id`, `nome`, `descricao`, `data_inicio`, `data_fim`, `endereco`, `cidade`, `estado`, `cep`, `latitude`, `longitude`, `ativa`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Feira Orgânica do João', 'Feira com produtos 100% orgânicos direto da fazenda.', '2025-11-25 23:18:50', '2025-11-26 05:18:50', 'Praça da República, 100', 'Ribeirão Preto', 'SP', '14015-000', -21.17820000, -47.80620000, 1, 'em_andamento', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(2, 2, 'Feira da Maria - Edição Especial', 'Produtos frescos da horta da Maria, com preços especiais.', '2025-11-26 23:18:50', '2025-11-27 07:18:50', 'Avenida Paulista, 1000', 'Campinas', 'SP', '13010-000', -22.90560000, -47.06080000, 1, 'agendada', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(3, 1, 'Feira do João - Sábado', 'Feira especial de sábado com produtos da semana.', '2025-11-27 23:18:50', '2025-11-28 04:18:50', 'Parque Municipal', 'Ribeirão Preto', 'SP', '14015-001', -21.17830000, -47.80630000, 1, 'agendada', '2025-11-26 02:18:50', '2025-11-26 02:18:50');

--
-- Acionadores `feiras`
--
DELIMITER $$
CREATE TRIGGER `BeforeInsertFeira` BEFORE INSERT ON `feiras` FOR EACH ROW BEGIN
    DECLARE v_produtor_ativo TINYINT;
    
    SELECT ativo INTO v_produtor_ativo
    FROM produtores
    WHERE id = NEW.produtor_id;
    
    IF v_produtor_ativo = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Não é possível criar feira para produtor inativo';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_pedido` varchar(255) NOT NULL,
  `consumidor_id` bigint(20) UNSIGNED NOT NULL,
  `feira_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pendente','confirmado','preparando','pronto','entregue','cancelado') NOT NULL DEFAULT 'pendente',
  `subtotal` decimal(8,2) NOT NULL,
  `taxa_entrega` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(8,2) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `confirmado_em` timestamp NULL DEFAULT NULL,
  `preparando_em` timestamp NULL DEFAULT NULL,
  `pronto_em` timestamp NULL DEFAULT NULL,
  `entregue_em` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Acionadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `BeforeInsertPedido` BEFORE INSERT ON `pedidos` FOR EACH ROW BEGIN
    IF NEW.codigo_pedido IS NULL OR NEW.codigo_pedido = '' THEN
        SET NEW.codigo_pedido = CONCAT('PED', DATE_FORMAT(NOW(), '%Y%m%d%H%i%s'), FLOOR(RAND() * 1000));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pedido_id` bigint(20) UNSIGNED NOT NULL,
  `produto_id` bigint(20) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtores`
--

CREATE TABLE `produtores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `tipo_documento` enum('cpf','cnpj') NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `descricao` text DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) NOT NULL,
  `email_contato` varchar(255) NOT NULL,
  `redes_sociais` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`redes_sociais`)),
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produtores`
--

INSERT INTO `produtores` (`id`, `user_id`, `nome`, `documento`, `tipo_documento`, `endereco`, `cidade`, `estado`, `cep`, `descricao`, `foto_perfil`, `telefone`, `email_contato`, `redes_sociais`, `latitude`, `longitude`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 1, 'João da Silva', '123.456.789-00', 'cpf', 'Fazenda Esperança, Km 12', 'Ribeirão Preto', 'SP', '14000-000', 'Produtor familiar com mais de 20 anos de experiência em agricultura orgânica. Cultivamos com amor e respeito à natureza.', NULL, '(16) 99999-9999', 'joao@fazenda.com', '{\"instagram\": \"@joaofazenda\", \"facebook\": \"João da Silva Agricultura\"}', -21.17820000, -47.80620000, 1, '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(2, 2, 'Maria dos Santos', '98.765.432/0001-00', 'cnpj', 'Sítio Flores Bonitas, Zona Rural', 'Campinas', 'SP', '13000-000', 'Horta familiar especializada em legumes e verduras orgânicas. Produção sustentável e sem agrotóxicos.', NULL, '(19) 98888-8888', 'contato@mariahorta.com', '{\"instagram\": \"@mariahorta\", \"whatsapp\": \"(19) 98888-8888\"}', -22.90560000, -47.06080000, 1, '2025-11-26 02:18:50', '2025-11-26 02:18:50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produtor_id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` enum('hortalica','fruta','grao','legume','outros') NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `unidade_medida` varchar(50) NOT NULL,
  `quantidade_disponivel` int(11) NOT NULL DEFAULT 0,
  `foto` varchar(255) DEFAULT NULL,
  `codigo_qr` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `boas_praticas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `produtor_id`, `nome`, `descricao`, `categoria`, `preco`, `unidade_medida`, `quantidade_disponivel`, `foto`, `codigo_qr`, `disponivel`, `boas_praticas`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tomate Orgânico', 'Tomate cultivado sem agrotóxicos, colhido no ponto certo.', 'legume', 8.50, 'kg', 100, NULL, NULL, 1, 'Cultivo orgânico certificado, irrigação por gotejamento, colheita manual.', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(2, 1, 'Alface Crespa', 'Alface fresca colhida diariamente.', 'hortalica', 4.00, 'unidade', 50, NULL, NULL, 1, 'Cultivo protegido, colheita na madrugada para manter a frescura.', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(3, 1, 'Banana Prata', 'Banana orgânica, doce e saborosa.', 'fruta', 6.00, 'kg', 80, NULL, NULL, 1, 'Cultivo consorciado, adubação orgânica, colheita manual.', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(4, 2, 'Cenoura', 'Cenouras crocantes e doces, ricas em betacaroteno.', 'legume', 5.50, 'kg', 60, NULL, NULL, 1, 'Solo arenoso, irrigação controlada, colheita mecanizada.', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(5, 2, 'Couve Flor', 'Couve flor branca e firme, perfeita para diversos pratos.', 'hortalica', 7.00, 'unidade', 30, NULL, NULL, 1, 'Cultivo orgânico, controle biológico de pragas.', '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(6, 2, 'Arroz Integral', 'Arroz integral orgânico, rico em fibras.', 'grao', 12.00, 'kg', 40, NULL, NULL, 1, 'Cultivo sustentável, beneficiamento mínimo para manter nutrientes.', '2025-11-26 02:18:50', '2025-11-26 02:18:50');

--
-- Acionadores `produtos`
--
DELIMITER $$
CREATE TRIGGER `BeforeUpdateProduto` BEFORE UPDATE ON `produtos` FOR EACH ROW BEGIN
    SET NEW.updated_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `tipo` enum('produtor','consumidor') NOT NULL DEFAULT 'consumidor',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `tipo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'João Agricultor', 'joao@fazenda.com', '2025-11-26 02:18:50', '$2y$12$QjGHphZcR2Q6TzZb5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5', 'produtor', NULL, '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(2, 'Maria Hortifruti', 'maria@horta.com', '2025-11-26 02:18:50', '$2y$12$QjGHphZcR2Q6TzZb5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5', 'produtor', NULL, '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(3, 'Carlos Consumidor', 'carlos@email.com', '2025-11-26 02:18:50', '$2y$12$QjGHphZcR2Q6TzZb5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5', 'consumidor', NULL, '2025-11-26 02:18:50', '2025-11-26 02:18:50'),
(4, 'Ana Consumidora', 'ana@email.com', '2025-11-26 02:18:50', '$2y$12$QjGHphZcR2Q6TzZb5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5Z8eG5p5', 'consumidor', NULL, '2025-11-26 02:18:50', '2025-11-26 02:18:50');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_dashboard_consumidor`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_dashboard_consumidor` (
`consumidor_id` bigint(20) unsigned
,`nome` varchar(255)
,`total_pedidos` bigint(21)
,`total_gasto` decimal(30,2)
,`carrinhos_ativos` bigint(21)
,`ultimo_pedido` timestamp
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_feiras_ativas`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_feiras_ativas` (
`id` bigint(20) unsigned
,`feira_nome` varchar(255)
,`produtor_nome` varchar(255)
,`data_inicio` datetime
,`data_fim` datetime
,`cidade` varchar(255)
,`estado` varchar(2)
,`total_produtos` bigint(21)
,`total_pedidos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_produtos_disponiveis`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_produtos_disponiveis` (
`id` bigint(20) unsigned
,`nome` varchar(255)
,`descricao` text
,`categoria` enum('hortalica','fruta','grao','legume','outros')
,`preco` decimal(8,2)
,`unidade_medida` varchar(50)
,`quantidade_disponivel` int(11)
,`foto` varchar(255)
,`produtor_nome` varchar(255)
,`cidade` varchar(255)
,`estado` varchar(2)
,`feira_id` bigint(20) unsigned
,`feira_nome` varchar(255)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `vw_vendas_produtor`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `vw_vendas_produtor` (
`produtor_id` bigint(20) unsigned
,`produtor_nome` varchar(255)
,`total_pedidos` bigint(21)
,`total_itens_vendidos` bigint(21)
,`total_vendas` decimal(30,2)
,`ticket_medio` decimal(12,6)
);

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_dashboard_consumidor`
--
DROP TABLE IF EXISTS `vw_dashboard_consumidor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_dashboard_consumidor`  AS SELECT `c`.`id` AS `consumidor_id`, `c`.`nome` AS `nome`, count(distinct `ped`.`id`) AS `total_pedidos`, sum(`ped`.`total`) AS `total_gasto`, count(distinct `car`.`id`) AS `carrinhos_ativos`, max(`ped`.`created_at`) AS `ultimo_pedido` FROM ((`consumidores` `c` left join `pedidos` `ped` on(`c`.`id` = `ped`.`consumidor_id`)) left join `carrinhos` `car` on(`c`.`id` = `car`.`consumidor_id`)) GROUP BY `c`.`id`, `c`.`nome` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_feiras_ativas`
--
DROP TABLE IF EXISTS `vw_feiras_ativas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_feiras_ativas`  AS SELECT `f`.`id` AS `id`, `f`.`nome` AS `feira_nome`, `p`.`nome` AS `produtor_nome`, `f`.`data_inicio` AS `data_inicio`, `f`.`data_fim` AS `data_fim`, `f`.`cidade` AS `cidade`, `f`.`estado` AS `estado`, count(distinct `pr`.`id`) AS `total_produtos`, count(distinct `ped`.`id`) AS `total_pedidos` FROM (((`feiras` `f` join `produtores` `p` on(`f`.`produtor_id` = `p`.`id`)) left join `produtos` `pr` on(`p`.`id` = `pr`.`produtor_id` and `pr`.`disponivel` = 1)) left join `pedidos` `ped` on(`f`.`id` = `ped`.`feira_id`)) WHERE `f`.`ativa` = 1 AND `f`.`status` = 'em_andamento' AND `f`.`data_inicio` <= current_timestamp() AND `f`.`data_fim` >= current_timestamp() GROUP BY `f`.`id`, `f`.`nome`, `p`.`nome`, `f`.`data_inicio`, `f`.`data_fim`, `f`.`cidade`, `f`.`estado` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_produtos_disponiveis`
--
DROP TABLE IF EXISTS `vw_produtos_disponiveis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_produtos_disponiveis`  AS SELECT `p`.`id` AS `id`, `p`.`nome` AS `nome`, `p`.`descricao` AS `descricao`, `p`.`categoria` AS `categoria`, `p`.`preco` AS `preco`, `p`.`unidade_medida` AS `unidade_medida`, `p`.`quantidade_disponivel` AS `quantidade_disponivel`, `p`.`foto` AS `foto`, `prod`.`nome` AS `produtor_nome`, `prod`.`cidade` AS `cidade`, `prod`.`estado` AS `estado`, `f`.`id` AS `feira_id`, `f`.`nome` AS `feira_nome` FROM ((`produtos` `p` join `produtores` `prod` on(`p`.`produtor_id` = `prod`.`id`)) left join `feiras` `f` on(`prod`.`id` = `f`.`produtor_id` and `f`.`ativa` = 1 and `f`.`status` = 'em_andamento')) WHERE `p`.`disponivel` = 1 AND `p`.`quantidade_disponivel` > 0 AND `prod`.`ativo` = 1 ;

-- --------------------------------------------------------

--
-- Estrutura para vista `vw_vendas_produtor`
--
DROP TABLE IF EXISTS `vw_vendas_produtor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_vendas_produtor`  AS SELECT `p`.`id` AS `produtor_id`, `p`.`nome` AS `produtor_nome`, count(distinct `ped`.`id`) AS `total_pedidos`, count(`pi`.`id`) AS `total_itens_vendidos`, sum(`pi`.`subtotal`) AS `total_vendas`, avg(`pi`.`subtotal`) AS `ticket_medio` FROM (((`produtores` `p` join `produtos` `pr` on(`p`.`id` = `pr`.`produtor_id`)) join `pedido_items` `pi` on(`pr`.`id` = `pi`.`produto_id`)) join `pedidos` `ped` on(`pi`.`pedido_id` = `ped`.`id`)) WHERE `ped`.`status` <> 'cancelado' GROUP BY `p`.`id`, `p`.`nome` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices para tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices para tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrinhos_consumidor_id_foreign` (`consumidor_id`),
  ADD KEY `carrinhos_feira_id_foreign` (`feira_id`);

--
-- Índices para tabela `carrinho_items`
--
ALTER TABLE `carrinho_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrinho_items_carrinho_id_foreign` (`carrinho_id`),
  ADD KEY `carrinho_items_produto_id_foreign` (`produto_id`);

--
-- Índices para tabela `consumidores`
--
ALTER TABLE `consumidores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consumidores_cpf_unique` (`cpf`),
  ADD KEY `consumidores_user_id_foreign` (`user_id`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `feiras`
--
ALTER TABLE `feiras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feiras_produtor_id_foreign` (`produtor_id`),
  ADD KEY `feiras_ativa_index` (`ativa`),
  ADD KEY `feiras_status_index` (`status`),
  ADD KEY `feiras_data_inicio_index` (`data_inicio`),
  ADD KEY `feiras_data_fim_index` (`data_fim`);

--
-- Índices para tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices para tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pedidos_codigo_pedido_unique` (`codigo_pedido`),
  ADD KEY `pedidos_consumidor_id_foreign` (`consumidor_id`),
  ADD KEY `pedidos_feira_id_foreign` (`feira_id`),
  ADD KEY `pedidos_status_index` (`status`),
  ADD KEY `pedidos_created_at_index` (`created_at`);

--
-- Índices para tabela `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_items_pedido_id_foreign` (`pedido_id`),
  ADD KEY `pedido_items_produto_id_foreign` (`produto_id`);

--
-- Índices para tabela `produtores`
--
ALTER TABLE `produtores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produtores_documento_unique` (`documento`),
  ADD KEY `produtores_user_id_foreign` (`user_id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_produtor_id_foreign` (`produtor_id`),
  ADD KEY `produtos_categoria_index` (`categoria`),
  ADD KEY `produtos_disponivel_index` (`disponivel`),
  ADD KEY `produtos_quantidade_disponivel_index` (`quantidade_disponivel`);

--
-- Índices para tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_tipo_index` (`tipo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `carrinho_items`
--
ALTER TABLE `carrinho_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `consumidores`
--
ALTER TABLE `consumidores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `feiras`
--
ALTER TABLE `feiras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedido_items`
--
ALTER TABLE `pedido_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtores`
--
ALTER TABLE `produtores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `carrinhos_consumidor_id_foreign` FOREIGN KEY (`consumidor_id`) REFERENCES `consumidores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrinhos_feira_id_foreign` FOREIGN KEY (`feira_id`) REFERENCES `feiras` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `carrinho_items`
--
ALTER TABLE `carrinho_items`
  ADD CONSTRAINT `carrinho_items_carrinho_id_foreign` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinhos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrinho_items_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `consumidores`
--
ALTER TABLE `consumidores`
  ADD CONSTRAINT `consumidores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `feiras`
--
ALTER TABLE `feiras`
  ADD CONSTRAINT `feiras_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_consumidor_id_foreign` FOREIGN KEY (`consumidor_id`) REFERENCES `consumidores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_feira_id_foreign` FOREIGN KEY (`feira_id`) REFERENCES `feiras` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD CONSTRAINT `pedido_items_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_items_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `produtores`
--
ALTER TABLE `produtores`
  ADD CONSTRAINT `produtores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_produtor_id_foreign` FOREIGN KEY (`produtor_id`) REFERENCES `produtores` (`id`) ON DELETE CASCADE;
--
-- Banco de dados: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Extraindo dados da tabela `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"\",\"table\":\"users\"}]');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Extraindo dados da tabela `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-11-26 02:04:59', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"pt\"}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estrutura da tabela `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Índices para tabela `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Índices para tabela `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Índices para tabela `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Índices para tabela `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Índices para tabela `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Índices para tabela `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Índices para tabela `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Índices para tabela `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Índices para tabela `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Índices para tabela `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Índices para tabela `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Índices para tabela `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Índices para tabela `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Índices para tabela `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Índices para tabela `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Índices para tabela `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Índices para tabela `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Banco de dados: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
