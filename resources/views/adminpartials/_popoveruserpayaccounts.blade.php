<?php
        if ($data->userpayaccounts->paymentgateways_id > 1)
          {
                $datacontent = 'Bank Name : ' .$data->userpayaccounts->param1.'<br/>';  
                $datacontent .= 'Swift Code : ' .$data->userpayaccounts->param2.'<br/>';  
                $datacontent .= 'Account Number : ' .$data->userpayaccounts->param3.'<br/>';  
                $datacontent .= 'Account Name : ' .$data->userpayaccounts->param4.'<br/>';  
                $datacontent .= 'Account Address : ' .$data->userpayaccounts->param5.'<br/>';
          ?>
                <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span> 
          <?php                  
          }         
                    
          
          elseif ($data->userpayaccounts->paymentgateways_id == 1)
          {
                $datacontent = 'Coin Name : ' .$data->userpayaccounts->param1;  
                $datacontent .= 'BTC Code : ' .$data->userpayaccounts->param2;
          ?>
              <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span> 
          <?php                                
          }          
         
           
    ?>        