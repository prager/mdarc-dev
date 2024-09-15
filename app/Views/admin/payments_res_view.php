
<section id="learn" class="py-5">
    <div class="container">
        <div class="row mt-5 pt-3">
            <div class="col-lg offset-lg-2">
            <h3 class="mb-3">Payments Report - Total for Period: <?php echo $total; ?></h3>
            <p><small>Date From: <?php echo $dates['date_from']; ?> | Date To: <?php echo $dates['date_to']; ?> | <?php echo anchor('admin/download_pay_rep', 'Download Report', 'class="text-decoration-none"')?></small></p>
            </div>
        </div>
        <div class="row">
            <div class="col offset-lg-2">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th scope="col">ID Payments</th>
                            <th scope="col">ID Member</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Date</th>
                            <th scope="col">Payaction</th>
                            <th scope="col">Method</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($payments as $payment) { ?>
                            <tr>
                                <td><?php echo $payment['id_payments']; ?></td>
                                <td><?php echo $payment['id_member']; ?></td>
                                <td><?php echo $payment['fname']; ?></td>
                                <td><?php echo $payment['lname']; ?></td>
                                <td><?php echo date("Y-m-d", $payment['paydate']); ?></td>
                                <td><?php echo $payment['payaction']; ?></td>
                                <td><?php echo $payment['mode']; ?></td>
                                <td><?php echo $payment['amount']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>