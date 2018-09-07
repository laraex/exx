$(document).ready(function () {       
// alert("test");


         $("#bankwire_usd_form").validate({
        errorClass: 'help-block',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("has-error");
        },
        errorPlacement: function(error, element) {
          $(element).closest('div').append(error);
        },
        rules: {             
              bank_name: {
                required: true                
            },
            swift_code: {
                required: true,
                validswiftcode: true,              
            },
            account_no: {
                required: true                
            },
            account_name: {
                required: true                
            },
            account_address: {
                required: true                
            }                   
        },
        messages: {          
            bank_name: {
                required: "Bank Name is required"              
            },
            swift_code: {
                required: "Swift Code is required",
                validswiftcode : "Enter valid swift code."             
            },
            account_no: {
                required: "Account Number is required"              
            },
            account_name: {
                required: "Account Name is required"              
            },
            account_address: {
                required: "Account Address is required"              
            }
        }
    }); 


              $("#bankwire_inr_form").validate({
        errorClass: 'help-block',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("has-error");
        },
        errorPlacement: function(error, element) {
          $(element).closest('div').append(error);
        },
        rules: {             
              bank_name: {
                required: true                
            },
            swift_code: {
                required: true,
                validswiftcode: true,              
            },
            account_no: {
                required: true                
            },
            account_name: {
                required: true                
            },
            account_address: {
                required: true                
            }                   
        },
        messages: {          
            bank_name: {
                required: "Bank Name is required"              
            },
            swift_code: {
                required: "Swift Code is required",
                validswiftcode : "Enter valid swift code."             
            },
            account_no: {
                required: "Account Number is required"              
            },
            account_name: {
                required: "Account Name is required"              
            },
            account_address: {
                required: "Account Address is required"              
            }
        }
    }); 
   

     $("#bankwire_euro_form").validate({
        errorClass: 'help-block',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("has-error");
        },
        errorPlacement: function(error, element) {
          $(element).closest('div').append(error);
        },
        rules: {             
              bank_name: {
                required: true                
            },
            swift_code: {
                required: true,
                validswiftcode: true,              
            },
            account_no: {
                required: true                
            },
            account_name: {
                required: true                
            },
            account_address: {
                required: true                
            }                   
        },
        messages: {          
            bank_name: {
                required: "Bank Name is required"              
            },
            swift_code: {
                required: "Swift Code is required",
                validswiftcode : "Enter valid swift code."             
            },
            account_no: {
                required: "Account Number is required"              
            },
            account_name: {
                required: "Account Name is required"              
            },
            account_address: {
                required: "Account Address is required"              
            }
        }
    }); 

          $("#bankwire_ngn_form").validate({
        errorClass: 'help-block',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("has-error");
        },
        errorPlacement: function(error, element) {
          $(element).closest('div').append(error);
        },
        rules: {             
              bank_name: {
                required: true                
            },
            swift_code: {
                required: true,
                validswiftcode: true,              
            },
            account_no: {
                required: true                
            },
            account_name: {
                required: true                
            },
            account_address: {
                required: true                
            }                   
        },
        messages: {          
            bank_name: {
                required: "Bank Name is required"              
            },
            swift_code: {
                required: "Swift Code is required",
                validswiftcode : "Enter valid swift code."             
            },
            account_no: {
                required: "Account Number is required"              
            },
            account_name: {
                required: "Account Name is required"              
            },
            account_address: {
                required: "Account Address is required"              
            }
        }
    }); 


    

    $("#bitcoin_form").validate({
        errorClass: 'help-block',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("has-error");
        },
        errorPlacement: function(error, element) {
          $(element).closest('div').append(error);
        },
        rules: {             
             coinname: {
                required: true
              },
            coincode: {
              required: true,
              bitcoinaddress: true,
            }              
        },
        messages: {          
            coinname: {
                required: "Name is required"              
            },
            coincode: {
                required: "Bitcoin address is required" ,
                bitcoinaddress: "Invalid bitcoin address",             
            }
        }
    });


});
