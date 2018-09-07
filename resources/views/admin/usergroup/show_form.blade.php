<table class="table table-bordered table-striped dataTable"  id="currencypair">
    <thead>
        <tr>                
            <th>{{ trans('admin_usergroup.usergroup_name') }}</th>
            <th>{{ trans('admin_usergroup.total_user') }}</th>
            <th>{{ trans('admin_usergroup.action') }}</th>                     
        </tr>
    </thead>
    <tbody>
        @if(count($membergroup)>0)
            @foreach($membergroup as $member)
                {{-- @php 
                    $request = json_decode($member['request'], true); 
                @endphp--}}

                <tr>
                    <td>{{ $member->usergroup_name }}</td>
                    <td>7</td>
                    <td>
                        <a href="{{ url('admin/usergroup/edit/'.$member->id) }}"><i class="fa fa-pencil"></i></a>
                        
                        <a href="{{ url('admin/usergroup/allusers/'.$member->id) }}"><i class="fa fa-users"></i></a>
                        
                        <a href="{{ url('admin/usergroup/rules/'.$member->id) }}">view rules</a>

                        <a href="{{ url('admin/usergroup/delete/'.$member->id ) }}" id="delete" >delete</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
    {{ $membergroup->links() }}

@push('datescripts')
    <script type="text/javascript">
        function deletemember(id)
        {
            if(confirm("Do you want to delete?"))
            {
                var p_url = "{{ url('admin/usergroup/delete/') }}";
                jQuery.ajax({
                    type: "GET",
                    url: p_url,
                    data: "id="+id,
                    success: function(data) 
                    {
                        window.location.reload();
                    }
                });
            }
        }
    </script>
@endpush