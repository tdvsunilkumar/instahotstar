<?php
  $ids = (!empty($faq->ids))? $faq->ids: '';
  if ($ids != "") {
    $url = cn($module."/ajax_update/$ids");
  }else{
    $url = cn($module."/ajax_update");
  }
?>

<div class="row justify-content-md-center">
  <div class="col-md-10">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo lang('Edit'); ?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <form class="form actionForm" action="<?php echo strip_tags($url); ?>" data-redirect="<?php echo cn("$module/update/".$ids); ?>" method="POST">
          <div class="form-body">
            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Category</label>
                  <?php $extra = 'class="form-control square"';
                  echo form_dropdown('category_id', $categories, $faq->category_id,$extra); ?>
                </div>
              </div> 

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control square" name="name" value="<?php echo (!empty($faq->name)) ? strip_tags($faq->name) : ''; ?>">
                </div>
              </div>  

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control square" name="email" value="<?php echo (!empty($faq->email)) ? strip_tags($faq->email) : ''; ?>">
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="eventRegInput1">Rating</label>
                  <?php $extra = 'class="form-control square"';
                  echo form_dropdown('rating', $ratings, $faq->rating,$extra); ?>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label><?php echo lang("Status"); ?></label>
                  <select name="status" class="form-control square">
                    <option value="1" <?php echo (!empty($faq->status) && $faq->status == 1) ? 'selected' : ''; ?>><?php echo lang("Active"); ?></option>
                    <option value="0" <?php echo (isset($faq->status) && $faq->status != 1) ? 'selected' : '';?>><?php echo lang("Deactive"); ?></option>
                  </select>
                </div>
              </div> 

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Review</label>
                  <textarea rows="3"  class="form-control square" name="review" placeholder="Customer Review"><?php echo (!empty($faq->review)) ? html_entity_decode($faq->review, ENT_QUOTES) : '';?></textarea>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><?php echo lang('Save'); ?></button>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div> 
</div>

<script>
  $(document).ready(function() {
    plugin_editor('#editor', {height: 500});
  });
</script>