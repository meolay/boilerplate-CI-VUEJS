<?php
	
class Assets
{
	protected $base_dir;
	protected $autoload;
	protected $manifest;
	protected $orderby;
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->config('assets', true);
		$this->base_dir = $this->CI->config->item('base_dir', 'assets');
		$this->manifest = $this->CI->config->item('manifest', 'assets');
		
		
		$this->autoload = $this->CI->config->item('autoload', 'assets');
		$this->orderby = $this->CI->config->item('orderby', 'assets');
	}
	
	private function order($data, $keyorder)
	{
		$result = [];
		
		foreach($keyorder as $key)
		{
			if(array_key_exists($key, $data) === true)
			{
				$result[$key] = $data[$key];
			}
		}
		
		$result = array_merge($result, array_diff($data, $result));
		
		return $result;		
	}
	
	private function compile_autoload($data, $useBaseDir = true)
	{
		$result = [];
		foreach($data as $value)
		{
			$value = $this->get_asset($value, $useBaseDir);
			array_push($result, ['src' => $value]);
		}
		
		return $result;
	}
	
	public function get_asset($path, $useBaseDir = true)
	{
		if(filter_var($path, FILTER_VALIDATE_URL) === FALSE)
		{
			if($useBaseDir === true)
			{
				$path = $this->base_dir . $path;
			}
			
			$path = base_url($path);
		}
		return $path;
	}
	
	public function load_manifest($file)
	{
		$file = realpath($this->base_dir . $file);
		$scripts = ['script_js' => [], 'script_css' => []];

		if(is_file($file) === true)
		{
			$contents = file_get_contents($file);
			$contents = json_decode($contents, true);
			
			$scripts['script_js'] = array_filter($contents, function($v, $k) {
				return pathinfo($k)['extension'] === 'js';
			}, ARRAY_FILTER_USE_BOTH);
			
			$scripts['script_css'] = array_filter($contents, function($v, $k) {
				return pathinfo($k)['extension'] === 'css';
			}, ARRAY_FILTER_USE_BOTH);
	
		}
		
		return $scripts;
	}
	
	public function get_autoload()
	{
		$scripts = ['script_js' => [], 'script_css' => []];

		$autoload_js = $this->compile_autoload($this->autoload['script_js']);
		$autoload_css = $this->compile_autoload($this->autoload['script_css']);
		
		$manifest_js = [];
		$manifest_css = [];
		if(is_null($this->manifest) === false)
		{
			$manifest_scripts = $this->load_manifest($this->manifest);
	
			$order = $this->orderby['manifest'];
		
			if(array_key_exists('script_js', $order) === true)
			{
				$manifest_scripts['script_js'] = $this->order($manifest_scripts['script_js'], $order['script_js']);
			}
			
			if(array_key_exists('script_css', $order) === true)
			{
				$manifest_scripts['script_css'] = $this->order($manifest_scripts['script_css'], $order['script_css']);
			}
			
			$manifest_js = $this->compile_autoload($manifest_scripts['script_js'], false);
			$manifest_css = $this->compile_autoload($manifest_scripts['script_css'], false);

		}
		
		if(array_key_exists('script', $this->orderby) === true && empty($this->orderby['script']) === false && $this->orderby['script'][0] === 'autoload')
		{
			$scripts['script_js'] = array_merge($autoload_js, $manifest_js);
			$scripts['script_css'] = array_merge($autoload_css, $manifest_css);
		}
		else
		{
			$scripts['script_js'] = array_merge($manifest_js, $autoload_js);
			$scripts['script_css'] = array_merge($manifest_css, $autoload_css);
		}
		
		return $scripts;
	}
}