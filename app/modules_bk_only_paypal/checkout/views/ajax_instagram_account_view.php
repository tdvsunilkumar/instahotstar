<div class="account-change main-account" data-key="" data-id="<?php echo (isset($instaAccount->pk))?$instaAccount->pk:0; ?>" data-account="https://www.instagram.com/<?php echo (isset($instaAccount->username))?$instaAccount->username:''; ?>" data-email="<?php echo (isset($email))?$email:''; ?>">
    <img src="<?php echo (isset($instaAccount->profile_pic_url))?$instaAccount->profile_pic_url:''; ?>" alt="">
    <p class="name"><?php echo (isset($instaAccount->full_name) && $instaAccount->full_name != '')?$instaAccount->full_name:$instaAccount->username; ?></p>
    <a href="#" id="change-account" class="btn-pink account-change-btn change-account-anytime">Change Account</a>
</div>
<div id="instaaccount-form-view" style="display: none;">
              <p class="title bold">Instagram account</p>
            <p class="subtitle medium">Select your Instagram account.</p>
            <div id="alert-message">
              
            </div>
               <input type="hidden" id="csrf_token"  name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="text" placeholder="Your Instagram name" name="account" required> 
              <input type="text" placeholder="Your Email" name="email" required> 
              <button id="select-account" type="submit" class="btn-pink mt15 select-account"> Select Account </button>
            </div>
 <script type="text/javascript">
 	$('.change-account-anytime').click(function(){
 		$('.main-account').hide();
 		$('#instaaccount-form-view').show();
    removePay();
    costOfAdd_summ = 0;
        costOfAdd_count = 1;
        reloadCart();
 	});
 </script>           