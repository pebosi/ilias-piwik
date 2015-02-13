<?php

include_once("./Services/UIComponent/classes/class.ilUserInterfaceHookPlugin.php");

/**
 * Piwik settings class
 *
 * @author Peter Boden <mail@pebosi.net>
 *
 */
class ilPiwikPlugin extends ilUserInterfaceHookPlugin
{
	private $settings = null;

	private $piwik_site_id = null;
	private $piwik_host = null;

  /**
  * Gets the name of the plugin.
  *
  * @return string The name of the plugin.
  */
  function getPluginName()
  {
    return "Piwik";
  }

	/**
	 * Object initialization. Can be overwritten by plugin class
	 * (and should be made protected final)
	 */
	protected function init()
	{
		$this->settings = new ilSetting("ui_uihk_piwik");
		$this->piwik_site_id = $this->settings->get("piwik_site_id", null);
		$this->piwik_host = $this->settings->get("piwik_host", null);
	}



	/**
	 * After activation processing
	 */
	protected function afterActivation()
	{
		// save the settings
		$this->setPiwikSiteId($this->getPiwikSiteId());
		$this->setPiwikHost($this->getPiwikHost());
	}

	/**
	 * Sets the piwik site id.
	 *
	 * @param int $a_value The new value
	 */
	public function setPiwikSiteId($a_value)
	{
		$this->piwik_site_id = !empty($a_value) ? filter_var($a_value, FILTER_SANITIZE_NUMBER_INT) : null;
		$this->settings->set('piwik_site_id', $this->piwik_site_id);
	}

	/**
	 * Gets the piwik site id.
	 *
	 * @return int The current value
	 */
	public function getPiwikSiteId()
	{
		return $this->piwik_site_id;
	}

	/**
	 * Sets the piwik url http.
	 *
	 * @param int $a_value The new value
	 */
	public function setPiwikHost($a_value)
	{
    $this->piwik_host = !empty($a_value) ? filter_var($a_value, FILTER_SANITIZE_URL) : null;
		$this->piwik_host = rtrim($this->piwik_host, '/');
		$this->settings->set('piwik_host', $this->piwik_host);
	}

	/**
	 * Gets the piwik url http.
	 *
	 * @return int The current value
	 */
	public function getPiwikHost()
	{
		return $this->piwik_host;
	}
}
