<section class="account-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Your Reviews</h2>
    <h5 class="sub-title">All unpaid invoices after due date will be canceled</h5>
    

</section>

<section class="invoice">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%" class="table table-responsive w-100 d-block d-md-table">
                    <thead>
                        <tr>
                            <td>ID #</td>
                            <td>Date issued</td>
                            <td>Date Due</td>
                            <td>Amount</td>
                            <td>Status</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if( $invoices == false)
                        {
                            echo "<tr>";
                            echo "<td colspan='4' style='text-align:center'>You have no invoice</td>";
                            echo "</tr>";
                        }
                        else
                        {
                            foreach($invoices as $invoice)
                            {
                                echo "<tr>";
                                echo "<td>".$invoice['invoice_code']."</td>";
                                echo "<td>".date('M d, Y',strtotime($invoice['date']))."</td>";
                                echo "<td>".date('M d, Y',$invoice['date_due'])."</td>";
                                echo "<td>N".$invoice['cost'].".00</td>";
                                echo "<td>";
                                if ($invoice['status'] == 'Unpaid')
                                {
                                    echo "<span class='badge badge-danger'>".$invoice['status']."</span>";
                                }
                                elseif ($invoice['status'] == 'Paid')
                                {
                                    echo "<span class='badge badge-primary'>".$invoice['status']."</span>";
                                }
                                else
                                {
                                    echo "<span class='badge badge-secondary'>".$invoice['status']."</span>";
                                }
                                echo "</td>";
                                echo "<td>";
                                if ($invoice['status'] == 'Unpaid')
                                {
                                    echo "<a href='".base_url."/index.php/account/del_review/".$invoice['id']."'><button class='btn btn-sm btn-danger'>Pay</button></a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>