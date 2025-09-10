
# Sistema de Gerenciamento de Restaurante - MVC

## 📋 Visão Geral

Sistema web desenvolvido em PHP seguindo o padrão arquitetural MVC (Model-View-Controller) para gerenciamento completo de um restaurante, incluindo administração de mesas, cardápio, usuários, avaliações e sistema de reservas.

## 🏗️ Arquitetura

### Padrão MVC
- **Model**: Camada de dados e lógica de negócio
- **View**: Interface do usuário e apresentação
- **Controller**: Lógica de controle e coordenação

### Estrutura de Diretórios
```
restaurante-mvc/
├── controllers/          # Controladores da aplicação
├── models/              # Modelos de dados
├── views/               # Views e templates
│   └── templates/       # Templates HTML reutilizáveis
│       ├── assets/      # Imagens e ícones
│       ├── css/         # Estilos CSS
│       ├── html/        # Templates HTML
│       └── js/          # Scripts JavaScript
├── index.php            # Ponto de entrada da aplicação
└── documentacao.txt     # Documentação básica
```

## 🗄️ Banco de Dados

### Configuração
- **SGBD**: MySQL
- **Host**: localhost
- **Database**: restaurante-mvc
- **Usuário**: root
- **Senha**: (vazia)

### Tabelas Principais

#### 1. `usuarios`
- `idUsuario` (PK)
- `nome`
- `usuario`
- `senha` (hash bcrypt)
- `nivelAcesso`

#### 2. `mesas`
- `id` (PK)
- `lugares`
- `tipo` (Quadrada, Retangular, Meia lua, Redonda)
- `caracteristicas`

#### 3. `disponibilidade`
- `numero_mesa` (FK)
- `periodo`

#### 4. `cardapio`
- `idCardapio` (PK)
- `nome`
- `preco`
- `tipo` (Prato quente, Prato frio, Sobremesa, Bebida, Outros)
- `descricao`
- `foto`
- `status` (boolean)

#### 5. `avaliacao`
- `idAvaliacao` (PK)
- `nota`
- `comentario`
- `idCardapio` (FK)
- `data`
- `nome`
- `email`
- `situacao` (novo, aprovado)

## 🎯 Funcionalidades

### Área Administrativa (Requer Autenticação)

#### 1. Gerenciamento de Mesas (`/mesa-adm`)
- **Listar mesas**: Visualizar todas as mesas cadastradas
- **Criar mesa**: Adicionar nova mesa com características
- **Editar mesa**: Modificar dados de mesa existente
- **Excluir mesa**: Remover mesa do sistema
- **Características**: Configurar tipo, lugares e disponibilidade

#### 2. Gerenciamento de Cardápio (`/cardapio-adm`)
- **Listar itens**: Visualizar todos os itens do cardápio
- **Criar item**: Adicionar novo item ao cardápio
- **Editar item**: Modificar dados do item
- **Excluir item**: Remover item do cardápio
- **Status**: Ativar/desativar itens
- **Categorias**: Prato quente, frio, sobremesa, bebida, outros

#### 3. Gerenciamento de Avaliações (`/avaliacoes-adm`)
- **Listar avaliações**: Visualizar todas as avaliações
- **Aprovar avaliação**: Liberar avaliação para exibição pública
- **Excluir avaliação**: Remover avaliação do sistema

#### 4. Gerenciamento de Usuários (`/usuario-adm`)
- **Listar usuários**: Visualizar todos os usuários
- **Criar usuário**: Adicionar novo usuário
- **Editar usuário**: Modificar dados do usuário
- **Excluir usuário**: Remover usuário do sistema
- **Alterar senha**: Modificar senha do usuário
- **Níveis de acesso**: Controle de permissões

### Área Pública

#### 1. Cardápio (`/cardapio`)
- Visualizar cardápio completo
- Filtrar por categoria
- Ver detalhes dos itens

#### 2. Pizzas (`/pizzas`)
- Seção específica para pizzas

#### 3. Reservas (`/reserva`)
- Sistema de reservas de mesas

#### 4. Contato (`/contato`)
- Informações de contato do restaurante

#### 5. Avaliações (`/avaliacoes`)
- Visualizar avaliações aprovadas
- Sistema de avaliação de itens do cardápio

## 🔐 Sistema de Autenticação

