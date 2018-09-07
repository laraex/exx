<table class="table table-bordered table-striped dataTable"  id="currencypair">
    <thead>
        <tr>                
            <th>{{ trans('admin_usergroup.rules') }}</th>        
        </tr>
    </thead>
    <tbody>
        @if(count($rules)>0)
            <tr>
                <td>
                    {{ trans('admin_usergroup.rule1_reg') }} 

                    @if( $rules['register_rule']['period']=='after'):-{{ $rules['register_rule']['period'] }} <br>
                        After Date: {{ $rules['register_rule']['after_date'] }} <br>
                    @endif

                    @if( $rules['register_rule']['period']=='between'):-{{ $rules['register_rule']['period'] }} <br>
                        From Date: {{ $rules['register_rule']['from_date'] }} <br>
                        To Date: {{ $rules['register_rule']['to_date'] }}
                    @endif

                    @if( $rules['register_rule']['period']=='today'):-{{ $rules['register_rule']['period'] }} <br>
                        Register On: {{ $rules['register_rule']['register_date'] }} <br>
                    @endif
                </td>         
            </tr>

            <tr>
                <td>
                    {{ trans('admin_usergroup.rule2_country') }} <br>
                    @if($rules['country_rule']['country_val']=='5')
                        Country Name: {{ $member_rule->present()->getCountryName($rules['country_rule']['country']) }}<br>
                    @endif
                </td>         
            </tr>

            <tr>
                <td>
                    {{ trans('admin_usergroup.rule3_email') }} <br>
                    @if($rules['email_verified_rule']['email']=='6')
                        Yes
                    @else
                        No
                    @endif
                </td>         
            </tr>

            <tr>
                <td>
                    {{ trans('admin_usergroup.rule4_kyc') }} <br>
                    @if($rules['kyc_rule']['kyc_verified']=='2')
                        Yes
                    @else
                        No
                    @endif
                </td>         
            </tr>

            <tr>
                <td>
                    {{ trans('admin_usergroup.rule5_downline') }} <br>

                    @if( $rules['downline']['downline_level']=='above') 
                    {{ $rules['downline']['downline_level'] }} <br>
                        Downline Above: {{ $rules['downline']['downline_abovecount'] }} <br>
                    @endif

                    @if( $rules['downline']['downline_level']=='between')
                    {{ $rules['downline']['downline_level'] }} <br>
                        Downline from: {{ $rules['downline']['downline_fromcount'] }} <br>
                        Downline To: {{ $rules['downline']['downline_tocount'] }}
                    @endif
                </td>         
            </tr>
            
            <tr>
                <td>
                    {{ trans('admin_usergroup.rule6_wallet') }} <br>

                    {{ ucfirst($rules['wallet_rule']['condition']) }}
                        @if( $rules['wallet_rule']['amt_level']=='1') 
                            Above:<br>
                            Condition: {{ $rules['wallet_rule']['condition'] }}<br>
                            Currency:  {{ $member_rule->present()->getCurrencyTokenByID($rules['wallet_rule']['currency']) }}<br>
                            Wallet Amount: {{ $rules['wallet_rule']['amt'] }} <br>
                        @endif

                        @if( $rules['wallet_rule']['amt_level']=='2') 
                            Below:<br>
                            Condition: {{ $rules['wallet_rule']['condition'] }}<br>
                            Currency:  {{ $member_rule->present()->getCurrencyTokenByID($rules['wallet_rule']['currency']) }}<br>
                            Wallet Amount: {{ $rules['wallet_rule']['amt'] }} <br>
                        @endif

                        @if( $rules['wallet_rule']['amt_level']=='3') 
                            is Equal:<br>
                            Condition: {{ $rules['wallet_rule']['condition'] }}<br>
                            Currency:  {{ $member_rule->present()->getCurrencyTokenByID($rules['wallet_rule']['currency']) }}<br>
                            Wallet Amount: {{ $rules['wallet_rule']['amt'] }} <br>
                        @endif
                </td>         
            </tr>

            <tr>
                <td>
                    {{ trans('admin_usergroup.rule7_buycoin') }} <br>

                    @if($rules['buycoin']['level']=='above')
                        Above:<br>
                        Currency: {{ $member_rule->present()->getCurrencyTokenByID($rules['buycoin']['currency']) }}<br>
                        Amount: {{ $rules['buycoin']['buycoin_amt'] }}<br>
                    @endif

                    @if($rules['buycoin']['level']=='between')
                        Between:<br>
                        Currency: {{ $rules['buycoin']['currency'] }}<br>
                        From Amount: {{ $rules['buycoin']['from_amt'] }}<br>
                        To Amount: {{ $rules['buycoin']['to_amt'] }}
                    @endif
                </td>         
            </tr>

            <tr>
                <td>
                    {{ trans('admin_usergroup.rule8_status') }} <br>
                    @if($rules['status_rule']['status']=='1')
                        Yes
                    @else
                        No
                    @endif
                </td>         
            </tr>
        @endif
    </tbody>
</table>