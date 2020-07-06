<?php

namespace App\Http\Controllers;
use App\Http\Requests\MainpointRequest;
use App\Models\MainPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
class MainPointsController extends Controller
{
    /**
     * list mainpoint
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $buider = MainPoint::orderBy('id', 'asc');
        if (isset($request->search_mainpoint))
        {
            $buider->where('name', 'like', '%'.$request->search_mainpoint.'%');
        }
        $mainpoints =  $buider->paginate(5);
        return view('main_points.index')->with(compact('mainpoints'));
    }

    /**
     * create mainpoint
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('main_points.add');
    }

    /**
     * Store a newly created resource in storage.
     * @param MainpointRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(MainpointRequest $request){

        if($request->isMethod('post')){
            $data = $request->all();
            $mainpoint = new MainPoint();
            $mainpoint->name = $request['name'];
            $mainpoint->priority = $request['priority'];
            $mainpoint->total_point = $request['total_point'];
            $mainpoint->save();
            return redirect(route('mainpoints.index'))->with('success','Thêm Main Point thành công ');
        }else{
            return redirect(route('mainpoints.index'))->with('success','Thêm thất bại vui lòng thử lại');
        }
    }

    /**
     * @param $id
     */
    public function show($id) {

    }

    /**
     * edit
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $mainpointDetails = MainPoint::where(['id'=>$id])->first();
        return view('main_points.edit')->with(compact('mainpointDetails'));
    }

    /**
     * update mainpoint
     * @param MainpointRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(MainpointRequest $request, $id){
            $data = $request->all();
            MainPoint::where(['id'=>$id])->update(['name'=>$data['name'],'priority'=>$data['priority'],'total_point'=>$data['total_point']]);
            return redirect()->route('mainpoints.index')->with('success','Cập nhật thành công');
    }

    /**
     * delete mainpoint
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){

        if(!empty($id)){
            MainPoint::where(['id'=>$id])->delete();
            return redirect()->back()->with('success','Xóa thành công');
        }
    }
}
