<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ArticleManager;
use Illuminate\Console\Command;

class PublishArticles extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:publish-articles';

    /**
     * @var string
     */
    protected $description = 'Publish all articles';

    public function handle(ArticleManager $articleManager): int
    {
        $articleManager->publish();

        $this->info(trans('articles.actions.published'));

        return self::SUCCESS;
    }
}
