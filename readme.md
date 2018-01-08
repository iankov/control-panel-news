# Installation

```bash
 composer require iankov/control-panel-news
```

* Run migrations
    ```bash
    php artisan migrate --path=vendor/iankov/control-panel-news/database/migrations
    ```

* Publish config file if needed
    ```bash
    php artisan vendor:publish --tag=icp_news_config
    ```

* Add config to `modules` section of the `config/icp.php` file
    ```php
    'news' => [
        'route' => [
            'path' => base_path('vendor/iankov/control-panel-news/src/routes/news.php'),
            'namespace' => '\Iankov\ControlPanelNews\Controllers\Control',
        ],
    ]
    ```

* Also add menus to `menu` array of `config/icp.php` file
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