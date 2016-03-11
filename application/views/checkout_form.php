<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>To checkout Testing in CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	.block{
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script>

	// set  the amount value
	
	function setVal(val,docid){ // alert(val+'id'+ docid +'get val'+ document.getElementById(docid).value);
	var amount= $('#amount').val();
	if(document.getElementById(docid).value!='' && amount<4)
	{
		
		var sum = parseInt(val) + parseInt(amount);
			$('#amount').val(sum);
			
	}else if(amount<=4) {
		$('#amount').val(amount-1);
		
	}
	
	}
	//end block
    // Called when token created successfully.
    var successCallback = function(data) {
        var myForm = document.getElementById('myCCForm');

        // Set the token as the value for the token input
        myForm.token.value = data.response.token.token;

        // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
        myForm.submit();
    };

    // Called when token creation fails.
    var errorCallback = function(data) {
        if (data.errorCode === 200) {
            tokenRequest();
        } else {
            alert(data.errorMsg);
        }
    };

    var tokenRequest = function() {
        // Setup token request arguments
        var args = {
            sellerId: "901307958",
            publishableKey: "42D982D1-3973-42FC-BD9D-831499A344D1",
            ccNo: $("#ccNo").val(),
            cvv: $("#cvv").val(),
            expMonth: $("#expMonth").val(),
            expYear: $("#expYear").val()
        };
		
        // Make the token request
        TCO.requestToken(successCallback, errorCallback, args);
    };

    $(function() {
        // Pull in the public encryption key for our environment
        TCO.loadPubKey('sandbox');

        $("#myCCForm").submit(function(e) {
            // Call our token request function
            tokenRequest();

            // Prevent form from submitting
            return false;
        });
    });
</script>

</head>
<body>

<div id="container">
	<h1>Tocheckout in CodeIgniter!</h1>

	<div id="body">
    <form id="myCCForm" action="http://localhost/ci3/checkout/successCheckout" enctype="multipart/form-data"  method="post">

<table width="100%" cellpadding="0" cellspacing="0">		
<tr><td width="50%">

<h5>Makers</h5>

<input type="text" name="makers" id="makers" value="" size="50" onChange="setVal(1,'makers')" />


<h5>Model</h5>
<input type="text" name="models" id="models" value="" size="50" onChange="setVal(1,'models')" />

<h5>Years</h5>
<input type="text" name="years" id="years" onChange="setVal(1,'years')" size="4">


<h5>Auto Conditions</h5>
<input type="text" name="autoConditions" id="autoConditions" value="" size="50" onChange="setVal(1,'autoConditions')" />
<div> &amp;</div>
<td width="50%">
<h1>Your Card information</h1>

    <input id="token" name="token" type="hidden" value="">
    <div class="block">
     Amount:<input name="amount" id="amount" readonly value="0">
     <input type="hidden" name="currency" value="AED">
     </div>
    <div class="block">
        <label>
            <span>Card Number</span>
        </label>
        <input id="ccNo" type="text" size="20" value="" autocomplete="off" required />
    </div>
    <div class="block">
        <label>
            <span>Expiration Date (MM/YYYY)</span>
        </label>
        <input type="text" size="2" id="expMonth" required />
        <span> / </span>
        <input type="text" size="2" id="expYear" required />
    </div>
    <div class="block">
        <label>
            <span>CVC</span>
        </label>
        <input id="cvv" size="4" type="text" value="" autocomplete="off" required />
    </div>
    <div class="block">
    <input type="submit" value="Submit Payment">
    </div>
    </td></tr>

</table>
</form>

</div>

</body>
</html>