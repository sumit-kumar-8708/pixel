<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Function Call Every 60 Seconds</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      var i = 0; // Declare and initialize i to 0

        function myFunction() {
            console.log(i++);
            console.log("Function called every 60 seconds");
            // Add your function code here

            $.ajax({
                url:"<?php echo base_url()?>pixel_price/what",
                method:'post',
                dataType:'json',               
                success:function(data){
                    console.log(data);                    
                }
            });


        }

      // Call the function every 60 seconds (60000 milliseconds)
      setInterval(myFunction, 1000);

      // Optionally, you can call the function immediately when the page loads
      myFunction();
    });
  </script>
</head>
<body>
  <h1>Function Call Every 60 Seconds Example</h1>
</body>
</html>
