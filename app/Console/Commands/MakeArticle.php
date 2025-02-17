<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ArticleManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeArticle extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:make-article';

    /**
     * @var string
     */
    protected $description = 'Make a new article';

    public function handle(ArticleManager $articleManager): int
    {
        $this->info(trans('articles.actions.creating'));

        $title = $this->ask(trans('articles.actions.questions.title'));

        $slug = Str::slug($title);

        $filename = $articleManager->path("{$slug}.md");

        if (File::exists($filename)) {
            $this->error(trans('articles.actions.existing'));

            return self::FAILURE;
        }

        $locale = $this->choice(trans('articles.actions.questions.locale'), ['es', 'en']);

        $content = File::get(resource_path('stubs/article.stub'));

        $content = str_replace(['{{ title }}', '{{ locale }}'], [$title, $locale], $content);

        File::put($filename, $content);

        $this->info(trans('articles.actions.created'));

        return self::SUCCESS;
    }
}
