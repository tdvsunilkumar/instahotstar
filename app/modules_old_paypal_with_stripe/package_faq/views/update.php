<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <?php
          $ids = (!empty($service->ids))? $service->ids: '';
          if ($ids != "") {
            $url = cn($module."/ajax_update/$ids");
          }else{
            $url = cn($module."/ajax_update");
          }
        ?>
        <form class="form actionForm" action="<?php echo strip_tags($url); ?>" data-redirect="<?php echo cn($module); ?>" method="POST">
          <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit FAQ</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="form-body" id="add_edit_service">
              <div class="row justify-content-md-center">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?php echo lang("choose_a_category"); ?></label>
                    <select  name="cat_id" class="form-control square">
                      <?php if(!empty($categories_by_social_network)){
                        foreach ($categories_by_social_network as $key => $social_network) {
                      ?>
                      <optgroup label="<?php echo strip_tags($social_network->name); ?>"><?php echo strip_tags($social_network->name); ?>
                        <?php if(!empty($social_network->categories)){
                          foreach ($social_network->categories as $key => $category) {
                        ?>
                        <option value="<?php echo strip_tags($category->id); ?>" <?php if(!empty($service->ids) && $category->id == $service->cat_id) echo 'selected'; else echo '';?> ><?php echo strip_tags($category->name); ?></option>
                        <?php }}?>
                      </optgroup>
                      <?php }}?>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group emoji-picker-container">
                    <label >Question</label>
                    <input type="text" class="form-control square" name="question" value="<?php echo (!empty($service->question))? strip_tags($service->question): ''?>">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label><?php echo lang("Answer"); ?></label>
                  <textarea rows="3"  class="form-control square" name="answer" placeholder="About Project"><?php echo (!empty($service->answer)) ? html_entity_decode($service->answer, ENT_QUOTES) : '';?></textarea>
                </div>
              </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?php echo lang("Status"); ?></label>
                    <select name="status" class="form-control square">
                      <option value="1" <?php echo (!empty($service->status) && $service->status == 1)? 'selected': ''?>><?php echo lang("Active"); ?></option>
                      <option value="0" <?php echo (isset($service->status) && $service->status != 1)? 'selected': ''?>><?php echo lang("Deactive"); ?></option>
                    </select>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?php echo lang("Submit"); ?></button>
            <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?php echo lang("Cancel"); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo BASE; ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<?php
  if (isset($service->api_provider_id) && isset($service->api_service_id) && $service->api_service_id != '') {
?>
<script type="text/javascript">
  "use strict";
  $(function() {
    var _api_id             = "<?php echo strip_tags($service->api_provider_id); ?>",
        _api_service_id     = "<?php echo strip_tags($service->api_service_id); ?>",
        _action             = "<?php echo cn($module.'/ajax_get_services_from_api'); ?>",
        _token              = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>',
        _data               = $.param({token:_token, api_id:_api_id, api_service_id:_api_service_id});

    $('.result-api-service-lists').removeClass('d-none');
    $('.result-api-service-lists .dimmer').addClass('active');

    $.post( _action, _data, function(_result){
      setTimeout(function () {
        $('.result-api-service-lists .dimmer').removeClass('active');
        $(".result-api-service-lists .dimmer-content").html(_result);
        $('.api-service-details').removeClass('d-none');
      }, 100);
    });
  });
</script>
<?php } ?>

<script>
  "use strict";
  // Check post type
  $(document).on("change","input[type=radio][name=add_type]", function(){
    var _that = $(this),
        _type = _that.val();
    if(_type == 'api'){
      $('.service-type').removeClass('d-none');
    }else{
      $('.service-type').addClass('d-none');
    }
  });

  /*----------  Get Services list from API  ----------*/
  $(document).on("change", ".ajaxGetServicesFromAPI" , function(){

    event.preventDefault();
    $('.result-api-service-lists').removeClass('d-none');
    $('.result-api-service-lists .dimmer').addClass('active');
    var _that       = $(this),
        _id         = _that.val();
    if (_id == "" || _id == 0) {
        return;
    }
    var _action     = _that.data("url"),
        _token      = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>',
        _data       = $.param({token:_token, api_id:_id});
    $.post( _action, _data,function(_result){
      setTimeout(function () {
        $('.api-service-details').removeClass('d-none');
        $(".api-service-details input[name=original_price]").val('');
        $(".api-service-details input[name=min]").val('');
        $(".api-service-details input[name=max]").val('');

        $('.result-api-service-lists .dimmer').removeClass('active');
        $(".result-api-service-lists .dimmer-content").html(_result);
      }, 100);
    });
  })  

  /*----------  Choose a service  ----------*/
  $(document).on("change", ".ajaxGetServiceDetail", function(){
    
    $(".api-service-details input[name=original_price]").val('');
    $(".api-service-details input[name=min]").val('');
    $(".api-service-details input[name=max]").val('');

    var _that = $('option:selected', this),
        _name = _that.attr('data-name'),
        _min  = _that.attr('data-min'),
        _max  = _that.attr("data-max"),
        _rate = _that.attr("data-rate"),
        _type = _that.attr("data-type");

    $(".api-service-details input[name=original_price]").val(_rate);
    $(".api-service-details input[name=min]").val(_min);
    $(".api-service-details input[name=max]").val(_max);

  })

  CKEDITOR.replace( 'editor', {
    height: 200
  });
</script>
