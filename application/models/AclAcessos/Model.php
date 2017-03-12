<?php

class AclAcessos_Model extends Zend_Acl {

    public function __construct() {

        // Papeis = Role = Grupos
        $this->addRole(new Zend_Acl_Role("V"));
        $this->addRole(new Zend_Acl_Role("U"), 'V');
        $this->addRole(new Zend_Acl_Role("A"), 'U');

        // Recursos
        $this->add(new Zend_Acl_Resource('erp:Index'));
        $this->add(new Zend_Acl_Resource('erp:Auth'));
        $this->add(new Zend_Acl_Resource('erp:Permissao-Negada'));

        //Adiciona a categorias de módulos do banco nos Resources
        $categoriasDB = new ModulosCategorias_Db();
        $categorias = $categoriasDB->fetchAll()->toArray();
        if (!empty($categorias)):
            foreach ($categorias AS $categoria):
                $this->add(new Zend_Acl_Resource('erp:categoria' . $categoria['id']));
            endforeach;
        endif;

        //Adiciona os módulos do banco nos Resources
        $modulosDb = new Modulos_Db();
        $modulos = $modulosDb->fetchAll()->toArray();
        if (!empty($modulos)):
            foreach ($modulos AS $modulo):
                if (!$this->has("erp:" . $modulo['controller'])):
                    $this->add(new Zend_Acl_Resource('erp:' . $modulo['controller']));
                endif;
            endforeach;
        endif;

        // Privilegios
        $this->allow("V", "erp:Index");
        $this->allow("V", "erp:Auth");
        $this->allow("V", "erp:Permissao-Negada");
        //Se o tipo de usuario for usuario
        $auth = new WS_Auth('erp');
        if ($auth->hasIdentity()):
            $usuario = $auth->getIdentity();
            if ($usuario->papel == 'U'):
                $aclSistema = new AclAcessoSistema_Model();
                //pega permissões dos grupos de módulos que pode acessar
                $permissoes = $aclSistema->getPermissionsGroup($usuario->id);
                if (!empty($permissoes)):
                    foreach ($permissoes AS $permissao):
                        if (!$this->hasRole("erp:categoria" . $permissao['id'])):
                            $this->allow("U", "erp:categoria" . $permissao['id']);
                        endif;
                    endforeach;
                endif;

                //pega permissões dos módulos que pode acessar
                $permissoes = $aclSistema->getPermissions($usuario->id);

                if (!empty($permissoes)):
                    foreach ($permissoes AS $permissao):
                        if (!$this->hasRole("erp:" . $permissao['controller'])):
                            $this->allow("U", "erp:" . $permissao['controller']);
                        endif;
                    endforeach;
                endif;
            endif;
        endif;
        /* Submodulos */
        /* Resources */
        $this->add(new Zend_Acl_Resource('erp:Acl-Acesso-Sistema'));
        $this->add(new Zend_Acl_Resource('erp:Clientes-Enderecos'));
        $this->add(new Zend_Acl_Resource('erp:Clientes-Telefones'));
        $this->add(new Zend_Acl_Resource('erp:Administradores-Condominios-Telefones'));
        $this->add(new Zend_Acl_Resource('erp:Clientes-Crm'));
        $this->add(new Zend_Acl_Resource('erp:Clientes-Arquivos'));
        $this->add(new Zend_Acl_Resource('erp:Empresas-Arquivos'));
        $this->add(new Zend_Acl_Resource('erp:Administradores-Crm'));
        $this->add(new Zend_Acl_Resource('erp:Administradores-Arquivos'));
        $this->add(new Zend_Acl_Resource('erp:Fornecedores-Crm'));
        $this->add(new Zend_Acl_Resource('erp:Fornecedores-Arquivos'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Arquitetonicos'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Arquitetonicos-Arquivos'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Hidro'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Ppci'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Atividades'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Atividades-Tempo'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Arquivos'));
        $this->add(new Zend_Acl_Resource('erp:Projetos-Crm'));
        $this->add(new Zend_Acl_Resource('erp:Templates'));
        $this->add(new Zend_Acl_Resource('erp:Ordem-Servico-Imagens'));
        //$this->add(new Zend_Acl_Resource('erp:Cte'));
        //$this->add(new Zend_Acl_Resource('erp:Textos'));
        /* Permissoes */
        $this->allow("A", "erp:Acl-Acesso-Sistema");
        $this->allow("U", "erp:Clientes-Enderecos");
        $this->allow("U", "erp:Clientes-Telefones");
        $this->allow("U", "erp:Administradores-Condominios-Telefones");
        $this->allow("U", "erp:Clientes-Crm");
        $this->allow("U", "erp:Clientes-Arquivos");
        $this->allow("U", "erp:Empresas-Arquivos");
        $this->allow("U", "erp:Administradores-Crm");
        $this->allow("U", "erp:Administradores-Arquivos");
        $this->allow("U", "erp:Fornecedores-Crm");
        $this->allow("U", "erp:Fornecedores-Arquivos");
        $this->allow("U", "erp:Projetos-Arquitetonicos");
        $this->allow("U", "erp:Projetos-Arquitetonicos-Arquivos");
        $this->allow("U", "erp:Projetos-Hidro");
        $this->allow("U", "erp:Projetos-Ppci");
        $this->allow("U", "erp:Projetos-Atividades");
        $this->allow("U", "erp:Projetos-Atividades-Tempo");
        $this->allow("U", "erp:Projetos-Arquivos");
        $this->allow("U", "erp:Projetos-Crm");
        $this->allow("U", "erp:Templates");
        $this->allow("U", "erp:Ordem-Servico-Imagens");
        //$this->allow("U", "erp:Cte");
        //$this->allow("U", "erp:Textos");

        $this->deny("U", "erp:Modulos");
        $this->allow("A", "erp:Modulos");
        $this->allow("A");
    }

}
