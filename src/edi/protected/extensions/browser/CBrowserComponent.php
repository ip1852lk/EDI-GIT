<?php
	Yii::import('application.extensions.browser.Browser');

	class CBrowserComponent extends CApplicationComponent
	{
		private $_myBrowser;
		public function init() {}
		public function __construct()
		{
			$this->_myBrowser = new Browser();
		}

		/**
		 * Call a Browser function
		 * @param string $method
		 * @param array $params
		 * @return string
		 * @throws CException
		 */
		public function __call($method, $params)
		{
			if (is_object($this->_myBrowser) && get_class($this->_myBrowser)==='Browser')
				return call_user_func_array(array($this->_myBrowser, $method), $params);
			else
				throw new CException(Yii::t('app', 'Can not call a method of a non existent object'));
		}
	}
?>