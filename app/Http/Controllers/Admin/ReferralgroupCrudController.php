<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ReferralgroupRequest as StoreRequest;
use App\Http\Requests\ReferralgroupRequest as UpdateRequest;
use App\Models\Referralgroup;

class ReferralgroupCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Referralgroup');
        $this->crud->setRoute("admin/referralgroups");
        $this->crud->setEntityNameStrings('referralgroup', 'referralgroups');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();

        $name = [
                'name' => 'name',
                'label' => "Name",
                'type' => 'text',
        ];

        $this->crud->addField($name, 'update/create/both');
        $this->crud->addColumn($name);

        $referral_commission = [
                'name' => 'referral_commission',
                'label' => "Commission Value (%)",
                'type' => 'number',
        ];

        $this->crud->addField($referral_commission, 'update/create/both');
        $this->crud->addColumn($referral_commission);

        $active = [
                'name' => 'active',
                'label' => "Active",
                'type' => 'radio',
                'options' => ['0' => 'Inactive', '1' => 'Active'],
        ];

        $this->crud->addField($active, 'update/create/both');
        $this->crud->addColumn($active);

         $Default = [
                'name' => 'is_default',
                'label' => "Default",
                'type' => 'radio',
                'options' => ['0' => 'No', '1' => 'Yes'],
        ];

        $this->crud->addField($Default, 'update/create/both');
        $this->crud->addColumn($Default);

        $level_commission = [
                'name' => 'level_commission',
                'label' => "Level Commission Values (%)",
                'type' => 'table',
                'entity_singular' => 'level commission', // used on the "Add X" button
                'columns' => [
                    'level' => 'Level Number',
                    'commission_value' => 'Commission',
                ],
                'max' => 99, // maximum rows allowed in the table
                'min' => 0 // minimum rows allowed in the table
        ];

        $this->crud->addField($level_commission, 'update/create/both');
        $this->crud->addColumn($level_commission);

    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // dd($request);
        // your additional operations before save here
       // $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        if($request->is_default == 1)
        {
            $referralgroups = Referralgroup::get();
            foreach($referralgroups as $referralgroup)
            {          
                $referralgroup = Referralgroup::where('id', $referralgroup->id )->first();
                $referralgroup->is_default = '0';
                $referralgroup->save();                                  
            }
        }        

        $referralgroup = Referralgroup::where('id', $request->id)->first();
        $referralgroup->name = $request->name;
        $referralgroup->level_commission = $request->level_commission;
        $referralgroup->referral_commission = $request->referral_commission;
        $referralgroup->active = $request->active;
        $referralgroup->is_default = $request->is_default;

        if ($referralgroup->save())
        {
             \Alert::success('Referral Group Updated Successfully')->flash();
        }
         return redirect(url('superadmin/referralgroups')); 


        // return $redirect_location;
    }
}
