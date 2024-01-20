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
            <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo lang("edit_service"); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="form-body" id="add_edit_service">
              <div class="row justify-content-md-center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group emoji-picker-container">
                    <label ><?php echo lang("package_name"); ?></label>
                    <input type="text" class="form-control square" name="name" value="<?php echo (!empty($service->name))? strip_tags($service->name): ''?>">
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?php echo lang("choose_a_category"); ?></label>
                    <select  name="category" class="form-control square">
                      <?php if(!empty($categories_by_social_network)){
                        foreach ($categories_by_social_network as $key => $social_network) {
                      ?>
                      <optgroup label="<?php echo strip_tags($social_network->name); ?>"><?php echo strip_tags($social_network->name); ?>
                        <?php if(!empty($social_network->categories)){
                          foreach ($social_network->categories as $key => $category) {
                        ?>
                        <option value="<?php echo strip_tags($category->id); ?>" <?php if(!empty($service->ids) && $category->id == $service->cate_id) echo 'selected'; else echo '';?> ><?php echo strip_tags($category->name); ?></option>
                        <?php }}?>
                      </optgroup>
                      <?php }}?>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Order For</label>
                    <select  name="order_for" class="form-control square">
                      <?php if(!empty($orderFor)){
                        foreach ($orderFor as $key => $value) {
                      ?>
                        <option value="<?php echo $key; ?>" <?php if(!empty($service->order_for) && $service->order_for == $key) echo 'selected'; else echo '';?> ><?php echo strip_tags($value['for']); ?></option>
                        <?php }}?>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Coupan Code</label>
                    <input type="text" class="form-control square" name="coupan" value="<?php echo (!empty($service->coupan))? strip_tags($service->coupan): ''?>">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Coupan Descount (In percentage %)</label>
                    <input type="text" class="form-control square" name="coupan_desc" value="<?php echo (!empty($service->coupan_disc))? strip_tags($service->coupan_disc): ''?>">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Content</label>
                  <textarea rows="3" id="editor" class="form-control square" name="description" placeholder="Category Conent will be display at detail page."><?php echo (!empty($service->description)) ? html_entity_decode($service->description, ENT_QUOTES) : '';?></textarea>
                </div>
              </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label><?php echo lang("Quantity"); ?></label>
                    <input type="number" class="form-control square" name="quantity" value="<?php echo (!empty($service->quantity))? $service->quantity : 100?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label><?php echo lang("Price"); ?></label>
                    <input type="text" class="form-control square" name="price" value="<?php echo (!empty($service->price))? $service->price: 1.99?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label><?php echo lang("Status"); ?></label>
                    <select name="status" class="form-control square">
                      <option value="1" <?php echo (!empty($service->status) && $service->status == 1)? 'selected': ''?>><?php echo lang("Active"); ?></option>
                      <option value="0" <?php echo (isset($service->status) && $service->status != 1)? 'selected': ''?>><?php echo lang("Deactive"); ?></option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Sort</label>
                    <input type="text" class="form-control" name="sort" value="<?php echo (!empty($service->sort))? $service->sort:0?>">
                  </div>
                </div>

                <div class="col-md-12">
                <div class="form-group">
                  <label for="projectinput5">Image</label>
                  <div class="input-group">
                    <input type="text" name="image" class="form-control" value="<?php echo (!empty($service->image)) ? strip_tags($service->image) : ''; ?>">
                    <span class="input-group-append btn-elFinder">
                      <button class="btn btn-info" type="button">
                        <i class="fe fe-image">
                        </i>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

                <div class="col-md-12">
                  <h4 class="text-left"><i class="fe fe-link-2"></i> Page SEO informations</h4>
                </div>
                
                <?php
                  $url_slug = '';
                  if (!empty($service->package_slug)) {
                    $url_slug = $service->package_slug;
                  }
                ?>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>URL Slug</label>
                    <div class="input-group">
                      <span class="input-group-prepend" id="basic-addon3">
                        <span class="input-group-text text-muted"><?php echo BASE; ?></span>
                      </span>
                      <input type="text" name="package_slug" class="form-control" value="<?php echo strip_tags($url_slug); ?>" placeholder="buy-instagram-followers">
                    </div>
                    <small class="text-info">Ex: buy-instagram-followers, facebook-likes-buy etc</small>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Page Title</label>
                    <input  class="form-control square" type="text" name="page_title" value="<?php echo (!empty($service->page_title)) ? strip_tags($service->page_title) : ''; ?>">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Meta Keywords</label>
                    <textarea rows="3" class="form-control square" name="meta_keywords"><?php echo (!empty($service->meta_keywords)) ? strip_tags($service->meta_keywords) : ''; ?></textarea>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Meta description</label>
                    <textarea rows="3" class="form-control square" name="meta_description"><?php echo (!empty($service->meta_description)) ? strip_tags($service->meta_description) : ''; ?></textarea>
                  </div>
                </div>

                <div class="col-md-12"> 
                  <div class="form-group">
                    <div class="form-label"><?php echo lang("Type"); ?></div>
                    <div class="custom-controls-stacked">

                      <label class="form-check-inline custom-control-inline"><?php echo lang('Manual'); ?>
                        <input type="radio" name="add_type" value="manual" <?php echo (isset($service->add_type) && $service->add_type == 'api')? '': 'checked'?>>
                        <span class="checkmark"></span>
                      </label>
                      <label class="form-check-inline custom-control-inline"><?php echo lang('API'); ?>
                        <input type="radio" name="add_type" value="api" <?php echo (isset($service->add_type) && $service->add_type == 'api')? 'checked': ''?>>
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 service-type <?php echo (isset($service->add_type) && $service->add_type == 'api')? '' : 'd-none'?>">
                  <fieldset class="form-fieldset">
                    <div class="form-group">
                      <label><?php echo lang("api_provider_name"); ?></label>
                      <select name="api_provider_id" class="form-control square ajaxGetServicesFromAPI" data-url="<?php echo cn($module.'/ajax_get_services_from_api/'); ?>">
                        <option value="0"> <?php echo lang('choose_a_api_provider'); ?></option>
                        <?php
                          if (!empty($api_providers)) {
                          foreach ($api_providers as $type => $api_provider) {
                        ?>
                        <option value="<?php echo strip_tags($api_provider->id)?>" <?php echo (isset($service->api_provider_id) && $service->api_provider_id == $api_provider->id)? 'selected': ''?>><?php echo strip_tags($api_provider->name)?></option>
                        <?php }} ?>
                      </select>
                    </div>

                    <div class="form-group result-api-service-lists d-none">
                      <div class="dimmer">
                        <div class="loader"></div>
                        <div class="dimmer-content">
                          <label><?php echo lang('list_of_api_services'); ?></label>
                          <select name="api_service_id" class="form-control square">
                            <option value="0"> <?php echo lang('choose_a_service'); ?></option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row api-service-details d-none">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo lang("rate_per_1000")."(".get_option("currency_symbol","").")"?></label>
                          <input type="text" class="form-control square" name="original_price" value="<?php echo (!empty($service->original_price))? $service->original_price : '' ?>" disabled>
                          <input type="hidden" class="form-control square" name="original_price" value="<?php echo (!empty($service->original_price))? $service->original_price : '' ?>">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo lang("minimum_amount"); ?></label>
                          <input type="number" class="form-control square" name="min" value="<?php echo (!empty($service->min))? $service->min :  '' ?>" disabled>
                          <input type="hidden" class="form-control square" name="min" value="<?php echo (!empty($service->min))? $service->min :  '' ?>">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label><?php echo lang("maximum_amount"); ?></label>
                          <input type="number" class="form-control square" name="max" value="<?php echo (!empty($service->max))? $service->max : '' ?>" disabled>
                          <input type="hidden" class="form-control square" name="max" value="<?php echo (!empty($service->max))? $service->max : '' ?>">
                        </div>
                      </div>

                    </div>
                  </fieldset>
                </div>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="<?php echo cn("api_provider/services"); ?>" class="btn round btn-info btn-min-width mr-1 mb-1"><?php echo lang("add_new_service_via_api"); ?></a>
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

 /* CKEDITOR.replace( 'editor', {
    height: 200
  });*/
</script>

<script type="text/javascript">
  $(document).on("keyup","input[type=text][name=name]", function(){
    _that  = $(this);
    _value = _that.val();
    _value = convertToSlug(_value);
    $("#add_edit_service input[name=package_slug]").val(_value);  
  });

  function convertToSlug(Text) {
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
  }
</script>
<script>
  "use strict";
  $(document).ready(function() {
    
    plugin_editor('#editor', {append_plugins: 'image  media', height: 500});
    $(document).on('click','.btn-elFinder', function(){
      var _that = $(this);
      getPathMediaByelFinderBrowser(_that);
    });
  });
  </script>
  <script type="text/javascript">
    $('#modal-ajax').on('hide.bs.modal', function () {
      //alert();
    tinymce.remove('#editor');
    });
  </script>
