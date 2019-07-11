<section class="account-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Your Orders</h2>
    <h5 class="sub-title">All unpaid orders will be canceled after attached invoice past due date</h5>
    

</section>

<section class="invoice">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%" class="table table-responsive w-100 d-block d-md-table">
                    <thead>
                        <tr>
                            <td>ID #</td>
                            <td>Date placed</td>
                            <td>Attached invoice code</td>
                            <td>Item</td>
                            <td>Quantity</td>
                            <td>Unit price</td>
                            <td>Total price</td>
                            <td>Payment status</td>
                            <td>Delivery status (tracking)</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if( $orders == false)
                        {
                            echo "<tr>";
                            echo "<td colspan='4' style='text-align:center'>You have not placed any order</td>";
                            echo "</tr>";
                        }
                        else
                        {
                            foreach($orders as $order)
                            {
                                echo "<tr>";
                                echo "<td>".$order['order_code']."</td>";
                                echo "<td>".date('M d, Y',strtotime($order['date_ordered']))."</td>";
                                echo "<td>".$order['attached_invoice']."</td>";
                                echo "<td>".$order['item_name']."</td>";
                                echo "<td>".$order['qty']."</td>";
                                echo "<td>N".$order['unit_price'].".00</td>";
                                echo "<td>N".$order['total_price'].".00</td>";
                                echo "<td>";
                                if ($order['payment_status'] == 'Unpaid')
                                {
                                    echo "<span class='badge badge-danger'>".$order['payment_status']."</span>";
                                }
                                elseif ($order['payment_status'] == 'Paid')
                                {
                                    echo "<span class='badge badge-primary'>".$order['payment_status']."</span>";
                                }
                                else
                                {
                                    echo "<span class='badge badge-secondary'>".$order['payment_status']."</span>";
                                }
                                echo "</td>";
                                echo "<td><span class='badge badge-secondary'>".$order['delivery_status']."</span></td>";
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