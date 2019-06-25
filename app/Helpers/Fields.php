<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class Fields
{
	public static function get($model)
	{
		return config('blog.fields.' . $model);
	}

	public static function parsed($model)
	{
		$fields = config('blog.fields.' . $model);
		$parsed = [];

		foreach ($fields as $field) {
			$parsed[] = $model . '.' . $field;
		}

		return $parsed;
	}
}
