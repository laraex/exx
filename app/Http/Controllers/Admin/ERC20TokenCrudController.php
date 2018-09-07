<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ERC20TokenRequest as StoreRequest;
use App\Http\Requests\ERC20TokenRequest as UpdateRequest;
use App\Traits\ERC20TokenProcess;
class ERC20TokenCrudController extends CrudController
{
         use ERC20TokenProcess;
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\ERC20Token');
        $this->crud->setRoute('admin/erc20token');
        $this->crud->setEntityNameStrings('erc20token', 'erc20tokens');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        // $this->crud->setFromDb();

        $token_name = [
                'name' => 'token_name',
                'label' => "Token Name",
                'type' => 'text',
        ];

        $this->crud->addField($token_name, 'update/create/both');
        $this->crud->addColumn($token_name);

        $token_symbol = [
                'name' => 'token_symbol',
                'label' => "Token Symbol",
                'type' => 'text'
        ];

        $this->crud->addField($token_symbol, 'create');
        $this->crud->addColumn($token_symbol);

        $decimal = [
                'name' => 'decimal',
                'label' => "Token Decimal",
                'type' => 'number'
        ];

        $this->crud->addField($decimal, 'create');
        $this->crud->addColumn($decimal);
        $token_image = [
                'name' => 'token_image',
                'label' => "Token Image",
                'type' => 'browse',
        ];

        $this->crud->addField($token_image, 'update/create/both');
        $this->crud->addColumn($token_image);

        $token_contract_address = [
                'name' => 'token_contract_address',
                'label' => "Token Contract Address",
                'type' => 'text'
        ];

        $this->crud->addField($token_contract_address, 'create');
        $this->crud->addColumn($token_contract_address);

        $status = [
                'name' => 'active',
                'label' => "Status",
                'type' => 'radio',
                'options' => ['0' => 'Inactive', '1' => 'Active'],
        ];

        $this->crud->addField($status, 'update/create/both');
        $this->crud->addColumn($status);

          $mode = [
                'name' => 'mode',
                'label' => "Mode",
                'type' => 'radio',
                'options' => ['live' => 'Live', 'testnet' => 'Testnet'],
        ];

        $this->crud->addField($mode, 'update/create/both');
        $this->crud->addColumn($mode);

        $eth_address = [
                'name' => 'eth_address',
                'label' => "ETH Address",
                'type' => 'text',
               
        ];

        $this->crud->addField($eth_address, 'update/create/both');
        $this->crud->addColumn($eth_address);


         $eth_passphrase = [
                'name' => 'eth_passphrase',
                'label' => "ETH Pass Phrase",
                'type' => 'text',
               
        ];

        $this->crud->addField($eth_passphrase, 'update/create/both');
       

        $contract_abi = [
                'name' => 'contract_abi',
                'label' => "Contract ABI",
                'type' => 'text',
               
        ];

        $this->crud->addField($contract_abi, 'update/create/both');
      
       

       
        $buy_min_amount = [
                'name' => 'buy_min_amount',
                'label' => "Buy Min Amount",
                'type' => 'text',
               
        ];

        $this->crud->addField($buy_min_amount, 'update/create/both');
        $this->crud->addColumn($buy_min_amount);

        $buy_max_amount = [
                'name' => 'buy_max_amount',
                'label' => "Buy Max Amount",
                'type' => 'text',
               
        ];

        $this->crud->addField($buy_max_amount, 'update/create/both');
        $this->crud->addColumn($buy_max_amount);

        $this->crud->denyAccess(['delete']);

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
        $this->createERC20Token($this->crud->entry);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        $this->updateERC20Token($this->crud->entry);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
