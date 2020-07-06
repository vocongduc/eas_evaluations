<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MainPoint;
class CategoryController extends Controller
{
    protected $cate;
    protected $mainpoint;

    public function __construct(Category $cate, MainPoint $mainpoint)
    {
        $this->cate = $cate;
        $this->mainpoint = $mainpoint;
    }

    /**
     * list category
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $buider = Category::orderBy('id', 'asc');
        if (isset($request->search_cate))
        {
            $buider->where('name', 'like', '%'.$request->search_cate.'%');
        }
        $categories = $buider->with('mainPoint')->paginate(10);
        return view('category.index',compact('categories'));
    }

    /**
     * create category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $mainpoints = MainPoint::get();
        return view('category.add',compact('mainpoints'));
    }

    /**
     *Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request){
        $mainpoints = MainPoint::get();
        if($request->isMethod('post')){
            $data = $request->all();
            $category = new Category();
            $category->main_point_id = $request['main_point_id'];
            $category->name = $request['name'];
            $category->priority =$request['priority'];
            $category->save();
            return redirect()->route('categories.index')->with('success','Thêm thành công');
        }
    }

    /**
     * @param $id
     */
    public function show($id){

    }

    /**
     * edit category
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $cateDetails = Category::where(['id'=>$id])->first();
        $levels = MainPoint::get();
        return view('category.edit')->with(compact('cateDetails','levels'));
    }

    /**
     * update catgory
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CategoryRequest $request, $id=null){
            $data = $request->all();
            Category::where(['id'=>$id])->update(['main_point_id'=>$data['main_point_id'],'name'=>$data['name'],'priority'=>$data['priority']]);
            return redirect('/categories')->with('success','Cập nhật thành công');
    }

    /**
     * delete category
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id=null){
        if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('success','Xóa thành công');
        }
    }
}
