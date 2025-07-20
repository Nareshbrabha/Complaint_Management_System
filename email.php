<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>

    <script>
        $(document).ready(function(e){
            $.ajax({
                type:"POST",
                url:"mail.php",
                data:{
                    deadline:true,
                },
                success:function(response){
                    var res = jQuery.parseJSON(response);
                    if(res.status==200){
                        console.log("success");
                    }
                    else{
                        console.log("error");
                    }
                }
            })
        });

        $(document).ready(function(e) {
$.ajax({
    type: "POST",
    url: "mail.php",
    data: {
        noapproval: true,
    },
    success: function(response) {
        var res = jQuery.parseJSON(response);
        if (res.status == 200) {
            console.log("success");
        } else {
            console.log("error");
        }
    }
});



});




    </script>
</body>
</html>