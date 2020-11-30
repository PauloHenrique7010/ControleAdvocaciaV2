<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'PrincipalCtr';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['Cliente'] = 'ClienteCtr';
$route['NovoCliente'] = 'ClienteCtr/novoCliente';
$route['ExcluirCliente/(:any)'] = 'ClienteCtr/excluirCliente/$1';
$route['ExcluirCliente'] = 'ClienteCtr';
$route['EditarCliente/(:any)'] = 'ClienteCtr/editarCliente/$1';
$route['EditarCliente'] = 'ClienteCtr';


$route['Servico'] = 'ServicoCtr';
$route['NovoServico'] = 'ServicoCtr/novoServico';
$route['ConfirmarNovoServico'] = 'ServicoCtr/confirmarNovoServico';
$route['PesquisarServico'] = 'ServicoCtr/pesquisar';
/*
$route['Processo'] = 'ProcessoCtr';
$route['NovoProcesso'] = 'ProcessoCtr/novoProcesso';
$route['ExcluirProcesso/(:any)'] = 'ProcessoCtr/excluirProcesso/$1';*/


//Foro
$route['aForo'] = 'AjaxCtr/aForo'; //AdicionaForo
$route['eForo'] = 'AjaxCtr/eForo'; //ExcluirForo

//profissao
$route['eProfissao'] = 'AjaxCtr/eProfissao';


//admin
$route['Admin'] = 'AdminCtr/login';
$route['Admin/Banco'] = 'AdminCtr/Banco';
$route['Admin/NovoBanco']     = 'AdminCtr/NovoBanco';
$route['Admin/ExcluirBanco']  = 'AdminCtr/ExcluirBanco';
$route['Admin/AlterarBanco']   = 'AdminCtr/AlterarBanco';
$route['Admin/CarregarBancos']   = 'AdminCtr/CarregarBancos';

$route['Admin/Profissao'] = 'AdminCtr/Profissao';
$route['Admin/NovaProfissao'] = 'AdminCtr/NovaProfissao';
$route['Admin/AlterarProfissao/(:any)'] = 'AdminCtr/AlterarProfissao/$1';
$route['Admin/AlterarProfissao/'] = 'AdsminCtr/Profissao';
$route['Admin/ExcluirProfissao/(:any)'] = 'AdminCtr/ExcluirProfissao/$1';
$route['Admin/ExcluirProfissao'] = 'AdminCtr/ExcluirProfissao';

$route['Admin/OrgaoClasse'] = 'AdminCtr/OrgaoClasse';
$route['Admin/NovoOrgaoClasse'] = 'AdminCtr/NovoOrgaoClasse';
$route['Admin/AlterarOrgaoClasse/(:any)'] = 'AdminCtr/AlterarOrgaoClasse/$1';
$route['Admin/AlterarOrgaoClasse'] = 'AdminCtr/OrgaoClasse';
$route['Admin/ExcluirOrgaoClasse/(:any)'] = 'Admin/ExcluirOrgaoClasse/$1';
$route['eOrgaoClasse'] = 'AjaxCtr/eOrgaoClasse';

$route['Admin/EstadoCivil'] = 'AdminCtr/EstadoCivil';
$route['Admin/NovoEstadoCivil'] = 'AdminCtr/NovoEstadoCivil';
$route['Admin/AlterarEstadoCivil/(:any)'] = 'AdminCtr/AlterarEstadoCivil/$1';
$route['Admin/AlterarEstadoCivil'] = 'AdminCtr/EstadoCivil';
$route['eEstadoCivil'] = 'AjaxCtr/eEstadoCivil';

$route['Admin/Foro'] = 'AdminCtr/Foro';
$route['Admin/NovoForo'] = 'AdminCtr/NovoForo';
$route['Admin/AlterarForo/(:any)'] = 'AdminCtr/AlterarForo/$1';
$route['Admin/AlterarForo'] = 'AdminCtr/Foro';
$route['eForo'] = 'AjaxCtr/eForo';

$route['Admin/TipoProcesso'] = 'AdminCtr/TipoProcesso';
$route['Admin/NovoTipoProcesso'] = 'AdminCtr/NovoTipoProcesso';
$route['Admin/AlterarTipoProcesso/(:any)'] = 'AdminCtr/NovoTipoProcesso/$1';

$route['Admin/TipoServico'] = 'AdminCtr/TipoServico';
$route['Admin/NovoTipoServico'] = 'AdminCtr/NovoTipoServico';
$route['Admin/AlterarTipoServico/(:any)'] = 'AdminCtr/NovoTipoServico/$1';

$route['Admin/TipoAcao'] = 'AdminCtr/TipoAcao';
$route['Admin/NovoTipoAcao'] = 'AdminCtr/NovoTipoAcao';
$route['Admin/AlterarTipoAcao/(:any)'] = 'AdminCtr/NovoTipoAcao/$1';

$route['Admin/FormaPagamento'] = 'AdminCtr/FormaPagamento';
$route['Admin/NovoFormaPagamento'] = 'AdminCtr/NovoFormaPagamento';
$route['Admin/AlterarFormaPagamento/(:any)'] = 'AdminCtr/NovoFormaPagamento/$1';

$route['Admin/ConfiguracaoEscavador'] = 'ConfiguracaoCtr/ConfiguracaoToken';
$route['Admin/ConfiguracaoEscavador/Confirmar'] = 'ConfiguracaoCtr/ConfirmarConfiguracaoToken';


//outros
$route['pForo'] = 'PesquisaCtr/foro'; //pesquisaForo
$route['pCompetencia'] = 'PesquisaCtr/competencia';
$route['pAdvogado'] = 'PesquisaCtr/advogado';
$route['pTokenEscavador'] = 'PesquisaCtr/tokenEscavador';
$route['pCliente'] = 'PesquisaCtr/cliente';
$route['pFormaPagamento'] = 'PesquisaCtr/formaPagamento';


$route['Configuracoes'] = 'AdminCtr';
