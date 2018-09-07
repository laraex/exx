<?php

namespace App\Http\Controllers\Admin;

use App\CurrencyMaster;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Events\CreateCurrencyWallet;
use App\Http\Requests\CurrencyRequest as StoreRequest;
use App\Http\Requests\CurrencyRequest as UpdateRequest;
use App\Traits\CurrencyPairProcess;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Event;

class CurrencyCrudController extends CrudController
{
    use CurrencyPairProcess;
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */
        $this->crud->setModel('App\Models\Currency');
        $this->crud->setRoute("admin/currency");
        $this->crud->setEntityNameStrings('currency', 'currencies');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
         */

        // $this->crud->setFromDb();

        $image = [
            'name' => 'image',
            'label' => "Currency Image",
            'type' => 'browse',
            'upload' => true,
            'disk' => getenv('FILE_SYSTEM_DRIVER'),

        ];

        $this->crud->addField($image, 'update/both');

        $name = [
            'name' => 'name',
            'label' => "Name",
            'type' => 'text',
        ];

        $this->crud->addField($name, 'create');
        //  $this->crud->addColumn($name);

        $displayname = [
            'name' => 'displayname',
            'label' => "Display Name",
            'type' => 'text',
        ];

        $this->crud->addField($displayname, 'update/both');
        $this->crud->addColumn($displayname);

        $tokens = array();

        $token_list = CurrencyMaster::where('status', 'unused')->get();
        foreach ($token_list as $tokendetail) {

            $tokens[$tokendetail['symbol']] = $tokendetail['name'];
        }

        $token = [
            'name' => 'token',
            'label' => "Token",
            'type' => 'select2_from_array',
            'options' => $tokens,
            'allows_null' => false,
        ];

        $this->crud->addField($token, 'create');
        $this->crud->addColumn($token);
        $orderby = [
            'name' => 'order',
            'label' => "OrderBy",
            'type' => 'text',
        ];

        $this->crud->addField($orderby, 'update/both');
        $this->crud->addColumn($orderby);

        $status = [
            'name' => 'status',
            'label' => "Status",
            'type' => 'radio',
            'options' => ['0' => 'Inactive', '1' => 'Active'],
        ];

        $this->crud->addField($status, 'update/both');
        $this->crud->addColumn($status);

        $withdraw_min_amount = [
            'name' => 'withdraw_min_amount',
            'label' => "Withdraw Min Amound",
            'type' => 'text',
        ];

        $this->crud->addField($withdraw_min_amount, 'update/create/both');
        $this->crud->addColumn($withdraw_min_amount);

        $withdraw_max_amount = [
            'name' => 'withdraw_max_amount',
            'label' => "Withdraw Max Amount",
            'type' => 'text',
        ];

        $this->crud->addField($withdraw_max_amount, 'update/create/both');
        $this->crud->addColumn($withdraw_max_amount);

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

 
        $this->crud->allowAccess(['list',  'update']);
        $this->crud->denyAccess(['delete','create']);


        // ------ CRUD ACCESS

        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {

        // your additional operations before save here
        $redirect_location = parent::storeCrud();

        Event::fire(new CreateCurrencyWallet($this->crud->entry));

        $this->createCurrencyPair($this->crud->entry);

        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        $this->updateCurrencyPair($this->crud->entry);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
