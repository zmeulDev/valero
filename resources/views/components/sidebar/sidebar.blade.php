@props([
'shareUrl' => request()->url(),
'shareTitle' => config('app.name'),
'popularArticles',
'categories'
])

<div class="lg:col-span-1">
  <div class="sticky top-16 space-y-8">
    <aside class="space-y-8">
      <!-- Search -->
      <x-sidebar.sidebar-search :categories="$categories" />

      <!-- Partner Ads -->
      <x-sidebar.sidebar-ads />

      <!-- Share this article -->
      <x-sidebar.sidebar-share :shareUrl="$shareUrl" :shareTitle="$shareTitle" />

      <!-- Popular Articles Section -->
      <x-sidebar.sidebar-popular :popularArticles="$popularArticles" />
    </aside>
  </div>
</div>