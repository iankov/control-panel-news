# Installation

```bash
composer require iankov/control-panel-news
```

Run migrations

```bash
php artisan migrate --path=vendor/iankov/control-panel-news/database/migrations
```

Add items (news & categories) to `icp-menu.php` config file
```
[
    'icon' => 'th',
    'title' => 'News categories',
    'link' => icp_route('news.categories')
],
[
    'icon' => 'list',
    'title' => 'News',
    'link' => icp_route('news')
]
```

## Configuration
You can modify configuration options by adding them to `config/icp.php`<br>
Package config located in `vendor/iankov/control-panel-news/src/config.php`<br>
Don't change this file, just use it as an example of what options are configurable.