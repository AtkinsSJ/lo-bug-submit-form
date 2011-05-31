<?php

require_once('include/Mustache.php');

class BugSubmitPage extends Mustache
{
	protected $_template = ''; // Content Template
	
	public function __construct()
	{
		$this->_template = file_get_contents('templates/template.mustache');
	}
	
	public function render()
	{
		return parent::render($this->_template);
	}
}

$page = new BugSubmitPage();
echo $page->render();

?>
