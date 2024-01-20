
<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fa fa-edit"></i> Cart Items for this Order</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
       <div class="table-responsive">
        <table class="table table-hover table-bordered table-vcenter card-table">
          <thead>
            <tr>
              <th>Sr. No</th>
              <th>Cart Item</th>
              <th>Activities Per Item</th> 
              <th>Product Name</th>
            </tr>
          </thead>
          <tbody>
            <?php if(isset($cart) && !empty($cart)): ?>
             <?php 
             $i=1;
             foreach($cart as $item): ?>
              <tr>
                 <td><?php echo (isset($i))?$i:''; ?></td>
                 <td><a href="<?php echo (isset($item->media))?$item->media:''; ?>"><?php echo (isset($item->media))?$item->media:''; ?></a></td>
                 <td><?php echo (isset($item->activities_count))?$item->activities_count:''; ?></td>
                 <td><?php echo (isset($mainCart->product))?$mainCart->product:''; ?></td>
              </tr>
               <?php 
             $i++;
             endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center"> No cart item found</td>
                </tr>

              <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
            <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?php echo lang("Cancel"); ?></button>
          </div>
      </div>
    </div>
  </div>
</div>
