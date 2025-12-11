# Separação Cliente e Administração - TechFit

O sistema foi separado em duas áreas distintas: **Cliente** e **Administração**.

## 🎯 Estrutura de Acesso

### Página Inicial
**Arquivo:** `index.php`
**URL:** `http://localhost/index.php`

Página de boas-vindas que permite escolher entre:
- Área do Cliente
- Área Administrativa

### Área do Cliente
**Arquivo:** `cliente.php`
**URL:** `http://localhost/cliente.php`

#### Funcionalidades:
- ✅ Login com email e senha (tabela ALUNOS)
- ✅ Dashboard pessoal
- ✅ Visualização do perfil
- ✅ Edição do próprio perfil
- ✅ Visualização de avaliações físicas
- ✅ Visualização do plano ativo
- ✅ Gráficos de evolução (IMC)

#### Rotas:
```
cliente.php?action=login          # Página de login
cliente.php?action=doLogin        # Processar login
cliente.php?action=dashboard      # Dashboard do cliente
cliente.php?action=perfil         # Meu perfil
cliente.php?action=avaliacoes     # Minhas avaliações
cliente.php?action=plano          # Meu plano
cliente.php?action=logout          # Sair
```

### Área Administrativa
**Arquivo:** `admin.php`
**URL:** `http://localhost/admin.php`

#### Funcionalidades:
- ✅ Login com usuário e senha (tabela ADMINISTRACAO)
- ✅ Dashboard administrativo
- ✅ CRUD completo de todas as entidades
- ✅ Exportação CSV
- ✅ Gráficos e relatórios

#### Rotas:
```
admin.php?action=login                              # Página de login
admin.php?action=doLogin                            # Processar login
admin.php?controller=dashboard&action=index         # Dashboard admin
admin.php?controller=aluno&action=index             # Listar alunos
admin.php?controller=aluno&action=create            # Criar aluno
admin.php?controller=aluno&action=update&id=X       # Editar aluno
admin.php?controller=aluno&action=delete&id=X      # Excluir aluno
admin.php?controller=aluno&action=exportCSV        # Exportar CSV
admin.php?action=logout                             # Sair
```

## 🔐 Sistema de Autenticação

### Cliente
- **Tabela:** `ALUNOS`
- **Campos:** `EMAIL` e `SENHA`
- **Senha:** Hash com `password_hash()` e verificação com `password_verify()`

### Administrador
- **Tabela:** `ADMINISTRACAO`
- **Campos:** `AUSER` e `SENHA`
- **Senha:** Texto simples (conforme estrutura do banco)

## 📁 Estrutura de Arquivos

```
TechFit/
├── index.php                      # Página inicial (escolha de acesso)
├── cliente.php                    # Roteamento área do cliente
├── admin.php                      # Roteamento área administrativa
├── config/
│   ├── database.php              # Configuração do banco
│   └── auth.php                   # Sistema de autenticação
├── controllers/
│   ├── ClienteController.php      # Controller do cliente
│   └── [outros controllers admin]
├── views/
│   ├── cliente/
│   │   ├── login.php              # Login do cliente
│   │   ├── dashboard.php          # Dashboard do cliente
│   │   ├── perfil.php             # Perfil do cliente
│   │   ├── avaliacoes.php         # Avaliações do cliente
│   │   ├── plano.php              # Plano do cliente
│   │   └── layout/
│   │       ├── header.php         # Header do cliente
│   │       └── footer.php         # Footer do cliente
│   ├── admin/
│   │   └── login.php              # Login do admin
│   └── [outras views admin]
└── [outros arquivos]
```

## 🎨 Diferenças Visuais

### Área do Cliente
- Cores: Gradiente roxo/azul (#667eea, #764ba2)
- Layout: Sidebar lateral com menu
- Foco: Informações pessoais e progresso

### Área Administrativa
- Cores: Gradiente azul escuro (#1e3c72, #2a5298)
- Layout: Navbar superior com dropdowns
- Foco: Gerenciamento completo do sistema

## 🔒 Segurança

### Proteções Implementadas:
1. **Sessões separadas** para cliente e admin
2. **Verificação de autenticação** em cada rota
3. **Redirecionamento automático** se não autenticado
4. **Hash de senhas** para clientes
5. **Prepared statements** em todas as queries

### Como Funciona:
- Cliente acessa `cliente.php` → Verifica se está logado → Se não, redireciona para login
- Admin acessa `admin.php` → Verifica se está logado → Se não, redireciona para login
- Cada área só acessa seus próprios dados

## 📝 Exemplo de Uso

### Para Cliente:
1. Acesse `index.php`
2. Clique em "Entrar como Cliente"
3. Faça login com email e senha cadastrados
4. Navegue pelo dashboard, perfil, avaliações e plano

### Para Administrador:
1. Acesse `index.php`
2. Clique em "Entrar como Admin"
3. Faça login com usuário e senha do admin
4. Gerencie todas as entidades do sistema

## 🚀 Próximos Passos

Para usar o sistema:

1. **Configure o banco de dados** em `config/database.php`
2. **Execute o script SQL** `TECHFIT_SCRIPT.sql`
3. **Crie um administrador** na tabela `ADMINISTRACAO`:
   ```sql
   INSERT INTO ADMINISTRACAO (AUSER, SENHA) VALUES ('admin', 'senha123');
   ```
4. **Crie um cliente** (ou use um existente) na tabela `ALUNOS`
5. **Acesse** `index.php` e escolha sua área

## 📌 Notas Importantes

- As senhas dos clientes devem ser criadas com `password_hash()` ao cadastrar
- As senhas dos administradores são texto simples (conforme banco)
- Cada área tem seu próprio sistema de logout
- Os dados são compartilhados entre as áreas (mesmo banco)

