<?php

namespace App\Console\Commands;

use App\Helpers\Sitemap;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * @var string
     */
    protected $description = 'Build a fresh sitemap';

    public function handle(): int
    {
        Sitemap::generate();

        $this->info('Sitemap was generated');

        return self::SUCCESS;
    }
}
