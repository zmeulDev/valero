<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.xml file';

    public function handle()
    {
        $this->info('Starting sitemap generation...');

        SitemapGenerator::generate();

        $this->info('Sitemap generated successfully!');
    }
}
