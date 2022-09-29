<?php

class Zend_View_Helper_SiteMenu extends Zend_View_Helper_Navigation {

    public function SiteMenu() {
        // Home
        $page[] = array(
            'controller' => 'index',
            'route' => 'default',
            'label' => 'Home',
            'title' => 'Home'
        );

        // Institucional
        $page[] = array(
            'controller' => 'sobre-nos',
            'route' => 'default',
            'label' => 'Institucional',
            'title' => 'Institucional'
        );

        // Serviços
        $subpages = array();
        $subpages[] = array(
            'title' => 'Para sua Residência',
            'label' => 'Para sua Residência',
            'controller' => 'servicos',
            'action' => 'residencia'
        );
        $subpages[] = array(
            'title' => 'Para seu Condomínio',
            'label' => 'Para seu Condomínio',
            'controller' => 'servicos',
            'action' => 'condominio'
        );
        $subpages[] = array(
            'title' => 'Para sua Empresa',
            'label' => 'Para sua Empresa',
            'controller' => 'servicos',
            'action' => 'empresa'
        );
        $page[] = array(
            'controller' => 'servicos',
            'action' => 'residencia',
            'route' => 'default',
            'label' => 'Serviços',
            'title' => 'Serviços',
            'pages' => $subpages
        );


        // Vantagens
        $page[] = array(
            'controller' => 'vantagens',
            'route' => 'default',
            'label' => 'Vantagens',
            'title' => 'Vantagens',
        );

        // Estação de Tratamento
        $subpages = array();
        $subpages[] = array(
            'title' => 'Estação de tratamento',
            'label' => 'Estação de tratamento',
            'controller' => 'informacoes',
            'action' => 'estacao-tratamento'
        );
        $subpages[] = array(
            'title' => 'Legislação',
            'label' => 'Legislação',
            'controller' => 'informacoes',
            'action' => 'legislacao'
        );
        $subpages[] = array(
            'title' => 'Perguntas Frequentes',
            'label' => 'Perguntas Frequentes',
            'controller' => 'informacoes',
            'action' => 'perguntas-frequentes'
        );
        $page[] = array(
            'controller' => 'informacoes',
            'route' => 'default',
            'label' => 'Informações',
            'title' => 'Informações',
            'action' => 'estacao-tratamento',
            'pages' => $subpages
        );

        // Fale Conosco
        $page[] = array(
            'controller' => 'contato',
            'route' => 'default',
            'label' => 'Contato',
            'title' => 'Contato'
        );

        $container = new Zend_Navigation($page);
        $this->setContainer($container);

        return $this;
    }

}

