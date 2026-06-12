-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Banco de Dados:               aluga_mais
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- --------------------------------------------------------
-- Estrutura para tabela cache
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estrutura para tabela cache_locks
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estrutura para tabela clientes
-- --------------------------------------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone1` varchar(20) NOT NULL,
  `telefone2` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `logradouro` varchar(200) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `observacoes` text,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_cpf_unique` (`cpf`),
  UNIQUE KEY `clientes_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela clientes
INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone1`, `telefone2`, `cpf`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `observacoes`, `ativo`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(5, 'NILSON CAMPOS DA SILVA', 'nilson711@gmail.com', '(61) 99502-2652', NULL, '123.456.789-00', '73360-402', 'Quadra 4 Conjunto B', '04', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', NULL, 1, '2026-04-28 23:52:00', '2026-04-28 23:54:58', NULL, 1),
(9, 'Fabiana', 'sarabi@hotmail.com', '61995166546', NULL, '98369185854', '73360401', 'Quadra 4 Conjunto A', '55', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 'cliente vip', 1, '2026-05-14 23:54:08', '2026-05-14 23:54:08', NULL, 1),
(7, 'sthefanie', NULL, '(61) 9965-4654', NULL, '957.785.930-58', '73360510', 'Quadra 5 Conjunto J', '55', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', NULL, 1, '2026-05-01 12:19:34', '2026-05-01 12:19:34', NULL, 1),
(6, 'João Paulo da Silva Sauro', 'joao@gmail.com', '(61) 9965-4654', '(61) 9965-4654', '810.662.871-04', '73360410', 'Quadra 4 Conjunto J', '22', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 'dfdfdfd', 1, '2026-05-01 15:00:46', '2026-05-01 15:10:41', NULL, 1),
(8, 'joão', NULL, '(61) 9965-4654', '(61) 9965-4654', '287.747.101-25', '73369506', 'Quadra MR 04', '09', NULL, 'Residencial Condomínio Marissol (Planaltina)', 'Brasília', 'DF', NULL, 1, '2026-05-07 22:37:08', '2026-05-07 22:37:08', NULL, 1),
(11, 'Nathalia Martins de Souza', NULL, '61986066451', NULL, '12345678979', '70910900', 'Campus Universitário Darcy Ribeiro', '408', NULL, 'Asa Norte', 'Brasília', 'DF', 'LOCALICAÇÃO: https://www.google.com/maps/search/Ceftru/@-15.772836685180664,-47.86695098876953,17z?hl=pt-BR', 1, '2026-05-19 20:36:13', '2026-05-19 20:36:13', NULL, 1),
(10, 'Miguel de Sousa Campos', 'guel2012@gmail.com', '61996546546', NULL, '12345657498', '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', NULL, 1, '2026-05-18 23:12:08', '2026-05-31 11:28:22', NULL, 1);

-- --------------------------------------------------------
-- Estrutura para tabela equipamentos
-- --------------------------------------------------------
DROP TABLE IF EXISTS `equipamentos`;
CREATE TABLE IF NOT EXISTS `equipamentos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `observacoes` text,
  `preco_diaria` decimal(10,2) DEFAULT NULL,
  `preco_semanal` decimal(10,2) DEFAULT NULL,
  `preco_mensal` decimal(10,2) DEFAULT NULL,
  `caucao` decimal(10,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `especificacoes` text,
  `status` varchar(30) DEFAULT 'Disponível',
  `data_aquisicao` date DEFAULT NULL,
  `valor_aquisicao` decimal(10,2) DEFAULT NULL,
  `data_venda` date DEFAULT NULL,
  `valor_venda` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `numero_patrimonio` varchar(50) DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipamentos_numero_patrimonio_unique` (`numero_patrimonio`),
  KEY `equipamentos_status_index` (`status`),
  KEY `equipamentos_categoria_index` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela equipamentos
INSERT INTO `equipamentos` (`id`, `nome`, `marca`, `modelo`, `categoria`, `observacoes`, `preco_diaria`, `preco_semanal`, `preco_mensal`, `caucao`, `foto`, `especificacoes`, `status`, `data_aquisicao`, `valor_aquisicao`, `data_venda`, `valor_venda`, `created_at`, `updated_at`, `deleted_at`, `numero_patrimonio`, `user_id`) VALUES
(4, 'Jogo de Mesa e Cadeiras', 'Probel', 'Mesa Pirinópolis', 'Mesa', NULL, 12.00, 30.00, 300.00, NULL, NULL, 'JOGO DE MESA DE PLASTICO QUADRADA\n01 Mesa - Altura: 72cm, Largura: 70cm, Comprimento: 70cm, COR: Branca.\n04 Cadeiras suportando a carga de 140 kg.', 'Disponível', '2026-04-28', 270.00, NULL, NULL, '2026-04-29 00:42:01', '2026-04-29 00:42:01', NULL, NULL, NULL),
(5, 'Cadeira Avulsa', 'Roma', 'Bistrô Tedras', 'Cadeira', NULL, 4.00, 28.00, 112.00, NULL, NULL, 'Cadeira de Plástico  - Branca \nMaterial: Polipropileno\nMedidas: Altura 87 cm, Largura 42 cm, Comprimento 48,5 cm\nCapacidade:  182kg.', 'Disponível', '2026-04-28', 45.00, NULL, NULL, '2026-04-29 00:51:27', '2026-04-29 00:51:27', NULL, NULL, NULL),
(6, 'mesa de Plástico Quadrada Avulsa Branca', 'Probel', 'Pirinópolis', 'Mesa', NULL, 10.00, 70.00, 280.00, NULL, NULL, 'MESA DE PLASTICO QUADRADA - BRANCA\nAltura: 72cm, Largura: 70cm, Comprimento: 70cm', 'Disponível', NULL, 80.00, NULL, NULL, '2026-04-29 01:03:55', '2026-05-01 14:21:32', NULL, NULL, NULL),
(11, 'Mesa de Plástico Quadrada Avulsa Branca', 'Favero', '56546', 'Mesa', NULL, 4.00, 10.00, 50.00, 400.00, NULL, 'dfdfd', 'Alugado', NULL, 25.00, NULL, NULL, '2026-05-01 14:03:59', '2026-05-01 15:52:54', NULL, '4567986', NULL),
(12, 'Cadeira Avulsa', 'Consul', 'Bistrô Tedras', 'Cadeira', 'df', 4.00, 28.00, 112.00, 400.00, NULL, 'dfdf', 'Vendido', NULL, 45.00, NULL, NULL, '2026-05-01 14:04:23', '2026-05-01 15:53:28', NULL, 'PAT2026050005', NULL),
(1, 'Freezer 2 portas eletrolux', 'eletrolux', 'm400', 'Refrigeração', NULL, 180.99, 600.00, 3000.25, 400.00, NULL, NULL, 'Vendido', '2025-10-14', 2455.27, NULL, NULL, '2026-04-15 22:22:27', '2026-04-15 22:52:49', NULL, NULL, NULL),
(2, 'Freezer Horizontal Inverter Dupla Ação Chest Freezer 546 Litros Branco Bivolt', 'Metalfrio', 'DA550IFT01', 'Refrigeração', NULL, 101.88, 550.00, 2212.32, 500.00, NULL, '127 Volts, 220 Volts,\n70,5P x 94L x 9A centímetros', 'Disponível', '2026-04-15', 3779.10, NULL, NULL, '2026-04-15 23:07:29', '2026-04-15 23:08:50', NULL, NULL, NULL),
(3, 'Freezer Horizontal ELETROLUX 2 Portas 534L CHB53EB CHB53EBANA', 'eletrolux', 'CHB53EB CHB53EBANA', 'Refrigeração', 'amassado na tampa. Uma rodinha quebrada. com ferrugem na lateral.', 355.55, 555.55, 5000.55, 0.00, NULL, 'Capacidade Líquida Total: 534L\nFormato: Horizontal / Vertical\nQuantidade de Portas: 2\nDimensões do Produto: Largura: 147,3cm Altura: 96cm Profundidade: 78cm\nVoltagem: 220V', 'Vendido', '2026-04-12', 1300.00, NULL, NULL, '2026-04-19 00:45:31', '2026-04-19 00:52:49', NULL, NULL, NULL),
(7, 'Freezer 2 portas eletrolux premium', 'Electrolux', 'ele4088', 'Refrigeração', NULL, 100.00, 600.00, 3000.00, NULL, NULL, 'duas portas branco', 'Disponível', '2026-05-01', 2500.00, NULL, NULL, '2026-05-01 13:37:00', '2026-05-01 13:37:00', NULL, 'PAT2026050001', NULL),
(9, 'freezer brastemp', 'Brastemp', '8565645', 'Refrigeração', NULL, 100.00, 400.00, 3000.00, NULL, NULL, 'dfadf', 'Disponível', '2026-05-01', 1000.00, NULL, NULL, '2026-05-01 13:58:01', '2026-05-01 13:58:01', NULL, 'PAT2026050003', NULL),
(8, 'Freezer 2 portas eletrolux premium', 'Electrolux', 'ele4088', 'Refrigeração', NULL, 119.97, 600.00, 3000.00, 400.00, NULL, 'Capacidade Líquida Total: 534L\nFormato: Horizontal / Vertical\nQuantidade de Portas: 2\nDimensões do Produto: \nLargura: 147,3cm\nAltura: 96cm\nProfundidade: 78cm\nVoltagem: 220V', 'Disponível', NULL, 2500.00, NULL, NULL, '2026-05-01 13:51:53', '2026-05-28 07:56:10', NULL, 'PAT2026050002', NULL),
(10, 'freezzer lg', 'Electrolux', '5454', 'Refrigeração', NULL, 100.00, 300.00, 500.00, 400.00, NULL, 'dfdfd', 'Manutenção', NULL, NULL, NULL, NULL, '2026-05-01 13:59:42', '2026-05-01 15:53:12', NULL, 'PAT2026050004', NULL),
(14, 'geladeira frost free', 'Consul', NULL, 'Refrigeração', NULL, 1000.00, 400.00, 6000.00, 500.00, NULL, 'Capacidade Líquida Total: 534L\nFormato: Horizontal / Vertical\nQuantidade de Portas: 2\nDimensões do Produto: \nLargura: 147,3cm\nAltura: 96cm\nProfundidade: 78cm\nVoltagem: 220V', 'Disponível', NULL, NULL, NULL, NULL, '2026-05-02 10:53:57', '2026-05-02 10:53:57', NULL, 'PAT2026050007', NULL),
(15, 'freezer blblblb', 'Electrolux', 'dfdfdfd', 'Refrigeração', NULL, 100.00, 700.00, 5000.00, 5000.00, NULL, 'Capacidade Líquida Total: 534L\nFormato: Horizontal / Vertical\nQuantidade de Portas: 2\nDimensões do Produto: \nLargura: 147,3cm\nAltura: 96cm\nProfundidade: 78cm\nVoltagem: 220V', 'Disponível', NULL, 1000.00, NULL, NULL, '2026-05-07 22:23:53', '2026-05-07 22:23:53', NULL, 'PAT2026050008', NULL),
(13, 'Freezer Consul', 'Outra', NULL, 'Refrigeração', NULL, 120.00, 400.00, 6.00, 400.00, NULL, 'Capacidade Líquida Total: 534L\nFormato: Horizontal / Vertical\nQuantidade de Portas: 2\nDimensões do Produto: \nLargura: 147,3cm\nAltura: 96cm\nProfundidade: 78cm\nVoltagem: 220V', 'Disponível', NULL, NULL, NULL, NULL, '2026-05-02 10:46:37', '2026-05-28 07:56:33', NULL, 'PAT2026050006', NULL),
(16, 'Ventilador', 'Outra', 'arno', 'Climatizador', 'ADSFASFASF', 50.00, 70.00, 500.00, 50.00, NULL, 'Tipo: Climatizador / Ventilador / Ar Condicionado\n        Capacidade do Reservatório: \n        Vazão de Ar: \n        Velocidades: \n        Timer: \n        Controle:\n        Voltagem:\n        Dimensões: \n        Peso: \n        Ruído: \n        Incluso:', 'Disponível', '2026-05-31', 150.00, NULL, NULL, '2026-05-31 10:59:03', '2026-05-31 10:59:03', NULL, 'PAT2026050009', NULL);

-- --------------------------------------------------------
-- Estrutura para tabela itens_pedido
-- --------------------------------------------------------
DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE IF NOT EXISTS `itens_pedido` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint UNSIGNED NOT NULL,
  `equipamento_id` bigint UNSIGNED NOT NULL,
  `quantidade` int NOT NULL DEFAULT 1,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `observacoes` text,
  `devolvido` tinyint(1) NOT NULL DEFAULT 0,
  `data_devolucao_item` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `data_devolucao_real` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `itens_pedido_pedido_id_equipamento_id_unique` (`pedido_id`,`equipamento_id`),
  KEY `itens_pedido_pedido_id_foreign` (`pedido_id`),
  KEY `itens_pedido_equipamento_id_foreign` (`equipamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela itens_pedido
INSERT INTO `itens_pedido` (`id`, `pedido_id`, `equipamento_id`, `quantidade`, `preco_unitario`, `subtotal`, `observacoes`, `devolvido`, `data_devolucao_item`, `created_at`, `updated_at`, `data_devolucao_real`) VALUES
(1, 1, 8, 1, 100.00, 100.00, NULL, 0, NULL, '2026-05-14 22:51:02', '2026-05-14 22:51:02', NULL),
(2, 1, 4, 5, 12.00, 60.00, NULL, 0, NULL, '2026-05-14 22:51:02', '2026-05-14 22:51:02', NULL),
(3, 2, 8, 1, 100.00, 100.00, NULL, 0, NULL, '2026-05-14 23:30:25', '2026-05-14 23:30:25', NULL),
(4, 2, 4, 6, 12.00, 72.00, NULL, 0, NULL, '2026-05-14 23:30:25', '2026-05-14 23:30:25', NULL),
(5, 3, 9, 1, 100.00, 100.00, NULL, 0, NULL, '2026-05-19 08:02:30', '2026-05-19 08:02:30', NULL),
(6, 3, 4, 10, 12.00, 120.00, NULL, 0, NULL, '2026-05-19 08:02:30', '2026-05-19 08:02:30', NULL),
(7, 4, 4, 1, 12.00, 12.00, NULL, 0, NULL, '2026-05-19 08:21:48', '2026-05-19 08:21:48', NULL),
(8, 5, 4, 10, 36.00, 360.00, NULL, 0, NULL, '2026-05-19 08:24:10', '2026-05-19 08:24:10', NULL),
(9, 5, 13, 1, 300.00, 300.00, NULL, 0, NULL, '2026-05-19 08:24:10', '2026-05-19 08:24:10', NULL),
(10, 6, 15, 1, 300.00, 300.00, NULL, 0, NULL, '2026-05-19 08:49:18', '2026-05-19 08:49:18', NULL),
(11, 6, 4, 10, 36.00, 360.00, NULL, 0, NULL, '2026-05-19 08:49:18', '2026-05-19 08:49:18', NULL),
(12, 7, 14, 1, 2000.00, 2000.00, NULL, 0, NULL, '2026-05-19 08:50:43', '2026-05-19 08:50:43', NULL),
(13, 7, 4, 15, 24.00, 360.00, NULL, 0, NULL, '2026-05-19 08:50:43', '2026-05-19 08:50:43', NULL),
(14, 8, 2, 1, 101.88, 101.88, NULL, 0, NULL, '2026-05-19 08:51:56', '2026-05-19 08:51:56', NULL),
(15, 8, 6, 14, 10.00, 140.00, NULL, 0, NULL, '2026-05-19 08:51:56', '2026-05-19 08:51:56', NULL),
(16, 9, 9, 1, 200.00, 200.00, NULL, 0, NULL, '2026-05-19 19:57:51', '2026-05-19 19:57:51', NULL),
(17, 9, 4, 10, 24.00, 240.00, NULL, 0, NULL, '2026-05-19 19:57:51', '2026-05-19 19:57:51', NULL),
(18, 9, 5, 5, 8.00, 40.00, NULL, 0, NULL, '2026-05-19 19:57:51', '2026-05-19 19:57:51', NULL),
(19, 10, 7, 1, 1500.00, 1500.00, NULL, 0, NULL, '2026-05-19 20:38:47', '2026-05-19 20:38:47', NULL),
(20, 11, 13, 2, 120.00, 240.00, NULL, 0, NULL, '2026-05-31 09:36:11', '2026-05-31 09:36:11', NULL),
(21, 12, 15, 1, 200.00, 200.00, NULL, 0, NULL, '2026-05-31 09:44:04', '2026-05-31 09:44:04', NULL),
(22, 13, 14, 1, 1000.00, 1000.00, NULL, 1, NULL, '2026-05-31 09:56:09', '2026-05-31 10:24:53', '2026-05-31 10:24:53'),
(23, 14, 4, 1, 24.00, 24.00, NULL, 0, NULL, '2026-05-31 11:19:46', '2026-05-31 11:19:46', NULL),
(24, 15, 14, 1, 2000.00, 2000.00, NULL, 0, NULL, '2026-05-31 11:22:13', '2026-05-31 11:22:13', NULL),
(25, 16, 9, 1, 200.00, 200.00, NULL, 0, NULL, '2026-05-31 11:25:38', '2026-05-31 11:25:38', NULL),
(26, 17, 4, 1, 24.00, 24.00, NULL, 0, NULL, '2026-05-31 11:29:21', '2026-05-31 11:29:21', NULL),
(27, 18, 6, 1, 20.00, 20.00, NULL, 0, NULL, '2026-05-31 11:30:31', '2026-05-31 11:30:31', NULL),
(28, 19, 14, 1, 2000.00, 2000.00, NULL, 0, NULL, '2026-05-31 11:34:14', '2026-05-31 11:34:14', NULL),
(29, 20, 15, 1, 100.00, 100.00, NULL, 0, NULL, '2026-05-31 11:45:27', '2026-05-31 11:45:27', NULL),
(30, 21, 9, 1, 100.00, 100.00, NULL, 0, NULL, '2026-06-01 22:24:29', '2026-06-01 22:24:29', NULL),
(35, 22, 15, 1, 100.00, 100.00, NULL, 0, NULL, '2026-06-01 23:20:27', '2026-06-01 23:20:27', NULL),
(36, 23, 4, 1, 12.00, 12.00, NULL, 0, NULL, '2026-06-01 23:39:40', '2026-06-01 23:39:40', NULL),
(38, 24, 13, 1, 240.00, 240.00, NULL, 0, NULL, '2026-06-01 23:53:58', '2026-06-01 23:53:58', NULL),
(39, 25, 8, 1, 119.97, 119.97, NULL, 0, NULL, '2026-06-02 00:07:36', '2026-06-02 00:07:36', NULL),
(40, 26, 15, 1, 100.00, 100.00, NULL, 0, NULL, '2026-06-02 00:31:20', '2026-06-02 00:31:20', NULL),
(41, 27, 4, 1, 12.00, 12.00, NULL, 0, NULL, '2026-06-02 00:41:13', '2026-06-02 00:41:13', NULL);

-- --------------------------------------------------------
-- Estrutura para tabela migrations
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela migrations
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_15_161137_create_clientes_table', 2),
(5, '2026_04_15_161202_create_equipamentos_table', 2),
(6, '2026_04_15_161212_create_pedidos_table', 2),
(7, '2026_04_15_161236_create_itens_pedido_table', 2),
(8, '2026_05_01_131849_add_numero_patrimonio_to_equipamentos_table', 3),
(9, '2026_05_01_144638_add_user_id_to_clientes_table', 4),
(10, '2026_05_01_144646_add_user_id_to_equipamentos_table', 4),
(11, '2026_05_01_144652_add_user_id_to_pedidos_table', 4),
(12, '2026_05_01_142128_rename_ativo_to_status_in_equipamentos_table', 5),
(14, '2026_05_14_231830_add_endereco_entrega_to_pedidos_table', 6),
(15, '2026_05_14_233712_ajustar_tamanho_campos_clientes_table', 7),
(16, '2026_05_19_005926_change_dias_totais_to_decimal_in_pedidos_table', 7),
(17, '2026_05_19_010208_increase_telefone_size_in_clientes_table', 7),
(18, '2026_05_19_084503_add_data_devolucao_real_to_itens_pedido_table', 7),
(19, '2026_05_28_080628_add_taxa_entrega_to_pedidos_table', 8),
(20, '2026_05_31_083538_add_cpf_pedido_to_pedidos_table', 9),
(21, '2026_05_31_084636_add_cnpj_pedido_to_pedidos_table', 10),
(22, '2026_05_31_110859_add_localizacao_to_pedidos_table', 11);

-- --------------------------------------------------------
-- Estrutura para tabela pedidos
-- --------------------------------------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `data_entrega` datetime NOT NULL,
  `data_devolucao` datetime NOT NULL,
  `dias_totais` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `desconto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pendente',
  `observacoes` text,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `caucao_pago` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `cep_entrega` varchar(10) DEFAULT NULL,
  `logradouro_entrega` varchar(200) DEFAULT NULL,
  `numero_entrega` varchar(10) DEFAULT NULL,
  `complemento_entrega` varchar(100) DEFAULT NULL,
  `bairro_entrega` varchar(100) DEFAULT NULL,
  `cidade_entrega` varchar(100) DEFAULT NULL,
  `uf_entrega` varchar(2) DEFAULT NULL,
  `taxa_entrega` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cpf_pedido` varchar(18) DEFAULT NULL,
  `cnpj_pedido` varchar(18) DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidos_cliente_id_foreign` (`cliente_id`),
  KEY `pedidos_status_index` (`status`),
  KEY `pedidos_created_at_index` (`created_at`),
  KEY `pedidos_data_entrega_index` (`data_entrega`),
  KEY `pedidos_data_devolucao_index` (`data_devolucao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela pedidos
INSERT INTO `pedidos` (`id`, `cliente_id`, `data_entrega`, `data_devolucao`, `dias_totais`, `subtotal`, `desconto`, `total`, `status`, `observacoes`, `forma_pagamento`, `caucao_pago`, `created_at`, `updated_at`, `user_id`, `cep_entrega`, `logradouro_entrega`, `numero_entrega`, `complemento_entrega`, `bairro_entrega`, `cidade_entrega`, `uf_entrega`, `taxa_entrega`, `cpf_pedido`, `cnpj_pedido`, `localizacao`, `latitude`, `longitude`) VALUES
(1, 8, '2026-05-16 10:00:00', '2026-05-17 10:00:00', 1.00, 160.00, 10.00, 150.00, 'aprovado', 'entregar na portaria', 'pix', 0.00, '2026-05-14 22:51:02', '2026-05-19 08:40:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(2, 5, '2026-05-15 23:29:00', '2026-05-16 23:29:00', 1.00, 172.00, 2.00, 170.00, 'aprovado', 'entregar na portaria', 'pix', 0.00, '2026-05-14 23:30:25', '2026-05-19 08:40:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL, NULL),
(3, 6, '2026-05-19 13:00:00', '2026-05-20 10:00:00', 0.88, 220.00, 0.00, 220.00, 'devolvido', 'anotaçõe sobre o pedido', 'cartao_credito', 0.00, '2026-05-19 08:02:29', '2026-05-19 08:43:37', NULL, '73360410', 'Quadra 4 Conjunto J', '22', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(4, 7, '2026-05-19 13:00:00', '2026-05-20 10:30:00', 0.90, 12.00, 0.00, 12.00, 'devolvido', NULL, 'dinheiro', 0.00, '2026-05-19 08:21:48', '2026-05-19 08:44:16', NULL, '73360510', 'Quadra 5 Conjunto J', '55', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(5, 9, '2026-05-22 10:00:00', '2026-05-25 10:00:00', 3.00, 660.00, 0.00, 660.00, 'devolvido', NULL, 'dinheiro', 0.00, '2026-05-19 08:24:10', '2026-05-19 08:47:50', NULL, '73360401', 'Quadra 4 Conjunto A', '55', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(9, 6, '2026-05-20 09:00:00', '2026-05-21 10:00:00', 1.04, 480.00, 0.00, 480.00, 'devolvido', 'qualquer observação', 'pix', 0.00, '2026-05-19 19:57:51', '2026-05-19 20:05:09', NULL, '73360410', 'Quadra 4 Conjunto J', '22', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(6, 10, '2026-05-20 12:30:00', '2026-05-22 13:00:00', 2.02, 660.00, 0.00, 660.00, 'devolvido', NULL, 'pix', 0.00, '2026-05-19 08:49:18', '2026-05-19 20:15:31', NULL, '73360407', 'Quadra 4 Conjunto G', '77', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(8, 9, '2026-05-20 13:00:00', '2026-05-20 21:30:00', 0.35, 241.88, 0.00, 241.88, 'cancelado', NULL, 'pix', 0.00, '2026-05-19 08:51:56', '2026-05-19 20:17:55', NULL, '73360401', 'Quadra 4 Conjunto A', '55', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(10, 11, '2026-05-20 14:00:00', '2026-06-04 10:00:00', 14.83, 1500.00, 0.00, 1500.00, 'retirado', 'LOCALIZAÇÃO: <a>https://www.google.com/maps/search/Ceftru/@-15.772836685180664,-47.86695098876953,17z?hl=pt-BR</a>', 'pix', 0.00, '2026-05-19 20:38:47', '2026-05-31 08:59:47', NULL, '70910900', 'Campus Universitário Darcy Ribeiro', '408', NULL, 'Asa Norte', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(7, 5, '2026-05-20 20:00:00', '2026-05-22 13:00:00', 1.71, 2360.00, 0.00, 2360.00, 'entregue', NULL, 'boleto', 0.00, '2026-05-19 08:50:43', '2026-05-31 09:01:37', NULL, '73360-402', 'Quadra 4 Conjunto B', '04', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 0.00, NULL, NULL, NULL, NULL, NULL),
(11, 5, '2026-06-01 10:30:00', '2026-06-02 10:30:00', 1.00, 240.00, 10.00, 240.00, 'devolvido', NULL, 'dinheiro', 0.00, '2026-05-31 09:36:11', '2026-05-31 09:43:03', NULL, '73360-402', 'Quadra 4 Conjunto B', '04', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, NULL, NULL, NULL),
(12, 10, '2026-05-31 10:00:00', '2026-06-01 11:00:00', 1.04, 200.00, 0.00, 210.00, 'retirado', NULL, 'pix', 0.00, '2026-05-31 09:44:04', '2026-05-31 09:45:43', NULL, '73360407', 'Quadra 4 Conjunto G', '77', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, NULL, NULL, NULL),
(13, 8, '2026-05-31 10:30:00', '2026-06-01 10:30:00', 1.00, 1000.00, 0.00, 1010.00, 'devolvido', NULL, 'cartao_debito', 0.00, '2026-05-31 09:56:09', '2026-05-31 10:24:53', NULL, '73369506', 'Quadra MR 04', '09', NULL, 'Residencial Condomínio Marissol (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, NULL, NULL, NULL),
(14, 10, '2026-06-01 11:30:00', '2026-06-02 12:30:00', 1.04, 24.00, 0.00, 34.00, 'cancelado', NULL, 'dinheiro', 0.00, '2026-05-31 11:19:46', '2026-05-31 11:21:43', NULL, '73360407', 'Quadra 4 Conjunto G', '77', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, NULL, NULL, NULL),
(15, 10, '2026-06-01 10:00:00', '2026-06-02 10:30:00', 1.02, 2000.00, 0.00, 2010.00, 'cancelado', NULL, 'pix', 0.00, '2026-05-31 11:22:13', '2026-05-31 11:24:28', NULL, '73360407', 'Quadra 4 Conjunto G', '77', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?ll=-15.6694297,-48.2019620&navigate=yes', '-15.6694297', '-48.2019620'),
(16, 10, '2026-06-01 10:00:00', '2026-06-02 11:30:00', 1.06, 200.00, 0.00, 210.00, 'cancelado', NULL, 'pix', 0.00, '2026-05-31 11:25:38', '2026-05-31 11:28:55', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?ll=-15.7111171,-47.8768021&navigate=yes', '-15.7111171', '-47.8768021'),
(17, 10, '2026-06-01 10:30:00', '2026-06-02 11:30:00', 1.04, 24.00, 0.00, 34.00, 'cancelado', NULL, 'pix', 0.00, '2026-05-31 11:29:21', '2026-05-31 11:30:01', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, NULL, NULL, NULL),
(18, 10, '2026-06-01 11:00:00', '2026-06-02 13:00:00', 1.08, 20.00, 0.00, 30.00, 'cancelado', NULL, 'pix', 0.00, '2026-05-31 11:30:31', '2026-05-31 11:33:48', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?ll=-15.7111171,-47.8768021&navigate=yes', '-15.7111171', '-47.8768021'),
(19, 10, '2026-06-01 11:00:00', '2026-06-02 11:30:00', 1.02, 2000.00, 0.00, 2010.00, 'cancelado', NULL, 'pix', 0.00, '2026-05-31 11:34:14', '2026-05-31 11:39:14', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, '', '', ''),
(20, 10, '2026-06-02 10:00:00', '2026-06-03 09:30:00', 0.98, 100.00, 0.00, 110.00, 'cancelado', NULL, 'pix', 0.00, '2026-05-31 11:45:27', '2026-06-01 22:23:30', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?ll=-15.623743,-47.647230&navigate=yes', '-15.623743', '-47.647230'),
(25, 8, '2026-06-03 09:00:00', '2026-06-04 08:30:00', 0.98, 119.97, 0.00, 129.97, 'cancelado', NULL, 'boleto', 0.00, '2026-06-02 00:07:36', '2026-06-02 00:15:40', NULL, '73369506', 'Quadra MR 04', '09', NULL, 'Residencial Condomínio Marissol (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://www.google.com/maps/search/?api=1&query=Quadra%20MR%2004%2C%2009%20-%20Residencial%20Condom%C3%ADnio%20Marissol%20(Planaltina)%2C%20Bras%C3%ADlia%20-%20DF%2C%20Brasil', NULL, NULL),
(24, 8, '2026-06-02 09:30:00', '2026-06-03 10:30:00', 1.04, 240.00, 0.00, 250.00, 'entregue', NULL, 'pix', 0.00, '2026-06-01 23:48:44', '2026-06-02 00:07:48', NULL, '73369506', 'Quadra MR 04', '09', NULL, 'Residencial Condomínio Marissol (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?q=Quadra%20MR%2004%2C%2009%2C%20Residencial%20Condom%C3%ADnio%20Marissol%20(Planaltina)%2C%20Bras%C3%ADlia%20-%20DF&navigate=yes', NULL, NULL),
(21, 9, '2026-06-02 10:00:00', '2026-06-03 10:00:00', 1.00, 100.00, 0.00, 110.00, 'cancelado', NULL, 'pix', 0.00, '2026-06-01 22:24:29', '2026-06-02 00:14:38', NULL, '73360401', 'Quadra 4 Conjunto A', '55', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?ll=-15.624401,-47.644845&navigate=yes', '-15.624401', '-47.644845'),
(22, 5, '2026-06-02 13:00:00', '2026-06-03 13:00:00', 1.00, 100.00, 0.00, 110.00, 'cancelado', NULL, 'pix', 0.00, '2026-06-01 22:55:43', '2026-06-02 00:14:48', NULL, '71050150', 'Quadra QE 15', '04', NULL, 'Guará II', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://www.google.com/maps/search/?api=1&query=Quadra%20QE%2015%2C%2004%20-%20Guar%C3%A1%20II%2C%20Bras%C3%ADlia%20-%20DF%2C%20Brasil', '-15.623743', '-47.647230'),
(23, 10, '2026-06-03 10:30:00', '2026-06-04 09:30:00', 0.96, 12.00, 0.00, 22.00, 'cancelado', NULL, 'pix', 0.00, '2026-06-01 23:39:40', '2026-06-02 00:15:45', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?q=Quadra%204%20Conjunto%20B%2C%2054%20-%20Setor%20Residencial%20Leste%20(Planaltina)%2C%20Bras%C3%ADlia%20-%20DF%2C%20Brasil&navigate=yes', NULL, NULL),
(26, 8, '2026-06-02 08:30:00', '2026-06-03 08:30:00', 1.00, 100.00, 0.00, 110.00, 'pendente', NULL, 'pix', 0.00, '2026-06-02 00:31:20', '2026-06-02 00:31:20', NULL, '73369506', 'Quadra MR 04', '09', NULL, 'Residencial Condomínio Marissol (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?q=Quadra%20MR%2004%2C%2009%20-%20Residencial%20Condom%C3%ADnio%20Marissol%20(Planaltina)%2C%20Bras%C3%ADlia%20-%20DF%2C%20Brasil&navigate=yes', NULL, NULL),
(27, 10, '2026-06-03 08:00:00', '2026-06-03 09:30:00', 0.06, 12.00, 0.00, 22.00, 'pendente', NULL, 'pix', 0.00, '2026-06-02 00:41:13', '2026-06-02 00:41:13', NULL, '73360402', 'Quadra 4 Conjunto B', '54', NULL, 'Setor Residencial Leste (Planaltina)', 'Brasília', 'DF', 10.00, NULL, NULL, 'https://waze.com/ul?ll=-15.623743,-47.647230&navigate=yes', '-15.623743', '-47.647230');

-- --------------------------------------------------------
-- Estrutura para tabela users
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nilson', 'nilson711@gmail.com', NULL, '$2y$12$PQfxcggm.2nzuBy8KPZ/quYeFUYoQpTUvBVydNx.dEnydi68SfzEa', NULL, '2026-04-15 20:11:59', '2026-04-15 20:11:59');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;