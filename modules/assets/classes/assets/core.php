<?php defined('SYSPATH') or die('No direct script access.');

class Assets_Core {
	
	/**
	 *	Add files as assets
	 *
	 *	@param	
	 *
	 */
	
	/**
	 * Get the link tag of less paths
	 *
	 * @param   array     array of css paths
	 * @param   string    value of media css type
	 * @param   boolean   allow compression
	 * @return  string    link tag pointing to the css paths
	 */
	public static function compile($type, $files = array(), $attributes = NULL, $custom_path = false, $tags = true)
	{		
		// return comment if array is empty
		if (empty($files)) return self::_html_comment('no files...');
		
		// get assets config
		$config = Kohana::$config->load('assets');
		
		$assets = array();
		$errors = array();
		
		$extension = self::_get_extension($type);

		// validate
		foreach ($files as $file)
		{
			// remove extension if its present
			$file = preg_replace(array('/\.less/', '/\.js/'), '', $file);
			$file = ($custom_path !== false) ? $custom_path.$file : $config[$type]['filepath'].$file;

			if (file_exists($file.$extension))
			{
				array_push($assets, $file);
			}
			else
			{
				array_push($errors, self::_html_comment('could not find '.Debug::path($file).$extension));
			}
		}

		// all stylesheets are invalid
		if ( ! count($assets)) return self::_html_comment('all files are invalid');
		
		if ( ($type == 'css') AND ($attributes == NULL) ) $attributes = array('media' => 'screen');
		
		if($tags)
		{
			return ($type == 'css') ? html::style(self::_combine($assets, $type), $attributes)."\n\t".implode("\n\t", $errors) : html::script(self::_combine($assets, $type), $attributes)."\n\t".implode("\n\t", $errors);
		}
		else
		{
			return ($type == 'css') ? self::_combine($assets, $type).implode("\n\t", $errors) : self::_combine($assets, $type).implode("\n\t", $errors);
		}
		
	}
	
	/**
	 * Complies the files set as javascript framework in config.
	 */
	
	public static function compile_js_framework(){
		$config = Kohana::$config->load('assets');
		
		$framework = array();
		
		foreach($config['js']['framework'] as $file)
		{
			$file = preg_replace(array('/\.less/', '/\.js/'), '', $file);
			
			if (file_exists($file.'.js'))
			{
				array_push($framework, $file);
			}
			else{
				return self::_html_comment('could not find '.Debug::path($file).'.js');
			}
		}
						
		
		if (empty($framework)) return self::_html_comment('no framework files...');
		
		return html::script(self::_combine($framework, 'js', true));
	}
	
	/**
	 * Return extension for provided type of asset
	 *
	 * @param string string of asset type
	 * @return string extension for asset
	 */
	 protected static function _get_extension($type){
	 	return ( $type == 'css' ) ? '.less' : '.'.$type ;
	 }
	 
	
	/**
	 * Combine the files
	 *
	 * @param   array    array of asset files
	 * @return  string   path to the asset file
	 */
	protected static function _combine($files, $type, $framework = false)
	{
		// get assets' css config
		$config = Kohana::$config->load('assets');

		// get the most recent modified time of any of the files
		$last_modified = self::_get_last_modified($files, self::_get_extension($type));

		// compose the asset filename
		$compiled = md5(implode('|', $files)).'-'.$last_modified.'.'.$type;

		// compose the path to the asset file
		$filename = $config[$type]['storage'].$compiled;

		// if the file exists no need to generate
		if ( ! file_exists($filename))
		{
			self::_generate_assets($filename, $files, $type, $framework);
		}

		return $filename;
	}
	
	/**
	 * Get the most recent modified date of files
	 *
	 * @param   array    array of asset files
	 * @return  string   path to the asset file
	 */
	protected static function _get_last_modified($files, $extension)
	{
		$last_modified = 0;

		foreach ($files as $file) 
		{

			$modified = filemtime($file.$extension);
			if ($modified !== false and $modified > $last_modified) $last_modified = $modified;
		}

		return $last_modified;
	}

	
	/**
	 * Generate an asset file
	 *
	 * @param   string   filename of the asset file
	 * @param   array    array of source files
	 */
	protected static function _generate_assets($filename, $files, $type, $framework = false)
	{
		// create data holder
		$data = '';

		touch($filename);

		ob_start();

		foreach($files as $file)
		{
			$data .= file_get_contents($file.self::_get_extension($type));
		}

		echo $data;

		file_put_contents($filename, ob_get_clean(), LOCK_EX);

		self::_compile($filename, $type, $framework);
	}
	
	/**
	 * Compile and compress the files
	 *
	 * @param   string   path to the file to compile
	 */
	public static function _compile($filename, $type, $framework)
	{
		// get assets' css config
		$config = Kohana::$config->load('assets');
	
		if ($type == 'css')
		{
			$less = new lessc($filename);

			try
			{
				$compiled = $less->parse();
				$compressed = self::_compress($compiled);
				file_put_contents($filename, $compressed);
			}
			catch (LessException $ex)
			{
				exit($ex->getMessage());
			}
		}
		else if($type == 'js')
		{
			try
			{
				$data = file_get_contents($filename);
				if($framework)
				{
					$compressed = ($config['compress']) ? JShrink::minify($data, array('flaggedComments' => false)) : $data;
				}
				else
				{
					$compressed = ($config['compress']) ? JShrink::minify($config['js']['before'].$data.$config['js']['after'], array('flaggedComments' => false)) : $config['js']['before'].$data.$config['js']['after'];
				}
				
				file_put_contents($filename, $compressed);
			}
			catch (LessException $ex)
			{
				exit($ex->getMessage());
			}
		}
	}
	
	/**
	 * Compress the css file
	 *
	 * @param   string   css string to compress
	 * @return  string   compressed css string
	 */
	private static function _compress($data)
	{
		$data = preg_replace('~/\*[^*]*\*+([^/][^*]*\*+)*/~', '', $data);
		$data = preg_replace('~\s+~', ' ', $data);
		$data = preg_replace('~ *+([{}+>:;,]) *~', '$1', trim($data));
		$data = str_replace(';}', '}', $data);
		$data = preg_replace('~[^{}]++\{\}~', '', $data);

		return $data;
	}
	
	
	/**
	 * Format string to HTML comment format
	 *
	 * @param   string   string to format
	 * @return  string   HTML comment
	 */
	protected static function _html_comment($string = '')
	{
		return '<!-- '.$string.' -->';
	}



}