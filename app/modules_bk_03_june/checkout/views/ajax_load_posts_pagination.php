<?php foreach($posts as $post): ?>
            <div class="col-12 col-xl-3 col-lg-3 col-md-3 col-sm-6 media-cor" data-maxid="<?php echo (isset($post['id']))?$post['id']:'' ?>">
        <a href="javascript:void(0)" class="media-item item-id-<?php echo (isset($post['id']))?$post['id']:'' ?>" data-id="<?php echo (isset($post['id']))?$post['id']:'' ?>" data-url="<?php echo (isset($post['preview']))?$post['preview']:'' ?>">
            <img src="<?php echo (isset($post['image']))?$post['image']:'' ?>" alt="">
            <span class="hover bold"><i class="fas fa-heart"></i> 
                <span class="count-likes-set"></span></span>
        </a>
    </div>
<?php endforeach; ?>