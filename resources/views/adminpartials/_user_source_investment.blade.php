<div class="tab-container">
	<div class="row">
	<div class="col-md-12">
		<h4>{{ trans('admin_user.source_investment') }} </h4>
		</div>
		
		@include('partials.message')
	</div>
	<div class="row">
		<div class="col-md-10 p-20">
			<table class="table">
			
				<tr>
					<td>{{ trans('admin_user.emp_status') }}</td>
					<td>{{ $user_information->status }} </td>
				</tr>
                <tr>
                    <td>{{ trans('admin_user.job_title') }}</td>
                    <td>{{ $user_information->title }} </td>
                </tr>
				 <tr>
                    <td>{{ trans('admin_user.emp_name') }}</td>
                    <td>{{ $user_information->name }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.emp_state') }}</td>
                    <td>{{ $user_information->state }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.emp_district') }}</td>
                    <td>{{ $user_information->district }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.emp_street') }}</td>
                    <td>{{ $user_information->street }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.source_fund') }}</td>
                    <td>{{ $user_information->source }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.net_worth') }}</td>
                    <td>{{ $user_information->net_amount }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.industry') }} </td>
                    <td>{{ $user_information->industry }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.emp_country') }}</td>
                    <td>
                      @if(count($user_information->empcountry)>0)
                        {{ $user_information->empcountry->name }}
                      @endif 
                    </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.emp_city') }}</td>
                    <td>{{ $user_information->city }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.house_name') }}</td>
                    <td>{{ $user_information->number }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.zipcode') }}</td>
                    <td>{{ $user_information->zip }} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.investment') }}</td>
                    <td>{{ $user_information->investment }} </td>
                </tr>
                
                 <tr>
                    <td>{{ trans('admin_user.stock_market') }}</td>
                    <td>{{ $user_information->q1}} </td>
                </tr>
                 <tr>
                    <td>{{ trans('admin_user.experience_equilities') }}</td>
                    <td>{{ $user_information->q2 }} </td>
                </tr>
                  <tr>
                    <td>{{ trans('admin_user.experience_derivative') }}</td>
                    <td>{{ $user_information->q3 }} </td>
                </tr>
                  <tr>
                    <td>{{ trans('admin_user.derivative_work') }}</td>
                    <td>{{ $user_information->q4 }} </td>
                </tr>
                  <tr>
                    <td>{{ trans('admin_user.risk_trading') }}</td>
                    <td>{{ $user_information->q5 }} </td>
                </tr>
			</table>
		</div>



        
	</div>
	</div>