### Login (`/login`)
- Autenticação por usuário e senha
- Opção "Manter logado" (cookies)
- Redirecionamento automático após login
- Validação de sessão em rotas protegidas

### Logout (`/sair`)
- Destruição completa da sessão
- Limpeza de cookies
- Redirecionamento para login

### Validação de Sessão
- Verificação automática em rotas administrativas
- Redirecionamento para login se não autenticado
- Suporte a cookies para "manter logado"

## 🛠️ Tecnologias Utilizadas

### Backend
- **PHP 8.1+**: Linguagem principal
- **PDO**: Acesso ao banco de dados
- **MySQL 8.0**: Sistema de gerenciamento de banco
- **Sessions**: Gerenciamento de sessões
- **Cookies**: Funcionalidade "manter logado"

### Frontend
- **Bootstrap 5.3.3**: Framework CSS
- **Bootstrap Icons**: Ícones
- **Boxicons**: Ícones adicionais
- **JavaScript**: Interatividade
- **HTML5**: Estrutura

### Containerização
- **Docker**: Containerização da aplicação
- **Docker Compose**: Orquestração de containers
- **Apache**: Servidor web
- **phpMyAdmin**: Interface web para MySQL

### Padrões e Boas Práticas
- **MVC**: Arquitetura Model-View-Controller
- **Singleton**: Conexão com banco de dados
- **Prepared Statements**: Segurança contra SQL Injection
- **Password Hashing**: Criptografia de senhas (bcrypt)
- **URL Rewriting**: URLs amigáveis
- **Environment Variables**: Configuração flexível

## 🚀 Instalação e Configuração

### Opção 1: Docker (Recomendado)

#### Pré-requisitos
- Docker e Docker Compose instalados
- Git (opcional)

#### Instalação com Docker

1. **Clone/Download do projeto**
   ```bash
   # Clone o repositório ou baixe o projeto
   git clone <url-do-repositorio>
   cd restaurante-mvc
   ```

2. **Iniciar ambiente Docker**
   ```bash
   # Tornar scripts executáveis (Linux/Mac)
   chmod +x docker-*.sh
   
   # Iniciar ambiente completo
   ./docker-start.sh
   ```

3. **Acesso à Aplicação**
   - **Aplicação**: http://localhost:8080
   - **phpMyAdmin**: http://localhost:8081
   - **Login padrão**: admin / password

#### Comandos Docker Úteis
```bash
# Iniciar ambiente
./docker-start.sh

# Parar ambiente
./docker-stop.sh

# Ver logs
./docker-logs.sh

# Acessar container da aplicação
docker exec -it restaurante-web bash

# Acessar container do MySQL
docker exec -it restaurante-mysql mysql -u root -p
```

### Opção 2: Instalação Local (XAMPP/LAMPP)

#### Pré-requisitos
- XAMPP/LAMPP ou servidor web com PHP e MySQL
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

#### Passos de Instalação

1. **Clone/Download do projeto**
   ```bash
   # Coloque o projeto na pasta htdocs do XAMPP
   # Caminho: /opt/lampp/htdocs/restaurante-mvc/
   ```

