@props(['article' => null, 'categories'])

<!-- Category Select -->
<x-admin.article.option :categories="$categories" :article="$article" />

<!-- SEO -->
<x-admin.article.seo :article="$article" />