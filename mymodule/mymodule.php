<?php
	if (!defined('_PS_VERSION_'))
	exit;
	class MyModule extends Module
	{
		public function __construct()
		{
			$this->name = 'mymodule'; //задаём имя нашего модуля
			$this->tab = 'others'; //задаём категорию модуля, в которой он будет отображаться в админке
			// например, 'front_office_features' - поместит модуль в раздел 'Модули для фронт-офиса'
			$this->version = '1.0.0'; //версия модуля, например "2.0b", "3.04 beta 5" или "0.67 (для разработчика)"
			$this->author = 'Author'; //имя автора
			$this->need_instance = 0; //открыть страницу настроек модуля сразу после установки или нет
			// если установить параметр = 1, то установка модуля может выполняться дольше
			$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); //совместимость модуля с версией cms
			$this->bootstrap = true; //использовать инструмент bootstrap для построения элементов модуля, рекомендую установить true
			parent::__construct();
			$this->displayName = $this->l('Модуль'); //отображаемое имя модуля
			$this->description = $this->l('Описание модуля'); //отображаемое описание модуля
			$this->confirmUninstall = $this->l('Вы действительно хотите удалить модуль?'); //сообщение, при удалении модуля
			if (!Configuration::get('MYMODULE'))
			$this->warning = $this->l('Ошибка!'); //проверка на ошибки во время установки
		}
	public function install()
	{
		if (Shop::isFeatureActive()) //если несколько магазинов, то включаем модуль для всех
		Shop::setContext(Shop::CONTEXT_ALL);
		//установка модуля и привязка его к необходимым хукам, в которых он будет использован, создание конфигурации для модуля в базе данных
			if (!parent::install() || //установлен ли родительский класс
				!$this->registerHook('displayHeader') || //модуль прикрепился к хуку 'displayHeader'
				!Configuration::updateValue('MYMODULE', 'my value') //создаём конфигурацию 'MYMODULE' со значением 'my value'
			)
				return false;
				return true;
			}
		//удаление модуля
		public function uninstall()
		{
		if (!parent::uninstall() ||
			!Configuration::deleteByName('MYMODULE')
		)
		return false;
		return true;
	}

	$this->fields_form = array(
		'h3' => array(       
			'title' => $this->l('Редактировать текст'),
		),   
		'input' => array(       
			array(           
				'type' => 'text',
				'name' => 'shipping_method',
				'class' => 'form-content',
			),
		),
		'select' => array(
			'type' => 'select',                              // This is a <select> tag.
			'label' => $this->l('Shipping method:'),         // The <label> for this <select> tag.
			'desc' => $this->l('Choose a shipping method'),  // A help text, displayed right next to the <select> tag.
			'name' => 'shipping_method',                     // The content of the 'id' attribute of the <select> tag.
			'required' => true,                              // If set to true, this option must be set.
			'options' => array(
				'query' => $options,                           // $options contains the data itself.
				'id' => 'id_option',                           // The value of the 'id' key must be the same as the key for 'value' attribute of the <option> tag in each $options sub-array.
			'name' => 'name'                               // The value of the 'name' key must be the same as the key for the text content of the <option> tag in each $options sub-array.
			)
		),
		$options = array(
			array(
			  'id_option' => 1,                 // The value of the 'value' attribute of the <option> tag.
			  'name' => 'Method 1'              // The value of the text content of the  <option> tag.
			),
			array(
			  'id_option' => 2,
			  'name' => 'Method 2'
			),
			array(
				'id_option' => 3,
				'name' => 'Method 3'
			),
		),
		'submit' => array(
			'title' => $this->l('Save'),       
			'class' => 'button'   
		),
	);
 }