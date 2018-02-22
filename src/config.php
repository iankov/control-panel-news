<?php

return [
    'modules' => [
        'news' => [
            'route' => [
                'path' => base_path('vendor/iankov/control-panel-news/src/routes/news.php'),
                'namespace' => '\Iankov\ControlPanelNews\Controllers\Control',
            ],
            //models used by package controllers
            'models' => [
                'news' => 'Iankov\ControlPanelNews\Models\News',
                'category' => 'Iankov\ControlPanelNews\Models\NewsCategory'
            ],
            'ckeditor' => [
                'config' => [
                    'allowedContent' => true,
                    'width' => '800px',
                    'height' => '600px',
                    //'contentsCss' => '/assets/web/style.css',
                    //'bodyClass' => 'block-content',
                    'filebrowserBrowseUrl' => config('icp.route.prefix-url').'/file-manager/ckeditor?root_index=root',
                    'filebrowserImageBrowseUrl' => config('icp.route.prefix-url').'/file-manager/ckeditor?root_index=images',
                ]
            ]
        ]
    ],

];