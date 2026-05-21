<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Services\SitemapGenerator;

class AdminSitemapController extends Controller
{
    public function generate()
    {
        SitemapGenerator::generate();

        if (request()->is('admin/generate-sitemap')) {
            return redirect()->back()->with('success', 'Sitemap generated successfully!');
        }
        return redirect()->back();
    }
}
