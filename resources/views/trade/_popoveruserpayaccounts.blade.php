<?php
        if ($withdraw->userpayaccounts->paymentgateways_id > 1)
          {
                $datacontent = 'Bank Name : ' .$withdraw->userpayaccounts->param1.'<br/>';  
                $datacontent .= 'Swift Code : ' .$withdraw->userpayaccounts->param2.'<br/>';  
                $datacontent .= 'Account Number : ' .$withdraw->userpayaccounts->param3.'<br/>';  
                $datacontent .= 'Account Name : ' .$withdraw->userpayaccounts->param4.'<br/>';  
                $datacontent .= 'Account Address : ' .$withdraw->userpayaccounts->param5.'<br/>';
          ?>
                <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $withdraw->userpayaccounts->payment->displayname }}</span> 
          <?php                  
          }         
                    
          
          elseif ($withdraw->userpayaccounts->paymentgateways_id == 1)
          {
                $datacontent = 'Coin Name : ' .$withdraw->userpayaccounts->param1;  
                $datacontent .= 'BTC Code : ' .$withdraw->userpayaccounts->param2;
          ?>
              <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $withdraw->userpayaccounts->payment->displayname }}</span> 
          <?php                                
          }          
         
           
    ?>        