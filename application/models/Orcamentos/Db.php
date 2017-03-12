<?php

class Orcamentos_Db extends Erp_Db_Table {

    protected $_name = 'orcamentos';
    protected $_dependenceTables = array('OrdensServicos', 'ContasReceber', 'OrcamentosServicos', 'Contratos', 'NotasFiscais');
    protected $_referenceMap = array(
        'Usuario' => array(
            'refTableClass' => 'Usuarios',
            'refColumns' => array('id'),
            'columns' => array('usuario_id')
        ),
        'Cliente' => array(
            'refTableClass' => 'Clientes',
            'refColumns' => array('id'),
            'columns' => array('cliente_id')
        ),
        'Empresa' => array(
            'refTableClass' => 'Empresas',
            'refColumns' => array('id'),
            'columns' => array('empresa_id')
        )
    );

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array(''))
                ->joinLeft(array('os' => 'ordens_servico'), 'o.id = os.orcamento_id', array('childs' => 'COUNT(os.id)'))
                ->group('o.id')
                ->where('o.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}
