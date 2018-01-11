<?php

namespace Iankov\ControlPanelNews\Controllers\Control;

use Iankov\ControlPanelNews\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsCategoryController extends Controller
{
    public function __construct()
    {
        $this->category = config('icp.modules.news.models.category');
    }

    public function index()
    {
        return view('icp-news::category.index');
    }

    public function jsonIndex()
    {
        return Datatables::of($this->category::select('id', 'active', 'title', 'slug', 'updated_at'))
            ->editColumn('updated_at', function($item){
                return $item->updated_at->format('d M Y, H:i:s');
            })
            ->editColumn('active', function ($item) {
                return view('icp::forms.active', [
                    'active' => $item->active,
                    'action' => icp_route('news.category.active.toggle', $item->id),
                ]);
            })
            ->addColumn('actions', function($item){
                return
                    view('icp::forms.buttons.edit', ['action' => icp_route('news.category.edit', $item->id)]).'&nbsp;'.
                    view('icp::forms.buttons.delete', ['action' => icp_route('news.category.delete', $item->id)]);
            })
            ->addColumn('checkbox', function($item){
                return '<input type="checkbox" name="ids[]" value="'.$item->id.'">';
            })
            ->rawColumns(['active', 'actions', 'checkbox'])
            ->with(['csrf_token' => csrf_token()])
            ->make(true);
    }

    public function edit($id)
    {
        return view('icp-news::category.edit', [
            'category' => $this->category::find($id)
        ]);
    }

    public function create()
    {
        return view('icp-news::category.create', [
            'category' => new $this->category()
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
            'slug' => 'unique:news_categories,slug,'.$id
        ]);

        $all = $request->all();
        if(empty($all['slug'])) {
            $all['slug'] = $this->category::generateUniqueSlug($all['title']);
        }
        $all['active'] = empty($all['active']) ? 0 : 1;

        if($id) {
            $this->category::find($id)->fill($all)->save();
        }else{
            $this->category::create($all);
        }

        return redirect(icp_route('news.categories'));
    }

    public function toggleActive($id)
    {
        $category = $this->category::find($id);
        if($category){
            $category->active = $category->active ? 0 : 1;
            $category->save();
        }

        return response()->json();
    }

    public function delete($id = null)
    {
        $ids = request()->input('ids');
        $ids = is_array($ids) ? $ids : [$id];

        $this->category::whereIn('id', $ids)->delete();

        return response()->json();
    }
}