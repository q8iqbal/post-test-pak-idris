<?php
function isFileSafe()
{
    require 'clamav/Clamav.php';

    $clamav = new Clamav(array(
        'clamd_sock' => '/var/run/clamav/clamd.ctl',
        'clamd_ip' => '127.0.0.1'
    ));

    if (isset($_POST['upload'])) {


        $fileName = $_FILES['unscannedFile']['name'];
        $tempName = $_FILES['unscannedFile']['tmp_name'];

        $filePath = "/var/www/html/files/";

        $moveResult = move_uploaded_file($tempName, $filePath . $fileName);

        if ($moveResult) {

            error_log("uda bisa move");

            // if (!get_magic_quotes_gpc()) {
            //     $fileName = addslashes($fileName);
            //     $filePath = addslashes($filePath);
            // }

            $scanResult = $clamav->scan($filePath . $fileName);
            echo var_dump($scanResult);
            if (!$scanResult) {
                unlink($filePath . $fileName);
            }

            return $scanResult;

        } else {
            error_log('gabisa move');
            return false;
        }

    } else {
        error_log('gaada post');
        return false;
    }
}

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Upload Result</title>
</head>
<body>
<div class="container">
    <div class="row py-4 justify-content-center align-items-center">
        <div class="col-4">
            <h3 class="mb-3 text-center">Upload Result</h3>

            <?php
            if (isFileSafe())
                echo '<h2 class="text-center align-middle"><span class="badge bg-success">Berhasil</span></h2><p>File yang diupload aman.</p>';
            else
                echo '<h2><span class="badge bg-danger">Gagal</span></h2><p>File yang diupload kemungkinan adalah malware</p>';
            ?>

            <div class="column is-half">


            </div>
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
</html>
