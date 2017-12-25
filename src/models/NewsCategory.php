<?php

namespace Iankov\ControlPanelNews\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';
    protected $fillable = ['parent_id', 'title', 'keywords', 'description', 'slug', 'active'];

    public function articles()
    {
        return $this->hasMany('App\News', 'category_id');
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
}