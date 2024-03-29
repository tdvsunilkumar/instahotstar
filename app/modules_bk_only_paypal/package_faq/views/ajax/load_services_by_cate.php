<?php if (!empty($services)) {
?>
<table class="table table-hover table-bordered table-outline table-vcenter card-table">
  <thead>
    <tr>
      <?php
        if (get_role("admin")) {
      ?>
      <th class="text-center w-1">
        <label class="form-check">
          <input class="form-check-input  check-all" type="checkbox" data-name="chk_<?php echo strip_tags($cate_id); ?>">
          <span class="form-check-label"></span>
        </label>
      </th>
      <?php }?>
      <th class="text-center w-1">ID</th>
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
    <?php if (!empty($services)) {
      $i = 0;
      foreach ($services as $key => $row) {
      $i++;
    ?>
    <tr class="tr_<?php echo strip_tags($row->ids); ?>">
      <?php
        if (get_role("admin")) {
      ?>
      <th class="text-center w-1">
        <label class="form-check">
          <input class="form-check-input  chk_<?php echo strip_tags($cate_id); ?>" type="checkbox" name="ids[]" value="<?php echo strip_tags($row->ids); ?>">
          <span class="form-check-label"></span>
        </label>
      </th>
      <?php }?>
      <td class="text-center text-muted"><?php echo strip_tags($row->id); ?></td>

      <td>
        <div class="title"><?php echo strip_tags($row->catName); ?></div>
      </td> 

      <td class="w-25">
                <div class="title"><?php echo truncate_string(strip_tags($row->question), 30); ?></div>
              </td>
              <td class="text-muted">
                <?php
                  $answer = html_entity_decode($row->answer, ENT_QUOTES);
                  $answer = strip_tag_css($answer);
                ?>
                <?php echo truncate_string($answer, 150); ?>
              </td>

      <?php
        if (get_role("admin") || get_role("supporter")) {
      ?>
      <td class="w-1" >
        <?php if(!empty($row->status) && $row->status == 1){?>
          <span class="badge badge-info"><?php echo lang("Active"); ?></span>
          <?php }else{?>
          <span class="badge badge-warning"><?php echo lang("Deactive"); ?></span>
        <?php }?>
      </td>  

      <td class="text-center w-10">
        <div class="btn-group">
          <a href="<?php echo cn($module."/update/".$row->ids); ?>" class="btn btn-icon btn-outline-primary ajaxModal" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang("Edit"); ?>"><i class="fe fe-edit"></i></a>
          <a href="<?php echo cn("$module/ajax_delete_item/".$row->ids); ?>" class="btn btn-icon btn-outline-danger ajaxDeleteItem" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang("Delete"); ?>"><i class="fe fe-trash-2"></i></a>
        </div>
      </td>
      <?php }?>

    </tr>
    <?php }}?>
    
  </tbody>
</table>
<?php } ?>
