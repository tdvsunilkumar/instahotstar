<?php if (!empty($reviews)) {
?>
<div class="col-md-12 col-xl-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?php echo (isset($social_network_name)) ? strip_tags($social_network_name) : lang("Lists"); ?></h3>
      <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
      </div>
    </div>
    <?php if (!empty($reviews)) {
      $j = 1;
    ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-outline table-vcenter card-table">
        <thead>
          <tr>
            <?php
              if (get_role("admin")) {
            ?>
            <th class="text-center w-1">
              <label class="form-check">
                <input class="form-check-input  check-all" type="checkbox" data-name="chk_1">
                <span class="form-check-label"></span>
              </label>
            </th>
            <?php }?>
            <?php if (!empty($columns)) {
              foreach ($columns as $key => $row) {
            ?>
            <th><?php echo strip_tags($row); ?></th>
            <?php }}?>
            
            <?php
              if (get_role("admin") || get_role("supporter")) {
            ?>
            <th><?php echo lang("Action"); ?></th>
            <?php }?>
          </tr>
        </thead>
        <tbody>
            <?php if (!empty($reviews)) {
              $i = 0;
              $currency_symbol = get_option('currency_symbol', '$');
              foreach ($reviews as $key => $row) {
              $i++;
            ?>
            <tr class="tr_<?php echo strip_tags($row->id); ?>">
              <td><?php echo strip_tags($i); ?></td>
              <td class="w-25">
                <div class="title"><?php echo truncate_string(strip_tags($row->cat_name), 30); ?></div>
              </td>
              <td class="text-muted">
                <?php
                  $answer = html_entity_decode($row->name, ENT_QUOTES);
                  $answer = strip_tag_css($answer);
                ?>
                <?php echo truncate_string($answer, 150); ?>
              </td>
              <td class="w-10"><?php echo $row->email; ?></td>
              <td><?php echo $row->rating; ?> Stars</td>
              <td class="text-muted">
                <?php
                  $answer = html_entity_decode($row->review, ENT_QUOTES);
                  $answer = strip_tag_css($answer);
                ?>
                <?php echo truncate_string($answer, 150); ?>
              </td>
              <td class="w-10">
                <?php if(!empty($row->status) && $row->status == 1){?>
                  <span class="badge badge-info"><?php echo lang("Active"); ?></span>
                  <?php }else{?>
                  <span class="badge badge-warning"><?php echo lang("Deactive"); ?></span>
                <?php }?>
              </td> 
              <td class="text-center">
                <div class="btn-group">
                  <a href="<?php echo cn($module."/update/".$row->ids); ?>" class="btn btn-icon btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang("Edit"); ?>"><i class="fe fe-edit"></i></a>
                  <a href="<?php echo cn("$module/ajax_delete_item/".$row->ids); ?>" class="btn btn-icon btn-outline-danger ajaxDeleteItem" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang("Delete"); ?>"><i class="fe fe-trash-2"></i></a>
                </div>
              </td>
            </tr>
            <?php }}?>
            
          </tbody>
      </table>
    </div>
    <?php }?>
  </div>
</div>
<?php }else{?>
  <?php echo Modules::run("blocks/empty_data"); ?>
<?php } ?>
