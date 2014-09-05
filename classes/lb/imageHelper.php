<?php

namespace Lb;

Class ImageHelper 
{
	public static function renderUploadField($config = array())
	{
		$data['name'] = isset($config['name']) ? $config['name'] : 'image';
		$data['label'] = isset($config['label']) ? $config['label'] : 'Image';
		$data['labelBtn'] = isset($config['labelBtn']) ? $config['labelBtn'] : 'Choisir une image';
		$data['imagePreview'] = isset($config['imagePreview']) ? $config['imagePreview'] : '';

		$res = \View::forge('image_helper/upload_field_html', $data, false)->render();
		return $res;
	}

	public static function renderUploadJsInit($config = array())
	{
		$data['idAdd'] = isset($config['idAdd']) ? $config['idAdd'] : 'form_add';
		$data['labelUpload'] = isset($config['labelUpload']) ? $config['labelUpload'] : 'Charger l\'image';

		$res = \View::forge('image_helper/upload_field_js_init', $data, false)->render();
		return $res;
	}

	public static function renderUploadJs($config = array())
	{
		$data['idAdd'] = isset($config['idAdd']) ? $config['idAdd'] : 'form_add';
		$data['labelUpload'] = isset($config['labelUpload']) ? $config['labelUpload'] : 'Charger l\'image';
		$data['name'] = isset($config['name']) ? $config['name'] : 'image';
		$data['url'] = isset($config['url']) ? $config['url'] : '#';
		$data['idReceipt'] = isset($config['idReceipt']) ? $config['idReceipt'] : '?';
		$data['autoUpload'] = isset($config['autoUpload']) ? $config['autoUpload'] : true;
		$data['autoSubmit'] = isset($config['autoSubmit']) ? $config['autoSubmit'] : false;

		$res = \View::forge('image_helper/upload_field_js', $data, false)->render();
		return $res;
	}

}