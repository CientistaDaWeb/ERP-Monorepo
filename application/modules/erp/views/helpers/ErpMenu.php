<?php

class Zend_View_Helper_ErpMenu extends Zend_View_Helper_Navigation {

    public function ErpMenu() {
        $auth = new WS_Auth('erp');
        if ($auth->hasIdentity()) :
            $usuario = $auth->getIdentity();
            $module = 'erp';

            $page[] = array(
                'uri' => '/erp/',
                'order' => -100,
                'label' => 'Home',
                'title' => 'Home'
            );

            $DBModCat = new ModulosCategorias_Db();
            $categorias = $DBModCat->fetchAll();
            foreach ($categorias AS $categoria):
                $ModulosModel = new Modulos_Model();
                $subpages = NULL;
                if ($usuario->papel == 'A'):
                    $modulos = $ModulosModel->findByCategory($categoria['id']);
                else:
                    $modulos = $ModulosModel->getPermissions($categoria['id'], $usuario->id);
                endif;

                if (!empty($modulos)):
                    foreach ($modulos AS $modulo):
                        $route = 'modulo';
                        $target = '';
                        if ($modulo['route'] == 'P'):
                            $route = 'print';
                            $target = '_blank';
                        endif;
                        $subpages[] = array(
                            'title' => $modulo['titulo'],
                            'label' => $modulo['titulo'],
                            'module' => $module,
                            'controller' => $modulo['controller'],
                            'order' => $modulo['ordem'],
                            'action' => $modulo['action'],
                            'target' => $target,
                            'route' => $route
                        );
                    endforeach;
                    $page[] =
                            array(
                                'uri' => 'javascript:void(0);',
                                'title' => $categoria['categoria'],
                                'label' => $categoria['categoria'],
                                'order' => $categoria['ordem'],
                                'pages' => $subpages
                    );
                endif;
            endforeach;
            $container = new Zend_Navigation($page);
            $this->setContainer($container);
        endif;

        return $this;
    }

}

