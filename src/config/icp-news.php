<?php

return [
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
];