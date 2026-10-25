<?php 

return [
    'blog' => [
        'method' => 'cover',
        'sizes' => [
            'small' => [210, 140],
            'medium' => [400, 300],
            'large' => null,
        ],
    ],
    'avatar' => [
        'path' => '/user/avatar/',
        'method' => 'fit',
        'sizes' => [
            'small' => [100, 100, 'zoom' => 0.5],
            'large' => null
        ],
    ],
];
// config('media_av1.blog');