<?php
require_once('rfc6238.php');


//if (TokenAuth6238::verify($secretkey, $currentcode)) {
//    echo "Code is valid\n";
//} else {
//    echo "Invalid code\n";
//}
//

function showBarcode() {
    $secretkey = 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ';
    return sprintf('<img src="%s"/>', TokenAuth6238::getBarCodeUrl('tes', 'tes.com', $secretkey, 'iqbal'));
}

//print sprintf('<img src="%s"/>', TokenAuth6238::getBarCodeUrl('', '', $secretkey, 'My%20App'));
//print TokenAuth6238::getTokenCodeDebug($secretkey, 0);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Login Page</title>
</head>
<body>
<div class="container">
    <div class="row py-4 justify-content-center align-items-center">
        <div class="col-4">
            <div class="column is-half">
                <form>
                    <h3 class="text-center">Login Page</h3>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">OTP</label>
                        <input type="number" class="form-control" name="otp" id="otp"  >
                    </div>

                    <button class="btn btn-primary" onclick="doLogin()">Login</button>
                </form>
            </div>
        </div>
        <div class="col-2">
            <?php echo showBarcode() ?>
        </div>

    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
<script>
    function doLogin(){
        event.preventDefault()
        let data = {
            email : $('#email').val(),
            password : $('#password').val(),
            otp : $('#otp').val()
        }

        let server = "validate.php"
        $.ajax(server, {
            type : "POST",
            data : data,
            timeout: 1000,
            statusCode : {
                200 : () => {
                    window.location.href = "fileupload.php"
                },
                401 : () => {
                    alert("401")
                },
                0 : ()=>{
                    alert("ip anda sedang di ban selama 5 menit")
                }
            }
            
        })
    }
</script>
</html>
