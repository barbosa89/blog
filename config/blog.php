<?php

declare(strict_types=1);

/**
 *  Blog app configuration
 */

return [

    'paginate' => 20,

    'fields' => [
        'posts' => [
            'id',
            'slug',
            'title',
            'excerpt',
            'body',
            'published',
            'publish_date',
            'featured_image',
            'featured_image_caption',
            'author_id',
            'created_at',
            'updated_at',
            'meta',
        ],
        'tags' => [
            'id',
            'slug',
            'name',
            'created_at',
            'updated_at',
            'meta',
        ],
        'authors' => [
            'id',
            'name',
            'bio',
            'avatar',
            'meta',
        ],
    ],
];
