
<div class="card-header">
  <h3 class="card-title"><?php echo lang('Orders_List'); ?></h3>
</div>
<?php
  if ($orders) {
?>
<div class="table-responsive">
  <table class="table card-table table-striped table-vcenter">
    <thead>
      <tr>
        <th><?php echo lang('No_'); ?></th>
        <th>Transaction Id</th>
        <th><?php echo lang('Package_Name'); ?></th>
        <th><?php echo lang('Price'); ?></th>
        <th><?php echo lang('Status'); ?></th>
        <th>Starter Count</th>
        <th>Remains</th>
        <th><?php echo lang('Order_on'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $currency_symbol = get_option("currency_symbol", "$");
        $i=1;
        foreach ($orders as $key => $row) {
      ?>
      <tr>
        <td class="w-1"><?php echo $i; ?></td>
        <td><?php echo strip_tags($row->transaction_id); ?></td>
        <td><strong><?php echo strip_tags($row->quantity . ' '. $row->service_name); ?></strong></td>
        <td><?php echo $currency_symbol.number_format((float)$row->charge, 2, '.', ''); ?></td>
        <td><?php echo order_status_title($row->status); ?></td>
         <td><?php echo $row->start_counter; ?></td>
          <td><?php echo $row->remains; ?></td>
        <td class="text-muted"><?php echo date("F jS, Y", strtotime($row->created)); ?></td>
      </tr>
      <?php 
      $i++;
      }?>
    </tbody>
  </table>
</div>
<?php
  }else{
?>
<div class="p-t-20 p-b-20">
  <?php echo Modules::run("blocks/empty_data"); ?>
</div>
<?php }?>
