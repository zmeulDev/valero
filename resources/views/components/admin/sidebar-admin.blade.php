@props(['article' => null, 'categories'])

<!-- Scheduled Publish Date -->
<x-admin.sidebar-admin-schedule :article="$article" />

<!-- Category Select -->
<x-admin.sidebar-admin-category :categories="$categories" :article="$article" />

<!-- Featured Image -->
<x-admin.sidebar-admin-featured :categories="$categories" :article="$article" />

<!-- Gallery Images -->
<x-admin.sidebar-admin-gallery :categories="$categories" :article="$article" />