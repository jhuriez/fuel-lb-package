<?php

namespace Lb;

Class FileuploadHelper 
{
	public static function renderField($attributes)
	{
		$theme = isset($attributes['theme']) ? $attributes['theme'] : 'bootstrap';
		$data['labelBtn'] = isset($attributes['labelBtn']) ? $attributes['labelBtn'] : 'Choisir un fichier';
		$data['fieldName'] = $attributes['name'];
		$data['fieldLabel'] = $attributes['label'];
		$res = \View::forge('fileupload_helper/render_field_'.$theme, $data, false)->render();
		return $res;
	}


}