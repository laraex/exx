<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PaymentgatewayRequest as StoreRequest;
use App\Http\Requests\PaymentgatewayRequest as UpdateRequest;

class PaymentgatewayCrudController extends CrudController
{
  
    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Paymentgateway");
        $this->crud->setRoute("admin/paymentgateway");
        $this->crud->setEntityNameStrings('paymentgateway', 'paymentgateways');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

        //$this->crud->setFromDb();

         $name = [
                'name' => 'gatewayname',
                'label' => "Name",
                'type' => 'text',
        ];
        $this->crud->addField($name, 'update/create/both');
        $this->crud->addColumn($name);

         $displayname = [
                'name' => 'displayname',
                'label' => "Display Name",
                'type' => 'text',
        ];
        $this->crud->addField($displayname, 'update/create/both');
        $this->crud->addColumn($displayname);

        $status = [
                'name' => 'active',
                'label' => "Status",
                'type' => 'radio',
                'options' => ['0' => 'Inactive', '1' => 'Active'],
        ];
        $this->crud->addField($status, 'update/create/both');
        $this->crud->addColumn($status);


        $withdraw = [
                'name' => 'withdraw',
                'label' => "Withdraw",
                'type' => 'radio',
                'options' => ['0' => 'Disable', '1' => 'Enable'],
        ];
        $this->crud->addField($withdraw, 'update/create/both');
        $this->crud->addColumn($withdraw);        

        $withdraw_commission = [
                'name' => 'withdraw_commission',
                'label' => "Withdraw Commission (%)",
                'type' => 'text',
        ];
        $this->crud->addField($withdraw_commission, 'update/create/both');
        $this->crud->addColumn($withdraw_commission);

        $exchange = [
                'name' => 'exchange',
                'label' => "Exchange",
                'type' => 'radio',
                'options' => ['0' => 'Disable', '1' => 'Enable'],
        ];
        $this->crud->addField($exchange, 'update/create/both');
        $this->crud->addColumn($exchange);

         $params = [
                'name' => 'params',
                'label' => "Details (Please fill the valid details)",
                'type' => 'textarea',
        ];
        $this->crud->addField($params, 'update/create/both');
        //$this->crud->addColumn($params);

        $instructions = [
                'name' => 'instructions',
                'label' => "Instructions",
                'type' => 'textarea',
        ];
        $this->crud->addField($instructions, 'update/create/both');
        $currency_id = [
                'name' => 'currency_id',
                'label' => "Currency IDs ( Given by comma separated )",
                'type' => 'textarea',
        ];
        $this->crud->addField($currency_id, 'update/create/both');

         $crypto_withdraw_fee = [
                'name' => 'crypto_withdraw_fee',
                'label' => "Crypto Withdraw Fee (%)",
                'type' => 'text',
        ];
        $this->crud->addField($crypto_withdraw_fee, 'update/create/both');
        $this->crud->addColumn($crypto_withdraw_fee);

         $crypto_withdraw_base_fee = [
                'name' => 'crypto_withdraw_base_fee',
                'label' => "Crypto Withdraw Base Fee (Flat)",
                'type' => 'text',
        ];
        $this->crud->addField($crypto_withdraw_base_fee, 'update/create/both');
        $this->crud->addColumn($crypto_withdraw_base_fee);
        //$this->crud->addColumn($instructions);


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

        // ------ CRUD ACCESS
        $this->crud->allowAccess(['list',  'update']);
        $this->crud->denyAccess(['create', 'delete']);

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
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
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
		// your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
	}
}
