<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticleManager;

class PublishArticles extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:publish-articles';

    /**
     * @var string
     */
    protected $description = 'Command description';

    public function handle(ArticleManager $articleManager): int
    {
        $articleManager->publish();

        $this->info('All articles were published successfully.');

        return self::SUCCESS;
    }
}
