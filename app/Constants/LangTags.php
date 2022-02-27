<?php

namespace App\Constants;

class LangTags
{
    public const ES = 'es';
    public const EN = 'en';

    public static function excludes(): array
    {
        return [
            self::ES,
            self::EN,
        ];
    }
}
