<?php
    // THIS PAGE IS WHERE THE CONTRACT WILL BE SIGNED

    // our database configuration
    include_once 'db_credentials/credentials.php';

    // DATABASE DRIVER
    $DBDRIVER = "mysql";

    // DATABASE HOST
    $DBHOST = "localhost";

    // DATABASE USER USERNAME
    $DBUSER = $DBUSERNAME;

    // DATABASE USER PASSWORD
    $DBPASS = $DBPASSWORD;

    // DATABASE NAME
    $DBNAME = "rarity-rental";

    try {
        $con = new PDO("$DBDRIVER:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // get booking id from the url
    $id = "";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    // use the id from the url to fetch the contract id for the contract that needs to be signed
    $sql  = "SELECT id from contracts WHERE booking_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);
    $contract_id = $stmt->fetch(PDO::FETCH_ASSOC);

    $new_id = $contract_id['id'];

    $path = $_SERVER['DOCUMENT_ROOT'] . "/contracts/update.php";

    // get page url
    // Program to display complete URL
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $link = "https";
    } else {
        $link = "http";
    }

    // Here append the common URL characters
    $link .= "://";

    // Append the host(domain name,
    // ip) to the URL.
    $link .= $_SERVER['HTTP_HOST'];

    // Append the requested resource
    // location to the URL
    $link .= $_SERVER['PHP_SELF'];

    $link .= "?page=contracts/edit&id=${id}";

    // echo $new_id;

    // $log->info($new_id);
    // $log->warning($id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The Signature</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- <link rel="stylesheet" href="libs/css/bootstrap.v3.3.6.css"> -->
    <script type="text/javascript" src="../assets/signature.js"></script>
    <style>
        body{
        padding: 15px;
        }
        #note{position:absolute;left:50px;top:35px;padding:0px;margin:0px;cursor:default;}
        .h-100{height: 100vh}
</style>
</head>
<body>
    <div class="container">
        <div class="row h-100 d-flex justify-content-center align-items-center">
            <div class="col-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h1 class="card-title">Digital Signature</h1>
                    </div>
                    <div class="card-body">

                        <form method="post" action="contract/update.php" enctype="multipart/form-data">
                            <!-- pass the contract id as a hidden input field  -->
                            <input type="hidden" name="id" value="<?php echo $new_id; ?>">
                            <div id="signature-pad">
                                <div style="border:solid 1px teal; width:360px;height:110px;padding:3px;position:relative;">
                                    <div id="note" onmouseover="my_function();">The signature should be inside box</div>
                                    <canvas id="the_canvas" width="350px" height="100px"></canvas>
                                </div>
                                <div style="margin:10px;">
                                    <input type="hidden" id="signature" name="signature">
                                    <button type="button" id="clear_btn" class="btn btn-danger" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                                    <button type="submit" id="save_btn" class="btn btn-primary" data-action="save-png"><span class="glyphicon glyphicon-ok"></span> Save as PNG</button>
                                </div>
                            </div>
                        <form>

                    </div>
                </div>
            </div>
            <div class="col-4">
                <a href="index.php?page=contracts/updated_contract&id=<?php echo $id; ?>" class="btn btn-success" target="_blank">View contract</a>
                <a href="index.php?page=bookings/show&id=<?php echo $id; ?>" class="btn btn-warning">Back to booking</a>
            </div>
        </div>

    </div>

<script>
var wrapper = document.getElementById("signature-pad");
var clearButton = wrapper.querySelector("[data-action=clear]");
var savePNGButton = wrapper.querySelector("[data-action=save-png]");
var canvas = wrapper.querySelector("canvas");
var el_note = document.getElementById("note");
var signaturePad;
signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
    document.getElementById("note").innerHTML="The signature should be inside box";
    signaturePad.clear();
});
savePNGButton.addEventListener("click", function (event){
    if (signaturePad.isEmpty()){
        alert("Please provide signature first.");
        event.preventDefault();
    }else{
        var canvas  = document.getElementById("the_canvas");
        var dataUrl = canvas.toDataURL();
        document.getElementById("signature").value = dataUrl;
    }
});
function my_function(){
    document.getElementById("note").innerHTML="";
}
</script>
<script>
    var copyBtn = document.getElementById("copyButton");
    copyBtn.addEventListener("click",function (e) {
      // Get the text field
      var copyText = document.getElementById("contractLink");

      // Select the text field
      copyText.select();
      copyText.setSelectionRange(0, 99999); // For mobile devices

       // Copy the text inside the text field
      navigator.clipboard.writeText(copyText.value);

      // Alert the copied text
      alert("Copied the text: " + copyText.value);
    })
</script>
</body>
</html>