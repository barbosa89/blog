<?php

declare(strict_types=1);

return [
    'author' => env('BLOG_AUTHOR', 'Omar Barbosa'),
    'mail' => env('BLOG_MAIL', 'contacto@omarbarbosa.com'),
    'links' => [
        'github' => 'https://github.com/barbosa89',
        'linkedin' => 'https://www.linkedin.com/in/omar-andres-barbosa-ortiz',
        'twitter' => [
            'url' => 'https://twitter.com/@Omar_Andres_Bar',
            'nickname' => '@Omar_Andres_Bar',
        ],
        'facebook' => 'https://www.facebook.com/omarandres.barbosaortiz',
    ],
    'products' => [
        [
            'id' => 'phenix',
            'title' => 'PhenixPHP',
            'image' => 'images/products/phenix.png',
            'url' => 'https://phenix.omarbarbosa.com',
            'translation' => 'page.portfolio_projects.phenix',
            'featured' => true,
        ],
        [
            'id' => 'hellen-suite',
            'title' => 'Hellen Suite',
            'image' => 'images/products/hellen-suite.png',
            'url' => 'https://hellensuite.com',
            'translation' => 'page.portfolio_projects.hellen_suite',
            'featured' => false,
        ],
        [
            'id' => 'cashio',
            'title' => 'Cash IO',
            'image' => 'images/products/cashio.png',
            'url' => 'https://cashio.omarbarbosa.com',
            'translation' => 'page.portfolio_projects.cashio',
            'featured' => false,
        ],
    ],
    'customers' => [
        [
            'id' => 'readcol',
            'title' => 'Red Administrativa de Colombia Ltda.',
            'image' => 'images/customers/readcol.webp',
            'url' => 'https://readcol.com/',
        ],
        [
            'id' => 'sueno-real',
            'title' => 'Hotel Posada Sueño Real',
            'image' => 'images/customers/logo.webp',
            'url' => 'https://posadasuenoreal.com',
        ],
        [
            'id' => 'apces',
            'title' => 'APCES E.S.P.',
            'image' => 'images/customers/apces.webp',
            'url' => 'https://apces.com.co',
        ],
        [
            'id' => 'teo',
            'title' => 'Tribunal de Ética Odontológico de Santander',
            'image' => 'images/customers/teos.webp',
            'url' => 'https://teosantander.com/',
        ],
        [
            'id' => 'tlsi',
            'title' => 'TLSI',
            'image' => 'images/customers/tlsi.png',
            'url' => 'https://tlsi.com.co/',
        ],
    ],
];
