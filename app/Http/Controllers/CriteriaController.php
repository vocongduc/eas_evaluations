<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriteriaRequest;
use App\Models\Category;
use App\Models\MainPoint;
use Illuminate\Http\Request;
use App\Models\Criteria;
class CriteriaController extends Controller
{
    /**
     * list criterias
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $buider = Criteria::orderBy('id', 'asc');
        if (isset($request->search_criteria))
        {
            $buider->where('name', 'like', '%'.$request->search_criteria.'%');
        }
        $criterias = $buider->paginate(10);
        return view('criteria.index',compact('criterias'));
    }

    /**
     * create criteria
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $categories = Category::get();
        return view('criteria.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CriteriaRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CriteriaRequest $request){

        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
            $criterias = new Criteria();
            $criterias->category_id = $data['category_id'];
            $criterias->name = $data['name'];
            $criterias->point_max = $data['point_max'];
            $criterias->point_weight = $data['point_weight'];
            $criterias->description = $data['desc'];
            $criterias->save();
            return redirect('/criterias')->with('success','Thêm thành công ');
        }

    }

    /**
     * display
     * @param $id
     */
    public function show($id){

    }

    /**
     * eidt criteria
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $criteriaDetails = Criteria::where(['id'=>$id])->first();
        $categories = Category::get();
        return view('criteria.edit')->with(compact('criteriaDetails','categories'));
    }

    /**
     * update criteria
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        Criteria::where(['id' => $id])->update(['category_id' => $data['category_id'], 'name' => $data['name'], 'point_weight' => $data['point_weight'], 'point_max' => $data['point_max'], 'description' => $data['desc']]);
        return redirect()->route('criterias.index')->with('success', 'Cập nhật thành công ');
    }

    /**
     * delete crtiteria
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id=null ) {
        if(!empty($id)){
            Criteria::where(['id'=>$id])->delete();
            return redirect()->back()->with('success','Xoa thanh cong');
        }
    }

}
