<?php

namespace Iankov\ControlPanelNews\Controllers\Control;

use Iankov\ControlPanelNews\Models\News;
use Iankov\ControlPanelNews\Models\NewsCategory;
use Iankov\ControlPanelNews\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    public function index()
    {
        return view('icp-news::index', [
            'categories' => NewsCategory::all()
        ]);
    }

    public function jsonIndex(Request $request)
    {
        $news = News::select(['id', 'category_id', 'image', 'title', 'slug', 'views', 'created_at', 'active'])->with('category');

        return Datatables::of($news)
            ->filter(function ($query) use ($request) {
                $active = $request->input('filter.active');
                if (!is_null($active) && in_array($active, [0,1])) {
                    $query->where('active', $active);
                }

                $categoryId = $request->input('filter.category_id');
                if (!is_null($categoryId) && $categoryId >= 0) {
                    $query->where('category_id', $categoryId);
                }

                $title = $request->input('filter.title');
                if($title){
                    $query->where('title', 'LIKE', '%'.$title.'%');
                }

                $slug = $request->input('filter.slug');
                if($slug){
                    $query->where('slug', 'LIKE', '%'.$slug.'%');
                }
            })
            ->editColumn('active', function ($item) {
                return view('icp::forms.active', [
                    'active' => $item->active,
                    'action' => icp_route('news.active.toggle', $item->id),
                ]);
            })
            ->addColumn('actions', function($item){
                return
                    view('icp::forms.buttons.edit', ['action' => icp_route('news.edit', $item->id)]).'&nbsp;'.
                    view('icp::forms.buttons.delete', ['action' => icp_route('news.delete', $item->id)]);
            })
            ->addColumn('category', function($item){
                return $item->category ? $item->category->title : ' - ';
            })
            ->addColumn('checkbox', function($item){
                return '<input type="checkbox" name="ids[]" value="'.$item->id.'">';
            })
            ->rawColumns(['active', 'actions', 'checkbox'])
            ->with(['csrf_token' => csrf_token()])
            ->make(true);
    }

    public function view($id)
    {
        return view('icp-news::view', [
            'article' => News::find($id)
        ]);
    }

    public function edit($id)
    {
        return view('icp-news::edit', [
            'article' => News::find($id),
            'categories' => NewsCategory::all()
        ]);
    }

    public function create()
    {
        return view('icp-news::create', [
            'article' => new News(),
            'categories' => NewsCategory::all()
        ]);
    }

    public function store(Request $request)
    {
        return $this->update($request, 0);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'slug' => 'unique:news,slug,'.$id
        ]);
        $all = $request->all();
        if(empty($all['slug'])) {
            $all['slug'] = News::generateUniqueSlug($all['title']);
        }
        $all['active'] = empty($all['active']) ? 0 : 1;
        if(empty($all['created_at'])){
            $all['created_at'] = null;
        }

        if($id) {
            News::find($id)->fill($all)->save();
        }else{
            $article = News::create($all);
            $id = $article->id;
        }

        if($all['submit_type'] == 1)
            return redirect(icp_route('news.edit', ['id' => $id]));

        return redirect(icp_route('news'));
    }

    public function toggleActive($id)
    {
        $news = News::find($id);
        if($news){
            $news->active = $news->active ? 0 : 1;
            $news->save();
        }

        return response()->json();
    }

    public function delete($id = null)
    {
        $ids = request()->input('ids');
        $ids = is_array($ids) ? $ids : [$id];

        News::whereIn('id', $ids)->delete();

        return response()->json();
    }

}