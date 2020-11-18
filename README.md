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
- [ ] Gerar peça em .doc após criação de serviço. <p sytle="red">(Em estudos)</p>

### Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:
-> [Git for windows](https://git-scm.com)
-> [Node.js](https://nodejs.org/en/)
-> [Xampp](https://www.apachefriends.org/) <b>(Instalação Mínima: Apache, PHP e Mysql)</b>.
- Após a instalação do xampp, verifique se o rewrite_mod está ativo.
- Execute o painel de controle do xampp e inicie o Mysql e o Apache.
- <b> Caso seja pedido permissão do firewall, permita o acesso! </b>.

### 🎲 Instalar o projeto

```bash

# Com o Apache e o MySQL rodando pelo xamp, crie um banco de dados chamado "controle_advocacia". Mais a frente será efetuado a restauração do backup!

# Pelo terminal, navegue até a pasta C:\xampp\htdocs\ (Para instalação do xampp no windows)

# Baixe o projeto
$ git clone <https://github.com/PauloHenrique7010/ControleAdvocaciaV2/>

# Dentro da pasta do projeto

# Navegue até a pasta ./server/ e digite:
$ npm install

# Volte para a pasta raiz do projeto e navegue até a pasta ./application/outros/
# Suba o arquivo controle_advocacia.sql para o banco de dados utilizando o comando
$ mysql -u root controle_advocacia < controle_advocacia.sql

# Espere até o fim da operação.
```


### 🎲 Rodando o Back End (servidor)

```bash

# Abrir com o terminal a pasta server que está localizada na raiz do projeto 

# Inicie o servidor
$ node index
#ou
$ nodemon index

# O servidor inciará na porta:8020 - acesse <http://localhost:8020>

# Após isso, tudo deve estar funcionando corretamente!
```
### 🎲 Rodando a aplicação 
```bash
# No seu navegador abra a pagina "http:/localhos/ControleAdvocaciaV2/
```


### Referências
<p>[Como fazer um bom README](https://blog.rocketseat.com.br/como-fazer-um-bom-readme/)</p>
<p>[Exemplo ReadMe](https://github.com/tgmarinho/meetapp)</p>

