<?php

class Abastecimentos_Model extends WS_Model
{

	protected $_status;

	public function __construct()
	{
		$this->_db = new Abastecimentos_Db();
		$this->_title = 'Gerenciador de Abastecimentos do Caminhão';
		$this->_singular = 'Abastecimento';
		$this->_plural = 'Abastecimentos';
		$this->_layoutList = 'basic';
		$this->_primary = 'a.id';

		parent::__construct();
	}

	public function setBasicSearch()
	{
		$this->_basicSearch = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('a' => 'abastecimentos'), array('*'))
			->joinLeft(array('f' => 'fornecedores'), 'a.fornecedor_id = f.id', array('fornecedor' => 'razao_social'))
			->joinInner(array('c' => 'caminhoes'), 'a.caminhao_id = c.id', array('caminhao' => 'placa'));
	}

	public function setAdjustFields()
	{
		$this->_adjustFields = array(
			'data' => 'date',
			'valor' => 'money',
			'litros' => 'float',
		);
	}

	public function setOrderFields()
	{
		$this->_orderFields = array(
			'data' => 'DESC',
		);
	}

	public function setSearchFields()
	{
		$this->_searchFields = array(
			'f.razao_social' => 'text',
			'c.placa' => 'text'
		);
	}

	public function setViewFields()
	{
		$this->_viewFields = array(
			'data' => 'Data',
			'litros' => 'Litros / Unidades',
			'km' => 'KM',
			'media' => 'Média',
			'valor_litro' => 'Valor/Litro',
			'valor' => 'Valor',
			'caminhao' => 'Caminhão',
			'fornecedor' => 'Fornecedor',
		);
	}

	public function setFormFields()
	{
		$this->_formFields = array(
			'id' => array(
				'type' => 'Hidden'
			),
			'caminhao_id' => array(
				'label' => 'Caminhão',
				'type' => 'Select',
				'options' => Caminhoes_Model::fetchPair(),
				'required' => true
			),
			'aditivo_id' => array(
				'type' => 'Select',
				'label' => 'Aditivo',
				'options' => Aditivos_Model::fetchPair(),
				'required' => true
			),
			'fornecedor_id' => array(
				'type' => 'Select',
				'label' => 'Fornecedor',
				'options' => Fornecedores_Model::fetchPair(),
				'required' => true
			),
			'data' => array(
				'type' => 'Date',
				'label' => 'Data',
				'required' => true
			),
			'litros' => array(
				'type' => 'Money',
				'label' => 'Litros / Unidades',
				'required' => true
			),
			'km' => array(
				'type' => 'Number',
				'label' => 'Km',
				'required' => true
			),
			'media' => array(
				'type' => 'Money',
				'label' => 'Média',
			),
			'valor_litro' => array(
				'type' => 'Money',
				'label' => 'Valor por Litro',
			),
			'valor' => array(
				'type' => 'Money',
				'label' => 'Valor',
				'required' => true
			),
		);
	}

}
