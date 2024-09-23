@props([
'shareUrl' => request()->url(),
'shareTitle' => config('app.name'),
'popularArticles',
'categories'
])

<div class="lg:col-span-1">
  <div class="sticky top-16 space-y-8">
    <aside class="space-y-8">
      <!-- Share this article -->
      <x-sidebar-share :shareUrl="$shareUrl" :shareTitle="$shareTitle" />

      <!-- Popular Articles Section -->
      <x-sidebar-popular :popularArticles="$popularArticles" />

      <!-- Categories Section -->
      <x-sidebar-categories :categories="$categories" />
    </aside>
  </div>
</div>