<{{ $tag }}<?php foreach($attributes as $name => $value) : ?> {{ $name }}<?php if(! is_bool($value)) : ?>="{{ $value }}"<?php endif ?><?php endforeach ?>><?php 
    if ($inner) {
        if ($tag === 'script' && ($attributes['type'] ?? '') === 'application/ld+json') {
             echo json_encode(json_decode($inner), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            echo $inner;
        }
    }
?></{{ $tag }}>