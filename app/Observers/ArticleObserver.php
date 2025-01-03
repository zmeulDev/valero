<?php

namespace App\Observers;

use App\Models\Article;
use App\Http\Controllers\Admin\AdminSitemapController;

class ArticleObserver
{
    public function created(Article $article)
    {
        $this->regenerateSitemap();
    }

    public function updated(Article $article)
    {
        $this->regenerateSitemap();
    }

    public function deleted(Article $article)
    {
        $this->regenerateSitemap();
    }

    private function regenerateSitemap()
    {
        app(AdminSitemapController::class)->generate();
    }
}

