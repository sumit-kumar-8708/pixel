<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <style>
    .latest_row td {
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#hide").click(function(){
    $("p").hide();
  });
  $("#show").click(function(){
    $("p").show();
  });
});
</script>

<script>
        $(document).ready(function(){           
            function get_ajax_pixel_price(){
                $.ajax({                 
                    type: "POST",
                    url: '<?= base_url().'pixel_price/renderData' ?>',
                    data:  new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                   
                        console.log(data);
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
                        location.reload();
                    }
                });
            }
            get_ajax_pixel_price();
            // setInterval(get_ajax_pixel_price, 60000);
            setInterval(get_ajax_pixel_price, 1000);
        });
    </script>
  </body>
</html>