<?php

declare(strict_types=1);

namespace App\Support;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class CspPolicies implements Preset
{
    private const string GOOGLE = 'https://www.google.com';

    private const string GOOGLE_ADS = 'https://googleads.g.doubleclick.net';

    private const string GOOGLE_ADS_PAGE = 'https://pagead2.googlesyndication.com';

    private const string GOOGLE_ANALYTICS = 'https://www.google-analytics.com';

    private const string GOOGLE_STATIC = 'https://www.gstatic.com';

    private const string GOOGLE_TAG_MANAGER = 'https://www.googletagmanager.com';

    private const string STATIC_DOUBLE_CLICK = 'https://static.doubleclick.net';

    private const string TPC_GOOGLE_ADS = 'https://tpc.googlesyndication.com';

    private const string YOUTUBE = 'https://www.youtube.com';

    private const string YOUTUBE_IMAGES = 'https://i.ytimg.com';

    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::CONNECT, [
                Keyword::SELF,
                self::GOOGLE,
                self::GOOGLE_ADS,
                self::GOOGLE_ADS_PAGE,
                self::GOOGLE_ANALYTICS,
                self::GOOGLE_TAG_MANAGER,
            ])
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::FONT, [Keyword::SELF, 'data:'])
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME, [
                Keyword::SELF,
                self::GOOGLE,
                self::GOOGLE_ADS,
                self::GOOGLE_ADS_PAGE,
                self::TPC_GOOGLE_ADS,
                self::YOUTUBE,
            ])
            ->add(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->add(Directive::IMG, [
                Keyword::SELF,
                'data:',
                'blob:',
                self::GOOGLE_ADS,
                self::GOOGLE_ADS_PAGE,
                self::GOOGLE_ANALYTICS,
                self::GOOGLE_TAG_MANAGER,
                self::STATIC_DOUBLE_CLICK,
                self::YOUTUBE_IMAGES,
            ])
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::SCRIPT, [
                Keyword::SELF,
                self::GOOGLE,
                self::GOOGLE_ADS,
                self::GOOGLE_ADS_PAGE,
                self::GOOGLE_STATIC,
                self::GOOGLE_TAG_MANAGER,
                self::STATIC_DOUBLE_CLICK,
            ])
            ->add(Directive::STYLE, Keyword::SELF)
            ->add(Directive::WORKER, [Keyword::SELF, 'blob:'])
            ->addNonce(Directive::SCRIPT)
            ->addNonce(Directive::STYLE);
    }
}
