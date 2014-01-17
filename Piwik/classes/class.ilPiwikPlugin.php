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
	private $piwik_url_http = null;
	private $piwik_url_https = null;
  
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
		$this->piwik_url_http = $this->settings->get("piwik_url_http", null);
		$this->piwik_url_https = $this->settings->get("piwik_url_https", null);
	}
	


	/**
	 * After activation processing
	 */
	protected function afterActivation()
	{
		// save the settings
		$this->setPiwikSiteId($this->getPiwikSiteId());
		$this->setPiwikUrlHttp($this->getPiwikUrlHttp());
		$this->setPiwikUrlHttps($this->getPiwikUrlHttps());
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
	public function setPiwikUrlHttp($a_value)
	{
    		$this->piwik_url_http = !empty($a_value) ? filter_var($a_value, FILTER_SANITIZE_URL) : null;
		$this->piwik_url_http = rtrim($this->piwik_url_http, '/');
		$this->settings->set('piwik_url_http', $this->piwik_url_http);
	}
	
	/**
	 * Gets the piwik url http.
	 * 
	 * @return int The current value
	 */
	public function getPiwikUrlHttp()
	{
		return $this->piwik_url_http;
	}
  
	/**
	 * Sets the piwik url https.
	 * 
	 * @param int $a_value The new value
	 */
	public function setPiwikUrlHttps($a_value)
	{
		$this->piwik_url_https = !empty($a_value) ? filter_var($a_value, FILTER_SANITIZE_URL) : null;
		$this->piwik_url_https = rtrim($this->piwik_url_https, '/');
		$this->settings->set('piwik_url_https', $this->piwik_url_https);
	}
	
	/**
	 * Gets the piwik url https.
	 * 
	 * @return int The current value
	 */
	public function getPiwikUrlHttps()
	{
		return $this->piwik_url_https;
	}
}
