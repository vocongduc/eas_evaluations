<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';
    protected $fillable = ['id', 'name', 'description'];
    protected $perPage = 10;


        /**
         * The criteria that belong to the form.
         */

    public function criteria() {
        return $this->belongsToMany(Criteria::class, FormCriteria::class);
    }

    /**
     * The users that belong to the form.
     */
    public function users(){
        return $this->belongsToMany(User::class, UserForm::class, 'user_id', 'form_id');
    }

    /**
     * Get the formCriteria record associated with the Form.
     */
    public function formCriteria(){
        return $this->hasMany(FormCriteria::class);
    }

    /**
     * Get the formPermit record associated with the Form.
     */
    public function formPermit(){
        return $this->hasMany(FormPermit::class);
    }

    /**
     * Get the teamForms record associated with the Form.
     */
    public function teamForms() {
        return$this->hasMany(TeamForm::class, 'form_id', 'id');
    }

    /**
     * function get list and search form
     *
     * @return Colection
     */
    public function getListForms($input)
    {
        $builder = Form::orderBy('id');
        if (isset($input['searchName'])) {
            $builder->where('name', 'like', '%' . $input['searchName'] . '%');
        }
        return $builder->paginate();
    }

    /**
     * Insert Form and Insert FormCriterias
     *
     * @param array $input
     * @return \App\Models\Form
     */
    public function insertForm($input)
    {
        $form = Form::create($input);

        $listCriteriaId = explode(',', $input['criteria_id']);
        foreach ($listCriteriaId as $k=>$v)
        {
            $data['form_id'] = $form->id;
            $data['criteria_id'] = $v;

            FormCriteria::create($data);
        }
        return $listCriteriaId;
    }

    /**
     * get data a Form to id
     *
     * @param int $id
     * @return \App\Models\Form
     */
    public function getForm($id)
    {
        return Form::findOrFail($id);
    }

    /**
     * Update Form and Update FormCriterias
     *
     * @param array $input
     * @param int $id
     * @return boolean
     */
    public function updateForm($input, $id)
    {
        $form = Form::findOrFail($id);
        $formCriterias = FormCriteria::where('form_id', '=', $form->id)->get();
        foreach ($formCriterias as $item) {
            $item->delete();
        }
        $listCriteriaId = explode(',', $input['criteria_id']);

        foreach ($listCriteriaId as $k=>$v)
        {
            $data['form_id'] = $form->id;
            $data['criteria_id'] = $v;

            FormCriteria::create($data);
        }
        return $form->update($input);
    }

    /**
     * function delete a form and Delete FormCriterias
     *
     * @param $id
     * @return boolean
     */
    public function destroyForm($id)
    {
        $form =  Form::findOrFail($id);
        $formCriterias = FormCriteria::where('form_id', '=', $form->id)->get();
        foreach ($formCriterias as $item) {
            $item->delete();
        }
        if (isset($form)) {
            $deleteForm = $form->delete();
        }
        return isset($deleteForm);
    }

    /**
     * function get form Criteria
     *
     * @param int $id
     * @return boolean
     */
    public function getFormCriterias($id)
    {
        $form = Form::with('criteria.category.mainPoint')->where('id', '=', $id)->first();
        $mainPoints = [];
        if (!empty($form)) {
            foreach ($form->criteria as $criterion) {
                if (!empty($criterion)) {
                    $mainPoints[$criterion->category->mainPoint->id]['name'] = $criterion->category->mainPoint->name;
                    $mainPoints[$criterion->category->mainPoint->id]['categories'][$criterion->category->id]['name'] = $criterion->category->name;
                    $mainPoints[$criterion->category->mainPoint->id]['categories'][$criterion->category->id]['criterias'][] = $criterion;
                }

            }
        } else {
            return $form;
        }
        return $mainPoints;
    }
}
