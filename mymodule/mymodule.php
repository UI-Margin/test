<?php   
if (!defined('_PS_VERSION_')) {
  	exit;
}

class mymodule extends Module {
	public function __construct()
	{
		$this->name = 'front_office_features'; // Имя модуля
		$this->tab = ''; // Заголовок - название модуля
		$this->version = '0.1.0'; // Версия модуля
		$this->author = 'Firstname Lastname'; // Автор модуля
		$this->need_instance = 0; // Указывает, следует ли загружать класс модуля при отображении страницы «Модули»: (1) True, (0) False
		$this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_); // Указывает, что файлы шаблонов модуля были созданы с использованием средств начальной загрузки PrestaShop
		$this->bootstrap = true;
	
		parent::__construct();
	
		$this->displayName = $this->l('My module');
		$this->description = $this->l('Description of my module.');
	
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	
		if (!Configuration::get('MYMODULE_NAME')) {
			$this->warning = $this->l('No name provided');
		}
	}
	public function install() {
		if (!parent::install()) {
			return false;
		}
		return true;
	}
	public function uninstall() {
		if (!parent::uninstall()) {
			return false;
		}
		return true;
	}

	// Но наличие getContent() публичного метода в MyModule объекте делает только ссылку «Configure»; он не создает страницу конфигурации из ниоткуда.
	public function getContent() {
		$output = null;
	
		if (Tools::isSubmit('submit'.$this->name)) // Tools::isSubmit() является специальным методом PrestaShop, который проверяет, подтверждена ли указанная форма. В этом случае, если форма конфигурации еще не была проверена, весь if() блок пропускается, и PrestaShop будет использовать только последнюю строку, которая отображает конфигурацию с текущими значениями, генерируемую этим displayForm() методом.
		{
			$my_module_name = strval(Tools::getValue('MYMODULE_NAME')); // Tools:getValue() является специальным методом PrestaShop, который извлекает содержимое массива POST или GET массива, чтобы получить значение указанной переменной. В этом случае мы извлекаем значение MYMODULE_NAME переменной формы, превращаем его значение в текстовую строку с использованием этого strval() метода и сохраняем его в $my_module_name переменной PHP.
			if (!$my_module_name
			|| empty($my_module_name)
			|| !Validate::isGenericName($my_module_name)) // Затем мы проверяем наличие фактического содержимого $my_module_name, включая использование Validate::isGenericName(). Объект содержит много методов проверки данных, среди которых есть , метод , который поможет вам сохранить только строки , которые являются допустимыми именами PrestaShop - значение, строка , которая не содержит специальные символы, для краткости. ValidateisGenericName()
				$output .= $this->displayError($this->l('Invalid Configuration value')); // Если какая-либо из этих проверок завершится с ошибкой, конфигурация откроется с сообщением об ошибке, показывая, что проверка формы не удалась. Переменная, которая содержит окончательное исполнение в HTML код , который делает страницу конфигурации, таким образом , начинается с сообщением об ошибке, созданный с использованием Prestashop в метод. Этот метод возвращает правильный HTML-код для нашей потребности, и поскольку этот код является первым , это означает, что конфигурация откроется с этим сообщением. $outputdisplayError()$output
			else
			{
				Configuration::updateValue('MYMODULE_NAME', $my_module_name); // Если все эти проверки успешны, это означает, что мы можем сохранить значение в нашей базе данных. Как мы видели ранее в этом уроке, Configuration объект имеет только тот метод, который нам нужен: updateValue() будет хранить новое значение MYMODULE_NAME в таблице данных конфигурации. Для этого мы добавляем дружественное сообщение пользователю, указывая, что значение действительно было сохранено: мы используем displayConfirmation() метод PrestaShop для добавления этого сообщения в качестве первых данных в $outputпеременной - и, следовательно, в верхней части страницы.
				$output .= $this->displayConfirmation($this->l('Settings updated'));
			}
		}
		return $output.$this->displayForm(); // Наконец, мы используем настраиваемый displayForm()метод (который мы собираемся создать и объяснить в следующем разделе), чтобы добавить контент $output (независимо от того, была ли форма отправлена ​​или нет) и вернуть этот контент на страницу. Обратите внимание, что мы могли бы включить код displayForm() справа внутри getContent() , но решили разделить их на читаемость и разделение проблем.
	}
	public function displayForm() {
		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		
		// Init Fields form array
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Settings'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Configuration value'),
					'name' => 'MYMODULE_NAME',
					'size' => 20,
					'required' => true
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'btn btn-default pull-right'
			)
		);
		
		$helper = new HelperForm();
		
		// Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		
		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		
		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;        // false -> remove toolbar
		$helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
		$helper->submit_action = 'submit'.$this->name;
		$helper->toolbar_btn = array(
		'save' => array(
			'desc' => $this->l('Save'),
			'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
			'&token='.Tools::getAdminTokenLite('AdminModules'),
		),
		'back' => array(
			'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
			'desc' => $this->l('Back to list')
		)
	);
		
	// Load current value
	$helper->fields_value['MYMODULE_NAME'] = Configuration::get('MYMODULE_NAME');
		
	return $helper->generateForm($fields_form);
	}
}