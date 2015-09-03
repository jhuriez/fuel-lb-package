<?php

namespace Lb;

Class Tool 
{

	/**
	 * Get number occurrence in table
	 * @param  int  $id       ID of the object
	 * @param  string  $table    Table name
	 * @param  string  $attribute Attribute name
	 * @param  string  $value    Value to test
	 * @param  integer $count
	 * @return int
	 */
	public static function getOccurence($id, $table, $attribute, $value, $count=0)
	{
		$whereAttribute = ($count > 1) ? $value.'-'.$count : $value;
		$res = \DB::select('*')->from($table)->where($attribute, '=', $whereAttribute)->where('id', '!=', $id)->execute()->as_array();
		
		if (!empty($res))
		{
			$count++;
			return self::getOccurence($id, $table, $attribute, $value, $count);
		}
		else
		{
			return $count;
		}
	}

	/**
	 * date
	 * Retourne la date demandée dans le format souhaité
	 *
	 * @param String $format -> Le format de date souhaité
	 * @param String $date -> La date devant être convertie
	 * @return Date -> La date convertie
	 */
	public static function date($format, $date)
	{
		if ($format == NULL || $date == NULL){
			return false;
		}

		$timestamp = is_numeric($date) ? $date : strtotime($date);
		return date($format, $timestamp);
	}

	/**
	 * Get array for SELECT Input from a model
	 * @param  string $modelClassName
	 * @param  string $keyAttribute  
	 * @param  srting $valueAttribute
	 * @return array                
	 */
	public static function getArraySelectInput($modelClassName, $keyAttribute, $valueAttribute)
	{
		$query = call_user_func(array($modelClassName, 'query'));
        $objects = $query->select($keyAttribute, $valueAttribute)->get();
        $res = array();

        foreach($objects as $object)
            $res[$object->{$keyAttribute}] = $object->{$valueAttribute};
        
        return $res;
	}

	/**
	 * Create directory recursively
	 * @param  [type] $path [description]
	 * @param  [type] $base [description]
	 * @return [type]       [description]
	 */
	public static function createDirRecursive($path, $base = DOCROOT)
	{
		$path = str_replace('/', DS, $path);
		$path = str_replace('\\', DS, $path);


		$arrPath = explode(DS, $path);
		$cleanPath = '';
		foreach($arrPath as $folder)
		{
			$folder = trim($folder);

			if (empty($folder)) continue;
			else
			{
				if (!is_dir($base.DS.$cleanPath.$folder))
				{
	        		\File::create_dir($base.DS.$cleanPath, $folder);
				}

				$cleanPath .= $folder.DS;
			}
		}
	}

	/**
	 * Helper for image upload process
	 * @return string name of the new image
	 */
	public static function processUpload($uploadConfig = array(), $fieldsName = array(), $miniatureConfig = array(), $prefixName = '', $returnArray = false, $forceArray = false)
	{
		$imageName = '';

		if ( ! empty($fieldsName))
		{
			$fieldsName[] = 'Filedata'; // If Uploadify
			$fieldsName[] = 'files:0'; // If File Upload Bootstrap
		}
		$results = array();

		// Config miniature
		(!isset($miniatureConfig['quality']) || !$miniatureConfig['quality']) and $miniatureConfig['quality'] = 70;
		(!isset($miniatureConfig['folder']) || !$miniatureConfig['folder']) and $miniatureConfig['folder'] = 'optimize';
		$miniatureConfig['resize'] = isset($miniatureConfig['resize']) && $miniatureConfig['resize'] !== null ? 
									$miniatureConfig['resize'] : (isset($miniatureConfig['height']) && $miniatureConfig['height'] !== null &&
																  isset($miniatureConfig['width']) && $miniatureConfig['width'] !== null);

		if (!isset($miniatureConfig['ext']) || empty($miniatureConfig['ext']))
			$miniatureConfig['ext'] = array();
		else
			$miniatureConfig['ext'] = (array)$miniatureConfig['ext'];

		// Upload
		\Upload::process($uploadConfig);

		
		if (\Upload::is_valid()){
			\Upload::save();
			foreach (\Upload::get_files() as $file){
				if (in_array($file['field'], $fieldsName) || empty($fieldsName))
				{
					$savedAs = $file['saved_as'];
					$path = $uploadConfig['path'];
					$isImage = in_array($file['extension'], array('img', 'png', 'jpg', 'jpeg', 'bmp', 'gif'));

					// Get extension
					(empty($miniatureConfig['ext']) || !$miniatureConfig) and $isImage and $miniatureConfig['ext'][] = $file['extension'];
					$extCast = reset($miniatureConfig['ext']);

					///////////////////////////////////////////
					// Original convert (for extension) 	 //
					///////////////////////////////////////////
					if ( ! in_array($file['extension'], $miniatureConfig['ext']) && $isImage)
					{
						$image = \Image::forge()->load($path . DS . $savedAs);
						$originalImageNameNoExtension = \Str::sub($savedAs, 0, strlen($extCast)*-1-1);
						$originalImageName = $originalImageNameNoExtension . '.' . $extCast;
						// check if the file already exists
						if (file_exists($path . DS . $originalImageName))
						{
							// generate a unique filename if needed
							$counter = 0;
							$suffix = '';
							do
							{
								$suffix = '_'.++$counter;
								$originalImageName = $originalImageNameNoExtension . $suffix . '.' . $extCast;
							}
							while (file_exists($path . DS . $originalImageName));
						}
						$image->save($uploadConfig['path'] . DS . $originalImageName);
						// Delete old
						unlink($uploadConfig['path'] . DS . $savedAs);
						
						$savedAs = $originalImageName;
					}
					else
					{
						$extCast = $file['extension'];
					}

					/////////////////////////
					// Optimize image 	   //
					/////////////////////////
					if ($isImage)
					{
						$optimizedImage = \Image::forge(array('quality' => $miniatureConfig['quality']));
						$optimizedImage->load($path . DS . $savedAs);
						$optimizedImageName = \Str::sub($savedAs, 0, strlen($extCast)*-1-1) . '.' . $extCast;

		                // Check if folder exist
		                if (!file_exists($uploadConfig['path'] . DS . $miniatureConfig['folder']))
		                    \File::create_dir($uploadConfig['path'], $miniatureConfig['folder']);

		                // Save the mini
		                if ($miniatureConfig['resize'] == true)
		                {
		                	$sizes = $optimizedImage->sizes();
		                	$width = $miniatureConfig['width'];
		                	$height = $miniatureConfig['height'];

		                	if ($width < $sizes->width || $height < $sizes->height)
				                $optimizedImage = $optimizedImage->resize($width, $height, true);
		                }
			            $optimizedImage->save($uploadConfig['path'] . DS . $miniatureConfig['folder'] . DS . $optimizedImageName);
						$imageName = $prefixName . DS . $miniatureConfig['folder'] . DS . $optimizedImageName;
					}
					else
					{
						$imageName = $prefixName . DS . $savedAs;
						$optimizedImageName = '';
					}


					// Replace "\" by "/" standard URI
					$imageName = str_replace(DS.DS, '/', $imageName);
					$imageName = str_replace(DS, '/', $imageName);

					$results[$file['field']]['imageName'] = $imageName;
					$results[$file['field']]['optimizedImageName'] = $optimizedImageName;
					$results[$file['field']]['savedAs'] = $savedAs;
				}
			}
		}

		// Check errors
		foreach (\Upload::get_errors() as $file){
			foreach ($file['errors'] as $error){
				if ($error['error'] !== UPLOAD_ERR_NO_FILE){
					\Messages::error($error['message']);
				}
			}
		}

		

        if ($returnArray)
        {

			// If only one file
			if (count($results) == 1 && ! $forceArray)
			{
				return current($results);
			}
			else
			{
				return $results;
			}
        }
        else
        {
			return $imageName;
        }
		
	}

	public static function url($uri)
	{
		$uri = str_replace("\n", "", $uri);
		$uri = str_replace("\r", "", $uri);
		$uri = str_replace(" ", "%20", $uri);

        $regex = '/^([a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+.*)$/';

        if ($uri && ! empty($uri))
        {
	        $isUrl = (preg_match($regex, $uri) || filter_var($uri, FILTER_VALIDATE_URL));

	        // Si c'est une URL interne
	        if ( ! $isUrl)
	        {
		        $uri = \Uri::base() . $uri;
	        }

	        // Si il manque le protocol
			if(! preg_match("#^(http|https|ftp)://#i", $uri))
			{
				$uri = 'http://'.$uri;
			}

	        // Replace // by /
	        $uri = str_replace('://', '||sep_protocol||', $uri);
	        $uri = str_replace('//', '/', $uri);
	        $uri = str_replace('||sep_protocol||', '://', $uri);

	        return $uri;

        }
		else
		{
			return $uri;
		}
	}

}