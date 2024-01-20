<?php //pr($posts); ?>
<div class="account-change account-photo">
	<?php if(isset($posts) && !empty($posts)): ?>
    <p class="title bold">Select Posts</p>
    <p class="subtitle medium">
        You can select at most 10 posts. Once you're done, scroll down to the 'Payment' card below.    </p>
    <div class="row">
    	   
    	   <?php foreach($posts as $post): ?>
            <div class="col-12 col-xl-3 col-lg-3 col-md-3 col-sm-6 media-cor" data-maxid="<?php echo (isset($post['id']))?$post['id']:'' ?>">
        <a href="javascript:void(0)" class="media-item item-id-<?php echo (isset($post['id']))?$post['id']:'' ?>" data-id="<?php echo (isset($post['id']))?$post['id']:'' ?>" data-url="<?php echo (isset($post['preview']))?$post['preview']:'' ?>">
            <img src="<?php echo (isset($post['image']))?$post['image']:'' ?>" alt="">
            <span class="hover bold"><i class="fas fa-heart"></i> 
                <span class="count-likes-set"></span></span>
        </a>
    </div>
<?php endforeach; ?>
   
    
    </div>
    <style>
        .load-upp-load .loader{
            padding-top: 0;
            font-size: 44px;
            position: initial;
        }
    </style>
    <div class="load-upp-load"></div>
    <a href="#" class="btn-pink mt30 load-more-media">Load More</a>
     <?php  else: ?>
     No post found for this user.
    <?php endif; ?>
</div>
<div class="summary">
        <style>
        #summary-upgrade {
            padding: 25px 30px;
            background: #ff7b7b;
            border-radius: 8px;
            color: #fff;
            margin-bottom: 20px;
            margin-top: 5px;
            position: relative;
        }
        #upgrade-hide {
            width: 25px;
            height: 25px;
            top: 20px;
            right: 20px;
            position: absolute;
            cursor: pointer;
            opacity: .4;
            -webkit-transition: all .3s linear;
            transition: all .3s linear;
        }
        #upgrade-header {
            font-weight: 900;
            display: block;
            width: 85%;
            font-size: 20px;
            padding-bottom: 5px;
            font-family: Lato,Helvetica,Sans-serif;
            line-height: 130%;
        }
        #upgrade-button {
            border-radius: 26px;
            background: #fff;
            padding: 10px 25px;
            min-width: 230px;
            display: inline-block;
            color: #ff7b7b;
            font-family: 'GraphikBold';
            border: 2px solid transparent;
            text-align: center;
            position: relative;
            top: 0;
        }
        #upgrade-hide:hover,
        #upgrade-button:hover {
            cursor: pointer;
            opacity: 0.8;
        }
        @media screen and (max-width: 767px) {
            #upgrade-header {
                text-align: left;
            }
            #upgrade-button {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
    <p class="title bold">Summary</p>
    <div id="summary-list"></div>
    <a href="#" class="btn-pink mt30" onclick="doneAllCart(); return false;">Done</a>
</div>