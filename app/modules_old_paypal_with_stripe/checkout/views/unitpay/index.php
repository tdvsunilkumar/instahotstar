<script src = "https://widget.unitpay.money/unitpay.js" > </script> 
<script type = "text / javascript" > 
    this . pay = function () {  
        var payment = new UnitPay ();  
        payment . createWidget ({
            publicKey : "257411-f3e58" , 
            sum : 1 , 
            account : "demo" , 
            domainName : "unitpay.money" , 
            signature : "92bbd8dab31539e54f02a5031954c2772d97d6f3fac5a8ae0639ca8ab781b703" , 
            desc : "Payment Description" , 
            locale : "ru" , 
        });
        payment . success ( function ( params ) {  
            console . log ( 'Successful payment' );
        });
        payment . error ( function ( message , params ) {  
            console . log ( message );
        });
        return false ; 
    };
</script>