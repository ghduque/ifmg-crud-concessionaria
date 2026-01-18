--
-- PostgreSQL database dump - AutoNível
-- Compatível com: PostgreSQL 12+
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

-- 1. Criação de Tipos Personalizados (Enums)
CREATE TYPE public.tipo_papel_usuario AS ENUM (
    'comum',
    'admin'
);

ALTER TYPE public.tipo_papel_usuario OWNER TO postgres;

CREATE TYPE public.tipo_status_veiculo AS ENUM (
    'disponivel',
    'reservado',
    'vendido'
);

ALTER TYPE public.tipo_status_veiculo OWNER TO postgres;

-- 2. Estrutura das Tabelas

-- Tabela: Clientes
CREATE TABLE public.clientes (
    id SERIAL PRIMARY KEY,
    nome character varying(100) NOT NULL,
    cpf_cnpj character varying(20) NOT NULL UNIQUE,
    telefone character varying(20),
    email character varying(150),
    endereco text,
    data_cadastro timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE public.clientes OWNER TO postgres;

-- Tabela: Usuários
CREATE TABLE public.usuarios (
    id SERIAL PRIMARY KEY,
    nome character varying(100) NOT NULL,
    email character varying(150) NOT NULL UNIQUE,
    senha_hash character varying(255) NOT NULL,
    papel public.tipo_papel_usuario DEFAULT 'comum'::public.tipo_papel_usuario NOT NULL,
    data_criacao timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    cpf character varying(20),
    telefone character varying(20)
);

ALTER TABLE public.usuarios OWNER TO postgres;

-- Tabela: Veículos
CREATE TABLE public.veiculos (
    id SERIAL PRIMARY KEY,
    marca character varying(50) NOT NULL,
    modelo character varying(50) NOT NULL,
    ano_fabricacao integer NOT NULL,
    ano_modelo integer NOT NULL,
    cor character varying(30),
    placa character varying(10) UNIQUE,
    valor numeric(10,2) NOT NULL,
    descricao text,
    status public.tipo_status_veiculo DEFAULT 'disponivel'::public.tipo_status_veiculo NOT NULL,
    data_cadastro timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    km integer DEFAULT 0
);

ALTER TABLE public.veiculos OWNER TO postgres;

-- Tabela: Fotos dos Veículos
CREATE TABLE public.veiculos_fotos (
    id SERIAL PRIMARY KEY,
    veiculo_id integer NOT NULL,
    url_foto text NOT NULL,
    destaque boolean DEFAULT false
);

ALTER TABLE public.veiculos_fotos OWNER TO postgres;

-- Tabela: Vendas
CREATE TABLE public.vendas (
    id SERIAL PRIMARY KEY,
    cliente_id integer NOT NULL,
    veiculo_id integer NOT NULL UNIQUE,
    vendedor_id integer NOT NULL,
    valor_final numeric(10,2) NOT NULL,
    data_venda timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    observacoes text
);

ALTER TABLE public.vendas OWNER TO postgres;


-- 3. Inserção de Dados (Data Dump)

-- Dados: Clientes
COPY public.clientes (id, nome, cpf_cnpj, telefone, email, endereco, data_cadastro) FROM stdin;
\.

-- Dados: Usuários
-- ATENÇÃO: As senhas abaixo são hashes. Consulte o README para saber a senha original de teste.
COPY public.usuarios (id, nome, email, senha_hash, papel, data_criacao, cpf, telefone) FROM stdin;
2	rafael	rafael@gmail.com	$2y$10$it6jrXp3mUMpsnYlERYDmed8fElK4hLhml.DK6ux7fYS7EBMFCRFC	admin	2026-01-14 18:29:47.046436	14196331637	37213112221
3	usuario	usuario@gmail.com	$2y$10$sOWcJqB7lFrgruFeBn/Eou/d9RKQpBGcgu8t2x3Qq.OUMKMdfYBbq	comum	2026-01-14 18:54:47.491561	13870188685	12353565768
1	Gabriel	admin@autonivel.com	$2y$10$icGuhiMAZ9gd2Z8JJorOce1gu5zgNfDiWQ.aKtJg9C/j4zDCDVTkS	admin	2026-01-13 14:10:04.069176	\N	(35) 99845-8872
4	user teste	teste@teste.com	$2y$10$BjTGkOqs5ynb3gAA/zW0JO8JZEoCsxjnlWoUoYejHVjJqh2h2R8Om	comum	2026-01-16 19:56:08.094965	31825467323	35678544563
\.

-- Dados: Veículos
COPY public.veiculos (id, marca, modelo, ano_fabricacao, ano_modelo, cor, placa, valor, descricao, status, data_cadastro, km) FROM stdin;
4	Fiat	Toro Volcano AT9	2018	2019	\N	\N	98900.00	Motor 2.0 Turbo Diesel\r\nCâmbio Automático / 9 Marchas\r\nTração 4x4\r\nDireção elétrica\r\nPneus novos\r\nFaróis em LED\r\nAr condicionado digital\r\nRetrovisores rebativeis\r\nPartida StartStop\r\nChave Presencial\r\nBancos em couro\r\nComandos no volante	disponivel	2026-01-16 18:59:39.293115	80000
5	BMW	320i GT Sport	2015	2016	\N	\N	101900.00	\N	disponivel	2026-01-16 19:05:04.228589	30000
6	Chevrolet	Tracker Premier 	2024	2024	\N	\N	123900.00	\N	disponivel	2026-01-16 19:07:41.743022	18000
\.

-- Dados: Fotos
COPY public.veiculos_fotos (id, veiculo_id, url_foto, destaque) FROM stdin;
8	4	uploads/696ab4cb3fb30-0.png	f
9	4	uploads/696ab4cb3fb92-1.png	f
10	4	uploads/696ab4cb3fbb6-2.png	f
11	4	uploads/696ab4cb3fbd4-3.png	f
12	4	uploads/696ab4cb3fbf1-4.png	f
13	4	uploads/696ab4cb3fc23-5.png	f
14	4	uploads/696ab4ff19c18.png	t
15	5	uploads/696ab61031284-0.png	t
16	5	uploads/696ab610312bc-1.png	f
17	5	uploads/696ab610312ec-2.png	f
18	5	uploads/696ab61031314-3.png	f
19	5	uploads/696ab61031332-4.png	f
20	5	uploads/696ab6103134c-5.png	f
21	5	uploads/696ab61031366-6.png	f
22	5	uploads/696ab61031380-7.png	f
23	5	uploads/696ab6103139b-8.png	f
24	5	uploads/696ab610313b5-9.png	f
25	5	uploads/696ab610313ce-10.png	f
26	6	uploads/696ab6adae668-0.png	t
27	6	uploads/696ab6adae6ab-1.png	f
28	6	uploads/696ab6adae6d0-2.png	f
29	6	uploads/696ab6adae6f1-3.png	f
30	6	uploads/696ab6adae715-4.png	f
31	6	uploads/696ab6adae736-5.png	f
32	6	uploads/696ab6adae756-6.png	f
33	6	uploads/696ab6adae777-7.png	f
34	6	uploads/696ab6adae797-8.png	f
35	6	uploads/696ab6adae7b8-9.png	f
\.

-- Dados: Vendas
COPY public.vendas (id, cliente_id, veiculo_id, vendedor_id, valor_final, data_venda, observacoes) FROM stdin;
\.

-- 4. Ajuste das Sequências (Auto Incremento)
SELECT pg_catalog.setval('public.clientes_id_seq', 1, false);
SELECT pg_catalog.setval('public.usuarios_id_seq', 4, true);
SELECT pg_catalog.setval('public.veiculos_fotos_id_seq', 35, true);
SELECT pg_catalog.setval('public.veiculos_id_seq', 6, true);
SELECT pg_catalog.setval('public.vendas_id_seq', 1, false);

-- 5. Chaves Estrangeiras (Foreign Keys)

ALTER TABLE ONLY public.veiculos_fotos
    ADD CONSTRAINT veiculos_fotos_veiculo_id_fkey FOREIGN KEY (veiculo_id) REFERENCES public.veiculos(id) ON DELETE CASCADE;

ALTER TABLE ONLY public.vendas
    ADD CONSTRAINT vendas_cliente_id_fkey FOREIGN KEY (cliente_id) REFERENCES public.clientes(id);

ALTER TABLE ONLY public.vendas
    ADD CONSTRAINT vendas_veiculo_id_fkey FOREIGN KEY (veiculo_id) REFERENCES public.veiculos(id);

ALTER TABLE ONLY public.vendas
    ADD CONSTRAINT vendas_vendedor_id_fkey FOREIGN KEY (vendedor_id) REFERENCES public.usuarios(id);

-- Fim do Dump