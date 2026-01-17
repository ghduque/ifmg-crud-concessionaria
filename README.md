# AutoNível Multimarcas 

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![IFMG](https://img.shields.io/badge/Instituição-IFMG-green?style=for-the-badge)

Projeto final desenvolvido para a disciplina de **Programação Web** do Instituto Federal de Minas Gerais (IFMG).

O **AutoNível** é um sistema web completo para gerenciamento de estoque de veículos (Concessionária), desenvolvido utilizando a arquitetura **MVC (Model-View-Controller)** sem o uso de frameworks pesados, focando no aprendizado da linguagem PHP nativa e boas práticas de desenvolvimento.

---

##  Funcionalidades do Projeto

###  Autenticação e Usuários
- **Login Seguro:** Sistema de login com hash de senhas (`password_hash`) e proteção contra SQL Injection.
- **Cadastro de Usuários:** Validação de CPF e e-mail único.
- **Controle de Acesso (ACL):** Diferenciação entre **Administrador** (pode editar/excluir tudo) e **Usuário Comum** (apenas visualiza e gerencia perfil).
- **Gestão de Perfil:** Edição de dados pessoais e alteração de senha.

###  Gestão de Veículos (CRUD)
- **Listagem Dinâmica:** Exibição de veículos com paginação e ordenação (Preço, Ano, Recentes).
- **Filtros Avançados:** Busca por nome, faixa de preço, ano e quilometragem.
- **Cadastro Completo:** Upload de imagens, descrição de opcionais e especificações técnicas.
- **Página de Detalhes:** Visualização aprofundada com carrossel de fotos e link direto para WhatsApp dos vendedores.

###  Frontend e UI/UX
- **Design Responsivo:** Layout adaptável para Mobile e Desktop (Bootstrap 5).
- **Clean Code:** Separação total de responsabilidades (CSS em `style.css` e JS em `main.js`).
- **Interatividade:** Máscaras automáticas (CPF, Telefone) e limpeza de inputs (Trim) via JavaScript.

---

##  Tecnologias Utilizadas

* **[PHP 8+](https://www.php.net/)**: Backend robusto com PDO para conexão segura ao banco de dados.
* **[PostgreSQL](https://www.postgresql.org/)**: Banco de dados relacional robusto e escalável.
* **[Bootstrap 5](https://getbootstrap.com/)**: Framework CSS para agilidade e responsividade.
* **[JavaScript (Vanilla)](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)**: Manipulação do DOM, máscaras de input e lógica frontend.
* **[HTML5 & CSS3](https://developer.mozilla.org/pt-BR/docs/Web/CSS)**: Estrutura semântica e estilização personalizada (Tema Dark/Yellow).

---

## 📂 Estrutura do Projeto (MVC)

O projeto foi organizado para facilitar a manutenção e escalabilidade:

```text
/src
 ├── Controllers/   # Lógica de negócio (Usuario, Veiculo, Auth)
 ├── Models/        # Acesso ao Banco de Dados e Regras
 ├── Views/         # Interfaces (HTML/PHP)
 │    ├── auth/     # Login, Registro, Perfil
 │    ├── layouts/  # Cabeçalho e Rodapé reutilizáveis
 │    └── veiculos/ # Listagem, Detalhes e CRUD
/public
 ├── css/           # Estilos globais (style.css)
 ├── js/            # Scripts globais (main.js)
 ├── img/           # Imagens do sistema
 └── uploads/       # Fotos dos veículos

```

---

##  Como Executar

1. **Clone o repositório:**
```bash
git clone [https://github.com/SEU-USUARIO/autonivel.git](https://github.com/SEU-USUARIO/autonivel.git)

```


2. **Configure o Banco de Dados:**
* Crie um banco de dados PostgreSQL chamado `db_autonivel`.
* Importe o arquivo `database.sql` (disponível na raiz do projeto).
* Ajuste as credenciais em `src/config/database.php`.


3. **Inicie o Servidor:**
Você pode usar o XAMPP, Laragon ou o servidor embutido do PHP:
```bash
php -S localhost:8000 -t public

```


4. **Acesse:**
Abra `http://localhost:8000` no seu navegador.

---

##  Usuários para Teste

Para facilitar a verificação das funcionalidades e níveis de acesso (ACL), o banco de dados já vem populado com os seguintes usuários:

| Nível de Acesso | E-mail | Senha |
| --- | --- | --- |
| **Usuário Comum** | `teste@teste.com` | `123` |
| **Administrador** | `admin@autonivel.com` | `123456` |

---

##  Autores

Estudantes de Engenharia de Computação - IFMG

**Gabriel Henrique Silva Duque**


**Rafael Gonçalves Oliveira**


