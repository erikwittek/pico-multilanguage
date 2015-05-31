<?php

/**
 * Example hooks for a Pico plugin
 *
 * @author Erik Wittek
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Multilanguage {

	private $display_only_translated;

	private $default_language;
	private $content_dir;
	private $current_language;
	private $available_languages;

	private function split_path($url) {
		$tmpUrl = explode("/", $url);
		return [
			'language' => array_slice($tmpUrl, 1)[0],
			'page_path' => implode("/", array_slice($tmpUrl, (-1 * count($tmpUrl) + 2))),
		];
	}

	public function plugins_loaded()
	{
		
	}

	public function config_loaded(&$settings)
	{
		$this->default_language = $settings['default_language'];
		$this->current_language = $settings['default_language'];
		$this->content_dir = $settings['content_dir'];
		$this->available_languages = array_slice(scandir($settings['content_dir']), 2);
		$this->display_only_translated = $settings['display_only_translated'];
	}
	
	public function request_url(&$url)
	{
		$requestLanguage = explode("/", $url)[0];
		if(in_array($requestLanguage, $this->available_languages)){
			$this->current_language = $requestLanguage;
		} else {
			$url = $this->current_language . "/" . $url;
		}
	}
	
	public function before_load_content(&$file)
	{
		
	}
	
	public function after_load_content(&$file, &$content)
	{
		
	}
	
	public function before_404_load_content(&$file)
	{
		
	}
	
	public function after_404_load_content(&$file, &$content)
	{
		
	}
	
	public function before_read_file_meta(&$headers)
	{

	}
	
	public function file_meta(&$meta)
	{

	}

	public function before_parse_content(&$content)
	{
		
	}
	
	public function after_parse_content(&$content)
	{
		
	}
	
	public function get_page_data(&$data, $page_meta)
	{
	}
	
	public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
	{
		$tmpPages = [];
		if ($this->display_only_translated) {
			foreach ($pages as $key => $value) {
				if ($this->split_path($key)['language'] === $this->current_language) {
					$tmpPages[$key] = $value; 
				}
			}
			$pages = $tmpPages;
		} else {
			foreach ($pages as $key => $value) {
				$page_path = $this->split_path($key)['page_path'];

				if ($this->split_path($key)['language'] === $this->current_language) {
					$tmpPages[$key] = $value;
				} else {

					foreach ($this->available_languages as $language) {
						$searchPage = $this->content_dir . $language . "/" . $this->split_path($key)['page_path'];
						echo $searchPage . " | "; 
						//if (in_array($this->content_dir . "/" . $this->current_language . "/", haystack)) {
						//	# code...
						//}
					}

				}
				
			}
		}
	}
	
	public function before_twig_register()
	{
		
	}
	
	public function before_render(&$twig_vars, &$twig, &$template)
	{
		$twig_vars['current_language'] = $this->current_language;
		$twig_vars['available_languages'] = $this->available_languages;
	}
	
	public function after_render(&$output)
	{
		
	}
	
}

?>
