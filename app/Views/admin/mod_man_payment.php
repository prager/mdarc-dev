<div class="modal fade" id="manPayment<?php echo $mem['id']; ?>" tabindex="-1" aria-labelledby="manPaymentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php echo base_url() . '/index.php/man-payment/'. $mem['id']; ?>" method="post">
      <div class="modal-header">
        <h5 id="manPayment<?php echo $mem['id']; ?>Label" class="modal-title">Process Manual Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php
        $timestamp = time();
        $dateTimeObj = new DateTime();
        $dateTimeObj->setTimestamp($timestamp);
        $dateTime = strval($dateTimeObj->format('Y-m-d'));
      ?>
      <div class="modal-body">
        <div class="row my-3">
            <div class="col">
                <label for="pay_date">Payment Date</label>
                <input type="date" class="form-control" id="pay_date" name="pay_date" value="<?php echo $dateTime; ?>">
            </div>
        </div>
        <div class="row my-3">
            <div class="col">
            <label for="amount">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" value="45.00">
            </div>
        </div>
        <div class="row my-3">
            <div class="col offset-lg-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payOption" id="payOption2" value="membership" checked>
                    <label class="form-check-label" for="payOption2">
                        Membership
                    </label>
                </div>                            
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payOption" id="payOption1" value="donation">
                    <label class="form-check-label" for="payOption1">
                        Donation
                    </label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Process Payment</button>
      </div>
    </form>
    </div>
  </div>
</div>
