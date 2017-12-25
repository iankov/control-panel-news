<?php

namespace Iankov\ControlPanelNews\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Redis;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['category_id', 'content', 'title', 'slug', 'keywords', 'description', 'import_id', 'image', 'source', 'active', 'created_at'];

    const VIEWS_CACHE_KEY = 'news-views-counter';

    public function category()
    {
        return $this->belongsTo('Iankov\ControlPanelNews\Models\NewsCategory', 'category_id');
    }

    public static function generateUniqueSlug($title)
    {
        $slug = str_slug($title);
        if(self::where('slug', $slug)->count()) {
            $slugs = self::select('slug')->where('slug', 'like', $slug . '%')->get()->pluck('slug')->toArray();
            $tail = 2;
            while (in_array($slug . '-' . $tail, $slugs)) {
                $tail++;
            }
            $slug .= '-' . $tail;
        }

        return $slug;
    }

    public function incViews($by = 1)
    {
        Redis::hIncrBy(self::VIEWS_CACHE_KEY, $this->id, $by);
    }

    public function getViewsAttribute($value)
    {
        return 100;
        return $value + (int)Redis::hGet(News::VIEWS_CACHE_KEY, $this->id);
    }
}