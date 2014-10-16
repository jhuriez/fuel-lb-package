<?php

namespace Lb;

class Validate
{
	public static function checkEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}