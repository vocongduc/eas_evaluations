<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormCriteriaRequest;
use App\Models\Form;
use App\Models\FormCriteria;
use App\Models\FormPermit;
use App\Models\MainPoint;
use Illuminate\Http\Request;

class FormController extends Controller
{
    protected $form;
    protected $mainpoint;
    protected $formCriteria;
    protected $formPermit;
    protected $user;

    /**
     * Create a new controller instance
     *
     * @param Form $form
     * @param MainPoint $mainpoint
     * @param FormCriteria $formCriteria
     * @param FormPermit $formPermit
     * @return void
     */
    public function __construct(Form $form, MainPoint $mainpoint, FormCriteria $formCriteria, FormPermit $formPermit)
    {
        $this->form = $form;
        $this->mainpoint = $mainpoint;
        $this->formCriteria = $formCriteria;
        $this->formPermit = $formPermit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $forms = $this->form->getListForms($request->all());
        return view('forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainpoints = $this->mainpoint->getListMaintPoint();
        return view('forms.create', compact('mainpoints'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\FormCriteriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormCriteriaRequest $request)
    {
        try {
            $this->form->insertForm($request->all());

            flash("Form <span style='color: darkblue; font-weight: bold'>$request->name</span> đã được thêm thành công.")->success();
        } catch (\Exception $e) {
            \Log::error($e);
            flash("Thêm Form <span style='color: darkblue; font-weight: bold'>$request->name</span> thất bại. Vui lòng thử lại.")->error();
        }
        return redirect()->route('forms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $count = 1;
        $formPermit = $this->formPermit->getUserFormPermit($id);
        $forms = $this->form->getFormCriterias($id);
       return view('forms.show', compact('forms', 'count', 'formPermit'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = $this->form->getForm($id);
        $mainpoints = $this->mainpoint->getListMaintPoint();
        $formCriteras = $this->formCriteria->getListCriteriasFom($id);
        $arrCriteriasForm = [];
        foreach ($formCriteras as $item) {
            $arrCriteriasForm[] =  $item->criteria_id;
        }
        $arrCriteriasForm = json_encode($arrCriteriasForm);
        $arrCriteriasForm = trim($arrCriteriasForm,'[]');

        return view('forms.edit', compact( 'form', 'mainpoints', 'arrCriteriasForm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\FormCriteriaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormCriteriaRequest $request, $id)
    {
        try {
            $this->form->updateForm($request->all(), $id);

            flash("Form <span style='color: darkblue; font-weight: bold'>$request->name</span> đã được cập nhật thành công.")->success();
        } catch (\Exception $e) {
            \Log::error($e);
            flash("Cập nhật Form <span style='color: darkblue; font-weight: bold'>$request->name</span> thất bại. Vui lòng thử lại.")->error();
        }
        return redirect()->route('forms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkform = $this->form->destroyForm($id);

        if ($checkform) {
            flash('Form đã được xóa thành công.')->success();
        } else {
            flash('Xóa Form thất bại. Vui lòng thử lại.')->error();
        }

        return redirect()->back();
    }
}
