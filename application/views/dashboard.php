<?php
     setlocale(LC_MONETARY,"en_IN.UTF-8");
    $monthlyIncome = str_replace('INR','',money_format("%i", $monthly_income));
    //
    $totalOutstanding = str_replace('INR','',money_format("%i", $total_outstanding));
    $currentmonthsOutstanding = str_replace('INR','',money_format("%i", $current_months_outstanding));
?>
<div class="wrapper wrapper-content">
        <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Monthly</span>
                                <h5>Income</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">Rs. <?php echo $monthlyIncome;?></h1>
                                <small>Monthly Income</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">Total</span>
                                <h5>Outstanding</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">Rs. <?php echo $totalOutstanding;?></h1>
                                <small>Total Outstanding</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">Current Month's</span>
                                <h5>Outstanding</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">Rs. <?php echo $currentmonthsOutstanding;?></h1>
                                <small>Current Month's Outstanding</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Total</span>
                                <h5>Customers</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $total_customer;?></h1>
                                <small>Total Customers</small>
                            </div>
                        </div>
                    </div>

        </div>
        
</div>