2. **Configuração do Banco de Dados**
   - Acesse phpMyAdmin (http://localhost/phpmyadmin)
   - Crie o banco de dados `restaurante-mvc`
   - Execute os scripts SQL em `docker/mysql/init/`

3. **Configuração da Aplicação**
   - Verifique as configurações de conexão em `models/DataBase.php`
   - Ajuste a `$baseUrl` nos controllers se necessário

4. **Acesso à Aplicação**
   - URL: http://localhost/restaurante-mvc/
   - Login padrão: admin / password

## 📝 Estrutura de Rotas

### Rotas Administrativas (Requer Autenticação)
- `/mesa-adm` - Gerenciamento de mesas
- `/cardapio-adm` - Gerenciamento de cardápio
- `/avaliacoes-adm` - Gerenciamento de avaliações
- `/usuario-adm` - Gerenciamento de usuários

### Rotas Públicas
- `/login` - Página de login
- `/cardapio` - Cardápio público
- `/pizzas` - Seção de pizzas
- `/reserva` - Sistema de reservas
- `/contato` - Página de contato
- `/avaliacoes` - Avaliações públicas

### Rotas de Ação
- `/sair` - Logout
- `/{controller}/{action}/{id}` - Ações específicas

## 🔧 Desenvolvimento

### Adicionando Novos Controllers
1. Crie o arquivo em `controllers/NomeController.php`
2. Implemente a classe seguindo o padrão existente
3. Adicione a rota em `index.php`
4. Crie os models e views correspondentes

### Adicionando Novos Models
1. Crie o arquivo em `models/NomeModel.php`
2. Estenda a funcionalidade de `DataBase`
3. Implemente métodos CRUD
4. Use prepared statements para segurança

### Customizando Views
1. Modifique templates em `views/templates/html/`
2. Ajuste estilos em `views/templates/css/style.css`
3. Adicione JavaScript em `views/templates/js/`

## 🐳 Configuração Docker

### Estrutura Docker
```
restaurante-mvc/
├── docker-compose.yml          # Orquestração dos containers
├── Dockerfile                  # Imagem da aplicação PHP
├── docker.env                  # Variáveis de ambiente
├── .htaccess                   # Configuração Apache
├── docker/                     # Configurações Docker
│   ├── apache/
│   │   └── 000-default.conf    # Configuração Apache
│   └── mysql/
│       ├── init/               # Scripts de inicialização
│       │   ├── 01-create-database.sql
│       │   └── 02-insert-sample-data.sql
│       └── conf/
│           └── mysql.cnf       # Configuração MySQL
└── docker-*.sh                 # Scripts de gerenciamento
```

### Serviços Docker

#### 1. MySQL (restaurante-mysql)
- **Imagem**: mysql:8.0
- **Porta**: 3306
- **Volume**: Dados persistentes
- **Inicialização**: Scripts SQL automáticos

#### 2. Aplicação Web (restaurante-web)
- **Imagem**: PHP 8.1 + Apache
- **Porta**: 8080
- **Volume**: Código fonte montado
- **Dependências**: MySQL

#### 3. phpMyAdmin (restaurante-phpmyadmin)
- **Imagem**: phpmyadmin/phpmyadmin
- **Porta**: 8081
- **Acesso**: Interface web para MySQL

### Variáveis de Ambiente
```bash
# Banco de dados
DB_HOST=mysql
DB_NAME=restaurante-mvc
DB_USER=restaurante
DB_PASSWORD=restaurante123

# Aplicação
APP_URL=http://localhost:8080
```

## 🐛 Solução de Problemas

### Problemas Docker

1. **Container não inicia**
   ```bash
   # Verificar logs
   ./docker-logs.sh
   
   # Verificar status
   docker-compose ps
   ```

2. **Erro de Conexão com Banco**
   - Verifique se o MySQL está rodando: `docker-compose ps`
   - Aguarde a inicialização completa (pode levar alguns minutos)
   - Verifique logs: `docker-compose logs mysql`

3. **Porta já em uso**
   ```bash
   # Parar containers
   ./docker-stop.sh
   
   # Verificar processos usando a porta
   lsof -i :8080
   lsof -i :3306
   ```

4. **Problemas de Permissão**
   ```bash
   # Tornar scripts executáveis
   chmod +x docker-*.sh
   
   # Verificar permissões do diretório
   ls -la
   ```

### Problemas Gerais

1. **Erro de Conexão com Banco**
   - Verifique se o MySQL está rodando
   - Confirme as credenciais em `DataBase.php`

2. **Página em Branco**
   - Verifique logs de erro do PHP
   - Confirme se todas as dependências estão instaladas

3. **Problemas de Sessão**
   - Verifique se `session_start()` está sendo chamado
   - Confirme configurações de sessão no PHP

4. **URLs Não Funcionando**
   - Verifique se o mod_rewrite está habilitado
   - Confirme se o arquivo `.htaccess` existe

## 📚 Documentação Adicional

- **Padrão MVC**: Separação clara entre lógica, dados e apresentação
- **Segurança**: Uso de prepared statements e hash de senhas
- **Responsividade**: Interface adaptável usando Bootstrap
- **Manutenibilidade**: Código organizado e documentado

## 👥 Contribuição

Para contribuir com o projeto:
1. Faça um fork do repositório
2. Crie uma branch para sua feature
3. Implemente as mudanças seguindo os padrões existentes
4. Teste thoroughly
5. Submeta um pull request

## 📄 Licença

Este projeto é de uso educacional e demonstrativo do padrão MVC em PHP.

---

**Desenvolvido com ❤️ usando PHP e padrão MVC**
