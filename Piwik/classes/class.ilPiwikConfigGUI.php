<?php

include_once("./Services/Component/classes/class.ilPluginConfigGUI.php");

/**
 * Piwik configuration class.
 *
 * @author Peter Boden <mail@pebosi.net>
 *
 */
class ilPiwikConfigGUI extends ilPluginConfigGUI
{
	/**
	 * Handles all commmands, default is 'configure'
	 *
	 * @access public
	 */
	function performCommand($cmd)
	{
		switch ($cmd)
		{
			case 'configure':
			case 'save':
				$this->$cmd();
				break;
		}
	}

	/**
	 * Configure screen
	 *
	 * @access public
	 */
	public function configure()
	{
		global $tpl, $ilDB;

		$plugin = $this->getPluginObject();
		$form = $this->initConfigurationForm($plugin);

		// get binary
		$piwik_site_id = $plugin->getPiwikSiteId();
		if ($piwik_site_id == null)
			ilUtil::sendFailure($plugin->txt("warning_no_site_id_or_url"));

		// set all plugin settings values
		$val = array();
		$val["piwik_site_id"] = $piwik_site_id;
		$val["piwik_host"] = $plugin->getPiwikHost();
		$form->setValuesByArray($val);

		$tpl->setContent($form->getHTML());
	}

	/**
	 * Save form input
	 *
	 */
	public function save()
	{
		global $tpl, $lng, $ilCtrl, $ilDB;

		$plugin = $this->getPluginObject();
		$form = $this->initConfigurationForm($plugin);

		if ($form->checkInput())
		{
			$_POST["piwik_host"] = str_replace("https://", "", $_POST["piwik_host"]);
			$_POST["piwik_host"] = str_replace("http://", "", $_POST["piwik_host"]);
			$_POST["piwik_host"] = trim($_POST["piwik_host"], "/");
			
			$plugin->setPiwikSiteId(intval($_POST["piwik_site_id"]));
			$plugin->setPiwikHost($_POST["piwik_host"]);

			ilUtil::sendSuccess($lng->txt("saved_successfully"), true);
			$ilCtrl->redirect($this, "configure");
		}
		else
		{
			$form->setValuesByPost();
			$tpl->setContent($form->getHtml());
		}
	}

	/**
	 * Init configuration form.
	 *
	 * @return object form object
	 * @access public
	 */
	private function initConfigurationForm($plugin)
	{
		global $lng, $ilCtrl;

		include_once("Services/Form/classes/class.ilPropertyFormGUI.php");
		$form = new ilPropertyFormGUI();
		$form->setTableWidth("100%");
		$form->setTitle($plugin->txt("plugin_configuration"));
		$form->setFormAction($ilCtrl->getFormAction($this));

		// piwik site id
		$input = new ilTextInputGUI($plugin->txt("piwik_site_id"), "piwik_site_id");
		$input->setRequired(true);
		$input->setValue($plugin->getPiwikSiteId());
		$input->setInfo($plugin->txt("piwik_site_id_info"));
		$form->addItem($input);

		// piwik host
		$input = new ilTextInputGUI($plugin->txt("piwik_host"), "piwik_host");
		$input->setRequired(true);
		$input->setValue($plugin->getPiwikHost());
		$input->setInfo($plugin->txt("piwik_host_info"));
		$form->addItem($input);

		$form->addCommandButton("save", $lng->txt("save"));

		return $form;
	}
}
