# ControleAdvocacia

<h4 align="center"> 
	🚧  Programa  🚀 Em construção...  🚧
</h4>

### Sobre
<p> ControleAdvocacia é um sistema feito para advogados para o controle de seus clientes e serviços prestados. A aplicação mostra os pagamentos pendentes de cada serviço, permitindo gerar boletos</p>

### Funções

- [x] Gerenciamento de usuários
- [x] Cadastro de serviços.
- [ ] Visualização de pagamentos pendentes (Com filtros).
- [ ] Emissão de boleto.
- [ ] Gerar peça em .doc após cadastrar um novo serviço. (Em estudo)

### Screenshots

# Tela Principal
![Tela Principal](https://github.com/PauloHenrique7010/ControleAdvocaciaV2/blob/main/anexos/screenshots/telaPrincipal.png)


### 🎲 Instalar o projeto

## Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:

-> [Git for windows](https://git-scm.com)

-> [Node.js](https://nodejs.org/en/)

-> [Xampp](https://www.apachefriends.org/) <b>(Instalação Mínima: Apache, PHP e Mysql)</b>.

- Após a instalação do xampp, verifique se o rewrite_mod está ativo.
- Execute o painel de controle do xampp e inicie o Mysql e o Apache.
- <b>Caso seja pedido permissão do firewall, permita o acesso!</b>


### 🎲 Instalando o projeto
```bash

# Com o Apache e o MySQL rodando pelo xampp, crie um banco de dados chamado "controle_advocacia". 

# Através do terminal, navegue até a pasta C:\xampp\htdocs\ (Local de instalação do xampp no Windows)

# Baixe o projeto na pasta htdocs
$ git clone <https://github.com/PauloHenrique7010/ControleAdvocaciaV2/>

# Acesse a pasta ControleAdvocaciaV2/

# Navegue até a pasta ./server/ e digite:
$ npm install

# Volte para a pasta raiz do projeto e navegue até a pasta ./application/outros/

# Suba o arquivo controle_advocacia.sql para o banco de dados utilizando o comando
$ mysql -u root controle_advocacia < controle_advocacia.sql

# Espere até o fim da operação.
```


### 🎲 Rodando o Back End (servidor)

```bash

# Através do terminal, vá até a pasta ./server/ (localizada na raiz do projeto).

# Inicie o servidor

$ node index
# ou
$ nodemon index

# O servidor inciará na porta 8020 - acesse <http://localhost:8020>
```
### 🎲 Rodando a aplicação 
```bash
# No seu navegador abra a página "http:/localhost/ControleAdvocaciaV2/
```


### Referências
<p>[Como fazer um bom README](https://blog.rocketseat.com.br/como-fazer-um-bom-readme/)</p>
<p>[Exemplo ReadMe](https://github.com/tgmarinho/meetapp)</p>

