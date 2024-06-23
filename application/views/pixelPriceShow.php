<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Live-price</title>
</head>
<style>
    .latestPriceUpdate td {
        font-weight: bold;
        color: red;
    }
</style>
<body>

<div class="container">
    <h1 class="text-center text-success">Live Pixel Price Status</h1>

    <div class="">
        <div class="" style="width: 600px; text-align: center;">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Srno.</th>
                    <th scope="col">Price</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function get_ajax_pixel_price() {
                $.ajax({
                    url: "<?php echo site_url('pixel_price/renderData') ?>",
                    method: 'post',
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            var html = "";
                            data.forEach((price, index) => {
                                const rowClass = index === 0 ? 'latestPriceUpdate' : ''; // Add class only for the first row (index 0)
                                html += `
                                    <tr class="${rowClass}">
                                        <td>${index + 1}</td>
                                        <td>${price.bidPrice}</td>
                                        <td>${price.added_on ? new Date(price.added_on).toLocaleDateString() : '-'}</td>
                                        <td>${price.added_on ? new Date(price.added_on).toLocaleTimeString() : '-'}</td>
                                    </tr>
                                `;
                            });
                            $('#tbody').html(html);
                        } else {
                            console.error('Failed to fetch pixel price data');
                            // Handle the error case
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        // Handle AJAX errors
                    }
                });
            }

            get_ajax_pixel_price();
            setInterval(get_ajax_pixel_price, 60000); // Update every minute
        });
    </script>
</body>
</html>
