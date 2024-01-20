<div class="title text-center">
                <h1 class="title-name"><strong>Billing Address<strong></strong></h1> 
              </div>
<hr class="show-sm">
<div class="alerts">
</div>
<form id="billing_address_form" method="post" action="<?php echo cn('checkout/ipaytotal/save_billing_details'); ?>" >
<div class="row">
    
    <div class="col-sm-6 cardZipGroup">
<div class="form-group">
<div class="input-group">
<div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-user"></i></span>
    </div>
    <input class="form-control spinner" name="first_name" type="text" id="first_name" placeholder="First Name" value="">
    </div>
    <span class="validation_error" id="error_first_name"></span>
</div>
</div>
<div class="col-sm-6 cardZipGroup">
<div class="form-group">
    <div class="input-group">
<div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-user"></i></span>
    </div>
    <input class="form-control spinner" name="last_name" type="text" id="last_name" placeholder="Last Name" value="">
    </div>
<span class="validation_error" id="error_last_name"></span>
</div>
</div>
<div class="col-sm-12 cardZipGroup">
<div class="form-group">
    <div class="input-group">
<div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-address-card"></i></span>
    </div>
    <input class="form-control spinner" name="address" type="text" id="address" placeholder="Address" value="">
    
    </div>
    <span class="validation_error" id="error_address"></span>
</div>
</div>
   <div class="col-sm-6 cardZipGroup">
<div class="form-group">
    
<input id="city" name="city" class="form-control no-icon secure" type="text" placeholder="City" maxlength="16" value="" data-hj-suppress="">
<span class="validation_error" id="error_city"></span>
</div>

</div>
<div class="col-sm-6 cardZipGroup">
<div class="form-group">
<input id="state" name="state" class="form-control no-icon secure" type="text" placeholder="State" maxlength="16" value="" data-hj-suppress="">
<span class="validation_error" id="error_state"></span>
</div>

</div>
<div class="col-sm-6">
<div class="form-group">
<div class="select-wrap">
<select id="country" name="country" value="IN" class="form-control no-icon secure" >
<option value="" disabled="" selected="">Country</option>
<option value="US">United States (US)</option>
<option value="AR">Argentina (AR)</option>
<option value="AM">Armenia (AM)</option>
<option value="AU">Australia (AU)</option>
<option value="AT">Austria (AT)</option>
<option value="BH">Bahrain (BH)</option>
<option value="BE">Belgium (BE)</option>
<option value="BR">Brazil (BR)</option>
<option value="BG">Bulgaria (BG)</option>
<option value="CA">Canada (CA)</option>
<option value="CL">Chile (CL)</option>
<option value="CN">China (CN)</option>
<option value="CO">Colombia (CO)</option>
<option value="CI">Côte d'Ivoire (CI)</option>
<option value="HR">Croatia (HR)</option>
<option value="CY">Cyprus (CY)</option>
<option value="DK">Denmark (DK)</option>
<option value="EG">Egypt (EG)</option>
<option value="EE">Estonia (EE)</option>
<option value="FI">Finland (FI)</option>
<option value="FR">France (FR)</option>
<option value="GE">Georgia (GE)</option>
<option value="DE">Germany (DE)</option>
<option value="GR">Greece (GR)</option>
<option value="HN">Honduras (HN)</option>
<option value="HK">Hong Kong (HK)</option>
<option value="HU">Hungary (HU)</option>
<option value="IS">Iceland (IS)</option>
<option value="IN">India (IN)</option>
<option value="IQ">Iraq (IQ)</option>
<option value="IE">Ireland (IE)</option>
<option value="IL">Israel (IL)</option>
<option value="IT">Italy (IT)</option>
<option value="JP">Japan (JP)</option>
<option value="JO">Jordan (JO)</option>
<option value="KP">Korea, Democratic People's Republic of (KP)</option>
<option value="KR">Korea, Republic of (KR)</option>
<option value="KW">Kuwait (KW)</option>
<option value="LV">Latvia (LV)</option>
<option value="LB">Lebanon (LB)</option>
<option value="LY">Libya (LY)</option>
<option value="LT">Lithuania (LT)</option>
<option value="LU">Luxembourg (LU)</option>
<option value="MV">Maldives (MV)</option>
<option value="MT">Malta (MT)</option>
<option value="MX">Mexico (MX)</option>
<option value="NL">Netherlands (NL)</option>
<option value="NZ">New Zealand (NZ)</option>
<option value="NF">Norfolk Island (NF)</option>
<option value="NO">Norway (NO)</option>
<option value="PK">Pakistan (PK)</option>
<option value="PA">Panama (PA)</option>
<option value="PY">Paraguay (PY)</option>
<option value="PL">Poland (PL)</option>
<option value="PT">Portugal (PT)</option>
<option value="PR">Puerto Rico (PR)</option>
<option value="QA">Qatar (QA)</option>
<option value="RU">Russian Federation (RU)</option>
<option value="SA">Saudi Arabia (SA)</option>
<option value="RS">Serbia (RS)</option>
<option value="SG">Singapore (SG)</option>
<option value="SK">Slovakia (SK)</option>
<option value="SI">Slovenia (SI)</option>
<option value="ZA">South Africa (ZA)</option>
<option value="ES">Spain (ES)</option>
<option value="SE">Sweden (SE)</option>
<option value="CH">Switzerland (CH)</option>
<option value="TH">Thailand (TH)</option>
<option value="TR">Turkey (TR)</option>
<option value="UA">Ukraine (UA)</option>
<option value="AE">United Arab Emirates (AE)</option>
<option value="GB">United Kingdom (GB)</option>
<option value="VN">Viet Nam (VN)</option>
<option value="AX">Åland Islands (AX)</option>
</select>
<span class="validation_error" id="error_country"></span>
</div>

</div>
</div>
<div class="col-sm-6 cardZipGroup">
<div class="form-group">
<input id="zip" name="zip" class="form-control no-icon secure" type="text" placeholder="Postal code" maxlength="16" value="" data-hj-suppress="">

<span class="validation_error" id="error_zip"></span>
</div>

</div>
<div class="col-sm-12 cardZipGroup">
<div class="form-group">
<div class="input-group">
<div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
    </div>
    <input class="form-control spinner" name="email" type="email" id="email" placeholder="Email" value="<?php echo (isset($email))?$email:''; ?>" >
    </div>
    <span class="validation_error" id="error_email"></span>
</div>
</div>
<div class="col-sm-12 cardZipGroup">
<div class="form-group">
    <div class="input-group">
<div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-phone"></i></span>
    </div>
    <input class="form-control spinner" name="phone_no" type="number" id="phone_no" placeholder="Phone" value="">
    
    </div>
<span class="validation_error" id="error_phone_no"></span>
</div>
</div>
</div>

<div class="col-sm-12 cardZipGroup">
<div id="paypal-button-container">
        <p><a href="javascript:void(0);" id="continue-to-card-page" class="btn-pink"><i class="fa fa-lock" style="font-size: 18px;margin-right: 5px;"></i> Continue</a></p>
    </div>
    </div>
    </form>