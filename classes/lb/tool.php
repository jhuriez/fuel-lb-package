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
	 * Helper for image upload process
	 * @return string name of the new image
	 */
	public static function processUpload($uploadConfig = array(), $fieldsName = array(), $miniatureConfig = array(), $prefixName = '', $returnArray = false)
	{
		$imageName = '';
		$fieldsName[] = 'Filedata'; // If Uploadify

		// Config miniature
		(!isset($miniatureConfig['quality'])) and $miniatureConfig['quality'] = 70;
		(!isset($miniatureConfig['folder'])) and $miniatureConfig['folder'] = 'optimize';
		$miniatureConfig['resize'] = isset($miniatureConfig['resize']) && $miniatureConfig['resize'] !== null ? 
									$miniatureConfig['resize'] : (isset($miniatureConfig['height']) && $miniatureConfig['height'] !== null &&
																  isset($miniatureConfig['width']) && $miniatureConfig['width'] !== null);

		// Upload
		\Upload::process($uploadConfig);
		
		if (\Upload::is_valid()){
			\Upload::save();
			foreach (\Upload::get_files() as $file){
				if (in_array($file['field'], $fieldsName))
				{
					$savedAs = $file['saved_as'];
					$path = $uploadConfig['path'];

					// Get extension
					(!isset($miniatureConfig['ext'])) and $miniatureConfig['ext'] = $file['extension'];

					///////////////////////////////////////////
					// Original convert (for extension) 	 //
					///////////////////////////////////////////
					if ($miniatureConfig['ext'] != $file['extension'])
					{
						$image = \Image::forge()->load($path . DS . $savedAs);
						$originalImageNameNoExtension = \Str::sub($savedAs, 0, strlen($miniatureConfig['ext'])*-1-1);
						$originalImageName = $originalImageNameNoExtension . '.' . $miniatureConfig['ext'];
						// check if the file already exists
						if (file_exists($path . DS . $originalImageName))
						{
							// generate a unique filename if needed
							$counter = 0;
							$suffix = '';
							do
							{
								$suffix = '_'.++$counter;
								$originalImageName = $originalImageNameNoExtension . $suffix . '.' . $miniatureConfig['ext'];
							}
							while (file_exists($path . DS . $originalImageName));
						}
						$image->save($uploadConfig['path'] . DS . $originalImageName);
						// Delete old
						unlink($uploadConfig['path'] . DS . $savedAs);
						
						$savedAs = $originalImageName;
					}


					/////////////////////////
					// Optimize image 	   //
					/////////////////////////
					$optimizedImage = \Image::forge(array('quality' => $miniatureConfig['quality']));
					$optimizedImage->load($path . DS . $savedAs);
					$optimizedImageName = \Str::sub($savedAs, 0, strlen($miniatureConfig['ext'])*-1-1) . '.' . $miniatureConfig['ext'];

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
        	return array(
    			'imageName' => $imageName,
    			'imageNameSimple' => $optimizedImageName,
    			'original' => $savedAs,
    		);
        }
        else
        {
			return $imageName;
        }
		
	}

}