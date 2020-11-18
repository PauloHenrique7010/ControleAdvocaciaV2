# ControleAdvocacia


### Sobre
<p> ControleAdvocacia é um sistema feito para advogados onde o mesmo pode adicionar seus clientes e após isso, cadastrar serviços prestados para eles. 
	O sistema mostra os pagamentos pendentes de cada serviço, assim como o valor da parcela(caso parcelado)</p>
<span> Feito com Nodejs, Codeigniter </span>
<h4 align="center"> 
	🚧  Programa  🚀 Em construção...  🚧
</h4>

### Funções

- [x] CRUD de usuário.
- [x] Cadastro de serviços.
- [ ] Visualização de pagamentos pendentes (Com filtros).
- [ ] Emissão de boleto.
- [ ] Gerar peça em .doc após criação de serviço.

### Pré-requisitos

Antes de começar, você vai precisar ter instalado em sua máquina as seguintes ferramentas:
[Git](https://git-scm.com), [Node.js](https://nodejs.org/en/), [Xampp](https://www.apachefriends.org/) 
- Após a instalação do xampp, verifique se o rewrite_mod está ativo
- Execute o painel de controle do xampp e inicie o Mysql e o Apache
- <b> Caso seja pedido permissão do firewall, permita! </b>

### 🎲 Instalar o projeto

```bash

# Crie um banco de dados chamado "controle_advocacia". Mais a frente será efetuado a restauração do backup!


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

