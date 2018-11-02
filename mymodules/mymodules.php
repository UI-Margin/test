<?php
	if (!defined('_PS_VERSION_'))
	exit;
	class mymodules extends Module
	{
		public function __construct()
		{
			$this->name = 'mymodules'; //задаём имя нашего модуля
			$this->tab = 'others'; //задаём категорию модуля, в которой он будет отображаться в админке
			// например, 'front_office_features' - поместит модуль в раздел 'Модули для фронт-офиса'
			$this->version = '1.0.0'; //версия модуля, например "2.0b", "3.04 beta 5" или "0.67 (для разработчика)"
			$this->author = 'Author'; //имя автора
			$this->need_instance = 0; //открыть страницу настроек модуля сразу после установки или нет
			// если установить параметр = 1, то установка модуля может выполняться дольше
			$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_); //совместимость модуля с версией cms
			$this->bootstrap = true; //использовать инструмент bootstrap для построения элементов модуля, рекомендую установить true
			parent::__construct();
			$this->displayName = $this->l('Модуль'); //отображаемое имя модуля
			$this->description = $this->l('Описание модуля'); //отображаемое описание модуля
			$this->confirmUninstall = $this->l('Вы действительно хотите удалить модуль?'); //сообщение, при удалении модуля
			if (!Configuration::get('mymodules'))
				$this->warning = $this->l('Ошибка!'); //проверка на ошибки во время установки
		}
		public function install()
		{
		if (Shop::isFeatureActive()) //если несколько магазинов, то включаем модуль для всех
			Shop::setContext(Shop::CONTEXT_ALL);
			//установка модуля и привязка его к необходимым хукам, в которых он будет использован, создание конфигурации для модуля в базе данных
			if (!parent::install() || //установлен ли родительский класс
				!$this->registerHook(Array('displayTop','displayLeftColumn','Topunder')) ||
				!Configuration::updateValue('mymodules', 'text') //создаём конфигурацию 'MYMODULE' со значением 'my value'
			)
			return false;
			return true;
		}
		//удаление модуля
		public function uninstall()
		{
			if (!parent::uninstall() ||
				!Configuration::deleteByName('mymodules')
			)
			return false;
			return true;
		} 
		

	public function hookTopunder($params)
		{
		return $this->display(__FILE__, 'mymodules.tpl');
		}
	public function hookdisplayLeftColumn($params)
		{
		return $this->display(__FILE__, 'mymodules.tpl');
		}
	public function hookdisplayTop($params)
		{
		return $this->display(__FILE__, 'mymodules.tpl');
		}
	}