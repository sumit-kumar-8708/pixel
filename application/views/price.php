<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .latest_row td{
        font-weight: bold;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 mt-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Latest Price</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php foreach ($price_list as $key => $price):?>
                            
                        <?php if($key==0):?>
                        <tr class="latest_row">
                            <td><?php echo $key+1?></td>                         
                            <td><?php echo $price->bidPrice?></td>                         
                            <td><?php echo date('d-M-Y h:i:s A', strtotime($price->added_on))?></td>                         
                        </tr>
                        <?php else:?>
                        <tr>
                            <td><?php echo $key+1?></td>                         
                            <td><?php echo $price->bidPrice?></td>                         
                            <td><?php echo date('d-M-Y h:i:s A', strtotime($price->added_on))?></td>                         
                        </tr>
                        <?php endif;?>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            function get_price(){
                $.ajax({
                    url:"<?php echo base_url()?>new_price/ajax_apihit_every_one_min",
                    method:'post',
                    dataType:'json',                   
                    success:function(data){
                        if(data){
                            var html="";
                            data.forEach((price,i) => {
                                if(i==0){
                                    html+=`
                                    <tr class="latest_row">
                                        <td>${i+1}</td>                         
                                        <td>${price.bidPrice}</td>                         
                                        <td>${price.added_on}</td>                         
                                    </tr>
                                    `
                                }else{
                                    html+=`
                                    <tr>
                                        <td>${i+1}</td>                         
                                        <td>${price.bidPrice}</td>                         
                                        <td>${price.added_on}</td>                         
                                    </tr>
                                    `
                                }
                            });
                            $('#tbody').html(html);
                        }
                    }
                });
            }
            // get_price();
            setInterval(get_price, 60000);
        });
    </script>
</body>
</html>