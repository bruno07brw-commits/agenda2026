# 📒 agendaPHP

Sistema web de **agenda de contatos**, desenvolvido em PHP e MySQL.

O projeto permite que usuários façam login no sistema e gerenciem seus contatos, podendo cadastrar, visualizar, editar e excluir informações.

---

## 🎯 Objetivo do projeto

O objetivo do **agendaPHP** é facilitar o gerenciamento de contatos através de uma aplicação web.

O sistema foi desenvolvido para praticar conceitos de:

* PHP
* MySQL
* PDO
* CRUD
* Sessões
* Login e autenticação
* Upload de imagens
* Geração de relatórios
* Geração de arquivos PDF
* HTML, CSS e JavaScript

---

## 🚀 Funcionalidades

### 👤 Usuários

O sistema possui:

* Cadastro de usuários
* Login
* Controle de sessão
* Logout
* Perfil do usuário
* Foto do usuário

### 📇 Contatos

É possível:

* Cadastrar contatos
* Listar contatos
* Editar contatos
* Excluir contatos
* Adicionar foto ao contato
* Visualizar informações dos contatos

Os contatos ficam relacionados ao usuário que realizou o cadastro.

### 📊 Relatórios

O sistema também possui uma área para gerar relatórios dos contatos cadastrados.

É possível gerar um relatório em **PDF** utilizando a biblioteca Dompdf.

---

# 🛠️ Tecnologias utilizadas

| Tecnologia   | Utilização                   |
| ------------ | ---------------------------- |
| PHP          | Back-end e regras do sistema |
| MySQL        | Banco de dados               |
| PDO          | Conexão com o banco          |
| HTML5        | Estrutura das páginas        |
| CSS3         | Estilização                  |
| JavaScript   | Interações da página         |
| Bootstrap    | Interface                    |
| AdminLTE     | Painel administrativo        |
| Font Awesome | Ícones                       |
| Dompdf       | Geração de PDF               |

---

# 📂 Estrutura do projeto

```text
agendaPHP/
│
├── config/
│   └── conexao.php
│
├── dist/
│   ├── css/
│   ├── js/
│   └── img/
│
├── img/
│   ├── avatar_p/
│   ├── cont/
│   ├── logo/
│   └── user/
│
├── includes/
│   ├── footer.php
│   ├── header.php
│   └── sair.php
│
├── paginas/
│   ├── home.php
│   └── conteudo/
│       ├── cadastro_contato.php
│       ├── update_contato.php
│       ├── del-rel-contato.php
│       ├── perfil.php
│       ├── relatorio.php
│       └── pdf/
│
├── cad_user.php
├── index.php
├── new_agenda.sql
└── README.md
```

---

# 🗄️ Banco de dados

O sistema utiliza o banco:

```text
new_agenda
```

O arquivo:

```text
new_agenda.sql
```

contém a estrutura do banco de dados utilizada pelo projeto.

## Principais tabelas

### `tb_user`

Armazena os usuários cadastrados no sistema.

Exemplos de informações:

```text
ID
Nome
E-mail
Senha
Foto
```

### `tb_contatos`

Armazena os contatos cadastrados pelos usuários.

Exemplos:

```text
ID
Nome
Telefone
E-mail
Foto
ID do usuário
```

Cada contato fica relacionado ao usuário que o cadastrou.

---

# ⚙️ Como instalar

## 1. Clone o projeto

```bash
git clone https://github.com/kauekl2507-stack/agendaPHP.git
```

Entre na pasta:

```bash
cd agendaPHP
```

---

## 2. Coloque o projeto no Apache

No Linux, o projeto pode ficar em:

```text
/var/www/html/
```

Exemplo:

```text
/var/www/html/agendaPHP
```

---

## 3. Crie o banco de dados

Abra o MySQL ou o phpMyAdmin.

Crie o banco:

```sql
CREATE DATABASE new_agenda;
```

Depois importe o arquivo:

```text
new_agenda.sql
```

---

## 4. Configure a conexão

Abra:

```text
config/conexao.php
```

Configure os dados do seu MySQL.

Exemplo:

```php
define('DB_CONFIG', [
    'host'   => 'localhost',
    'dbname' => 'new_agenda',
    'user'   => 'root',
    'pass'   => ''
]);
```

Altere `user` e `pass` de acordo com a configuração do seu computador.

---

# ▶️ Como executar

Com o Apache e o MySQL funcionando, abra o navegador e acesse:

```text
http://localhost/agendaPHP/
```

A página inicial do sistema será carregada.

---

# 🔐 Como o sistema funciona

O funcionamento básico é:

```text
Usuário
   ↓
Cadastro / Login
   ↓
Sessão
   ↓
Página inicial
   ↓
Gerenciamento de contatos
   ↓
Cadastrar / Editar / Excluir
   ↓
Banco de dados MySQL
   ↓
Relatório
   ↓
PDF
```

## 🔑 Login

O usuário informa seus dados de acesso.

O sistema verifica as informações no banco de dados.

Se estiverem corretas, uma **sessão** é criada e o usuário pode acessar as páginas protegidas.

---

## 📇 Cadastro de contato

O usuário preenche as informações do contato.

Por exemplo:

```text
Nome
Telefone
E-mail
Foto
```

Os dados são enviados para o PHP e armazenados no MySQL.

---

## ✏️ Edição

Quando o usuário deseja alterar um contato, o sistema busca o contato pelo ID e permite modificar suas informações.

Depois da alteração, os novos dados são enviados novamente ao banco.

---

## 🗑️ Exclusão

O usuário pode excluir um contato.

O sistema identifica o contato através do seu ID e remove o registro do banco de dados.

---

## 📄 Relatório PDF

O sistema possui uma função para gerar relatório dos contatos.

A biblioteca **Dompdf** transforma o conteúdo HTML em um arquivo PDF.

Fluxo:

```text
Banco de dados
      ↓
Lista de contatos
      ↓
HTML
      ↓
Dompdf
      ↓
PDF
```

---

# 🔒 Segurança

O projeto utiliza alguns recursos para melhorar a segurança:

* PDO para conexão com o banco;
* Prepared Statements;
* `bindParam()`;
* `password_hash()` para armazenamento de senhas;
* Controle de sessões;
* Validação de informações;
* Controle das páginas acessadas;
* Validação de arquivos enviados.

Em um ambiente de produção, ainda podem ser adicionadas outras medidas, como:

* Proteção CSRF;
* Variáveis de ambiente;
* Validação mais rígida de uploads;
* Controle de permissões;
* Logs de segurança.

---

# 🌐 Git e GitHub

O projeto utiliza Git para controle de versões.

Para verificar a branch atual:

```bash
git branch
```

Para criar uma nova branch:

```bash
git switch -c nova-branch
```

Para adicionar alterações:

```bash
git add .
```

Para criar um commit:

```bash
git commit -m "Descrição da alteração"
```

Para enviar para o GitHub:

```bash
git push
```

---

# 📌 Exemplo de atualização do projeto

Depois de modificar algum arquivo:

```bash
git add .
git commit -m "Atualizando sistema"
git push
```

---

# 👨‍💻 Autor

**Kauê**

GitHub:

```text
https://github.com/kauekl2507-stack
```

---

# 📊 Status do projeto

🚧 **Em desenvolvimento**

Novas funcionalidades e melhorias podem ser adicionadas futuramente.

---

## 📄 Licença

Este projeto foi desenvolvido para fins **educacionais e de aprendizado em desenvolvimento web**.
