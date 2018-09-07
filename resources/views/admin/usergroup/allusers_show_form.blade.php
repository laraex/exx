<table class="table table-bordered table-striped dataTable"  id="currencypair">
    <thead>
        <tr>                
            <th>{{ trans('admin_usergroup.name') }}</th>        
        </tr>
    </thead>
    <tbody>
        @if(count($allusers->membergrouplink)>0)
            @foreach($allusers->membergrouplink as $users)
                <tr>
                    <td>{{ optional($users->user)->name }}</td>                   
                </tr>
            @endforeach
        @endif
    </tbody>
</table>