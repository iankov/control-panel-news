Run migrations
```
php artisan migrate --path=vendor/iankov/control-panel-news/database/migrations
```

Publish config file if needed
```
php artisan vendor:publish --tag=icp_news_config
```

Add these lines to 'modules' section of the icp.php config file
```
'news' => [
    'route' => [
        'path' => base_path('vendor/iankov/control-panel-news/src/routes/news.php'),
        'namespace' => '\Iankov\ControlPanelNews\Controllers\Control',
    ],
]
``` 

Also add menus to 'menu' array of icp.php config file
```
[
    'icon' => 'folder',
    'title' => 'News categories',
    'icp_route' => 'news.categories'
],
[
    'icon' => 'file-text',
    'title' => 'News',
    'icp_route' => 'news'
]
```