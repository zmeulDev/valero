@props(['article' => null, 'categories'])


<!-- Category Select -->
<x-admin.article.option :categories="$categories" :article="$article" />

<!-- SEO -->
<x-admin.article.seo :article="$article" />

<!-- Featured Image -->
<x-admin.article.featured :categories="$categories" :article="$article" />

<!-- Gallery Images -->
<x-admin.article.gallery :categories="$categories" :article="$article" />
