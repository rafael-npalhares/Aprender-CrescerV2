# 📚 Aprender & Crescer

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Em%20Desenvolvimento-yellow)
![Version](https://img.shields.io/badge/Version-0.1.0-blue)

Sistema web de gestão escolar desenvolvido com Laravel, focado na organização de processos acadêmicos e administrativos de instituições de ensino.

---

## 📖 Sobre o Projeto

O **Aprender & Crescer** é uma aplicação web que centraliza funcionalidades essenciais de uma instituição de ensino em uma única plataforma.

O sistema foi projetado para fornecer diferentes experiências de uso para administradores, professores e alunos, permitindo o gerenciamento de usuários, turmas, biblioteca, cantina, reservas e comunicação interna.

Atualmente o projeto encontra-se em desenvolvimento contínuo, com novos módulos e funcionalidades sendo adicionados gradualmente.

---

## ✨ Principais Funcionalidades

### 👥 Gestão de Usuários

- Cadastro de usuários
- Controle de perfis (Roles)
- Autenticação segura
- Controle de acesso por permissões

### 🎓 Gestão Acadêmica

- Gerenciamento de turmas
- Grade de horários
- Avisos institucionais

### 📚 Biblioteca

- Consulta de livros
- Empréstimos
- Renovações
- Controle de devoluções

### 🍔 Cantina

- Consulta de produtos
- Realização de pedidos
- Controle de estoque

### 📅 Reservas

- Solicitação de reservas
- Aprovação ou rejeição por administradores
- Controle de status

---

## 🧩 Módulos do Sistema

| Módulo | Descrição |
|---------|-----------|
| Usuários | Gerenciamento de usuários e perfis |
| Turmas | Organização das turmas escolares |
| Avisos | Comunicação interna da instituição |
| Biblioteca | Controle de livros e empréstimos |
| Cantina | Controle de produtos e pedidos |
| Reservas | Gestão de reservas de equipamentos e recursos |
| Horários | Organização da grade escolar |

---

## 👤 Perfis do Sistema

### Administrador

Possui acesso completo ao sistema.

Responsável por:

- Gerenciar usuários
- Gerenciar turmas
- Publicar avisos
- Gerenciar biblioteca
- Gerenciar cantina
- Aprovar reservas
- Configurar horários

### Professor

Possui acesso às funcionalidades acadêmicas e de consulta.

Pode:

- Consultar avisos
- Visualizar horários
- Utilizar biblioteca
- Solicitar reservas
- Realizar pedidos na cantina

### Aluno

Possui acesso às funcionalidades acadêmicas disponíveis para estudantes.

Pode:

- Consultar avisos
- Visualizar horários
- Utilizar biblioteca
- Realizar pedidos na cantina

---

## 🛠️ Tecnologias Utilizadas

### Backend

- PHP 8.2
- Laravel 12
- Laravel Breeze

### Frontend

- Blade
- Bootstrap 5

### Banco de Dados

- MySQL

### Controle de Versão

- Git
- GitHub

---

## 🏗️ Arquitetura

O projeto segue a arquitetura MVC (Model-View-Controller) disponibilizada pelo Laravel.

```text
Request
    ↓
Route
    ↓
Middleware
    ↓
Controller
    ↓
Model
    ↓
Database
    ↓
View
```

### Recursos Implementados

| Recurso | Status |
|----------|----------|
| Autenticação | ✅ |
| Middleware de Roles | ✅ |
| Seeders | ✅ |
| Laravel Breeze | ✅ |
| CRUD de Usuários | ✅ |
| CRUD de Turmas | 🚧 |
| Biblioteca | 🚧 |
| Cantina | 🚧 |
| Reservas | 🚧 |
| Dashboard Administrativo | ✅ |
| Testes Automatizados | ❌ |
| API REST | ❌ |

---

## 🗄️ Modelo de Dados

Principais entidades atualmente presentes no sistema:

- User
- Aluno
- Professor
- Turma
- Aviso
- Reserva
- Livro
- Emprestimo
- ProdutoCantina
- PedidoCantina
- GradeHorario
- Equipamento

---

## 📂 Estrutura do Projeto

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│
├── Models/
│
database/
├── migrations/
├── seeders/
│
resources/
├── views/
│
routes/
└── web.php
```

---

## 🚀 Instalação

### Clonar o Repositório

```bash
git clone https://github.com/rafael-npalhares/Aprender-CrescerV2.git
```

### Acessar a Pasta

```bash
cd Aprender-CrescerV2
```

### Instalar Dependências

```bash
composer install
```

### Configurar Ambiente

```bash
cp .env.example .env
```

### Gerar Chave da Aplicação

```bash
php artisan key:generate
```

### Configurar Banco de Dados

Editar o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aprender_crescer
DB_USERNAME=root
DB_PASSWORD=
```

### Executar Migrations

```bash
php artisan migrate
```

### Executar Seeders

```bash
php artisan db:seed
```

### Iniciar o Servidor

```bash
php artisan serve
```

A aplicação estará disponível em:

```text
http://127.0.0.1:8000
```

---

## 📸 Screenshots

Em breve serão adicionadas imagens das principais telas do sistema:

- Login
- Dashboard Administrativo
- Biblioteca
- Cantina
- Reservas
- Gerenciamento de Usuários

---

## 🗺️ Roadmap

### Gestão Acadêmica

- [ ] Sistema de notas
- [ ] Controle de frequência
- [ ] Boletim escolar

### Comunicação e Segurança

- [ ] Canal de denúncias anônimas
- [ ] Solicitação de ajuda estudantil
- [ ] Encaminhamento para coordenadores e supervisores

### Novos Perfis

- [ ] Coordenador
- [ ] Supervisor

### Melhorias Técnicas

- [ ] API REST
- [ ] Docker
- [ ] Testes automatizados
- [ ] Policies
- [ ] Factories
- [ ] Integração contínua (CI/CD)

---

## 📊 Status do Projeto

🚧 **Em desenvolvimento**

O sistema encontra-se em constante evolução e novas funcionalidades estão sendo implementadas gradualmente.

---

## 🤝 Contribuição

Contribuições, sugestões e correções são bem-vindas.

Para contribuir:

1. Faça um Fork do projeto.
2. Crie uma nova Branch.

```bash
git checkout -b minha-feature
```

3. Realize suas alterações.
4. Faça o commit.

```bash
git commit -m "feat: adiciona nova funcionalidade"
```

5. Envie para seu repositório.

```bash
git push origin minha-feature
```

6. Abra um Pull Request.

---

## 👨‍💻 Autores

Desenvolvido por:

- Rafael Nunes
- Natan Henrique
- Murilo Camargo
- Tiago Marghotti

---

## 📄 Licença

Este projeto atualmente não possui uma licença definida.

Todos os direitos reservados aos autores até a definição de uma licença oficial.