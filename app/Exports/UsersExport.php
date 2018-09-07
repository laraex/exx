<?php

namespace App\Exports;

use App\User;
use App\Models\Faq;

use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
	
    public function collection()
    {
        return Faq::all();
        //User::all());
    }
}
?>