# TechFit - Sistema de Gestão de Academia

Sistema completo de gestão para academia, desenvolvido em PHP com arquitetura MVC, separado em duas áreas: **Cliente** e **Administração**.

> **Repositório Original:** [https://github.com/Kayque48/TechFit.git](https://github.com/Kayque48/TechFit.git)

## 🎯 Sistema Separado em Duas Áreas

### Área do Cliente
- Login com email e senha
- Dashboard pessoal
- Visualização e edição do perfil
- Acompanhamento de avaliações físicas
- Visualização do plano ativo
- Gráficos de evolução

### Área Administrativa
- Login com usuário e senha
- Dashboard administrativo completo
- CRUD de todas as entidades
- Exportação de relatórios CSV
- Gráficos e estatísticas

## Características

- ✅ Arquitetura MVC (Model-View-Controller)
- ✅ Separação entre área do cliente e administração
- ✅ Sistema de autenticação para cliente e admin
- ✅ CRUD completo para todas as entidades
- ✅ Exportação de relatórios em CSV
- ✅ Gráficos interativos com Chart.js
- ✅ Interface moderna e responsiva com Bootstrap 5
- ✅ Sistema de roteamento simples e eficiente

## Estrutura do Projeto

```
TechFit/
├── config/
│   └── database.php          # Configuração do banco de dados
├── models/                    # Models (camada de dados)
│   ├── Model.php             # Classe base para models
│   ├── AlunoModel.php
│   ├── ProfessorModel.php
│   ├── AulaModel.php
│   ├── PlanoModel.php
│   ├── FilialModel.php
│   ├── ProdutoModel.php
│   └── AvaliacaoModel.php
├── controllers/               # Controllers (lógica de negócio)
│   ├── Controller.php        # Classe base para controllers
│   ├── DashboardController.php
│   ├── AlunoController.php
│   ├── ProfessorController.php
│   ├── AulaController.php
│   ├── PlanoController.php
│   ├── FilialController.php
│   ├── ProdutoController.php
│   └── AvaliacaoController.php
├── views/                     # Views (interface)
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   ├── dashboard/
│   ├── alunos/
│   ├── professores/
│   ├── aulas/
│   ├── planos/
│   ├── filiais/
│   ├── produtos/
│   └── avaliacoes/
├── assets/
│   ├── css/
│   │   └── admin.css
│   └── js/
│       └── admin.js
├── index.php                  # Página inicial (escolha de acesso)
├── cliente.php                # Roteamento área do cliente
├── admin.php                  # Roteamento área administrativa
├── config/
│   ├── database.php          # Configuração do banco
│   └── auth.php              # Sistema de autenticação
└── TECHFIT_SCRIPT.sql         # Script do banco de dados
```

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx) ou PHP built-in server
- Extensão PDO do PHP habilitada

## Instalação

1. **Configure o banco de dados:**
   - Execute o script `TECHFIT_SCRIPT.sql` no MySQL para criar o banco de dados e as tabelas

2. **Configure a conexão:**
   - Edite o arquivo `config/database.php` e ajuste as credenciais do banco de dados:
     ```php
     private $host = 'localhost';
     private $dbname = 'TECHFIT_DB';
     private $username = 'root';
     private $password = '';
     ```

3. **Inicie o servidor:**
   ```bash
   php -S localhost:8000
   ```

4. **Acesse o sistema:**
   - Abra o navegador em: `http://localhost:8000`
   - Escolha entre "Área do Cliente" ou "Área Administrativa"

5. **Criar usuário administrador:**
   ```sql
   INSERT INTO ADMINISTRACAO (AUSER, SENHA) VALUES ('admin', 'senha123');
   ```

## Funcionalidades

### Dashboard
- Visão geral com estatísticas
- Gráficos de distribuição de planos
- Gráficos de classificação IMC
- Gráficos de status de alunos e produtos

### Gerenciamento de Entidades

Todas as entidades possuem:
- **Listagem** com tabela responsiva
- **Criação** de novos registros
- **Edição** de registros existentes
- **Exclusão** com confirmação
- **Exportação CSV** dos dados

### Entidades Gerenciadas

1. **Alunos** - Cadastro completo com planos associados
2. **Professores** - Gerenciamento de instrutores
3. **Aulas** - Tipos de aulas oferecidas
4. **Planos** - Planos de assinatura disponíveis
5. **Filiais** - Unidades da academia
6. **Produtos** - Produtos da loja
7. **Avaliações Físicas** - Avaliações dos alunos com cálculo automático de IMC

## Uso

### Acesso ao Sistema

1. **Página Inicial** (`index.php`)
   - Escolha entre área do cliente ou administrativa

2. **Área do Cliente** (`cliente.php`)
   - Login com email e senha de um aluno cadastrado
   - Acesse dashboard, perfil, avaliações e plano

3. **Área Administrativa** (`admin.php`)
   - Login com usuário e senha do administrador
   - Gerencie todas as entidades do sistema

### Navegação
- **Cliente:** Use o menu lateral para navegar
- **Admin:** Use o menu superior com dropdowns

### Criar Registro
1. Clique em "Novo" na página de listagem
2. Preencha o formulário
3. Clique em "Salvar"

### Editar Registro
1. Na listagem, clique no ícone de lápis (✏️)
2. Modifique os dados
3. Clique em "Atualizar"

### Excluir Registro
1. Na listagem, clique no ícone de lixeira (🗑️)
2. Confirme a exclusão

### Exportar CSV
1. Na página de listagem, clique em "Exportar CSV"
2. O arquivo será baixado automaticamente

## Tecnologias Utilizadas

- **Backend:** PHP 7.4+
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework CSS:** Bootstrap 5.3
- **Gráficos:** Chart.js 4.4
- **Ícones:** Bootstrap Icons

## Estrutura MVC

### Model (Modelo)
Responsável pela interação com o banco de dados. Cada entidade possui seu próprio model que estende a classe base `Model`.

### View (Visão)
Responsável pela apresentação dos dados. Utiliza templates PHP com Bootstrap para interface moderna.

### Controller (Controlador)
Responsável pela lógica de negócio e coordenação entre Model e View. Processa requisições e retorna respostas.

## Segurança

- Uso de prepared statements (PDO) para prevenir SQL Injection
- Validação de dados nos formulários
- Escape de saída (htmlspecialchars) para prevenir XSS
- Hash de senhas com password_hash()

## Notas

- O sistema não altera a estrutura do banco de dados
- Todos os dados são lidos e escritos nas tabelas existentes
- O cálculo de IMC é feito automaticamente nas avaliações físicas

## Suporte

Para problemas ou dúvidas, verifique:
1. Configuração do banco de dados
2. Permissões de arquivo
3. Logs de erro do PHP

