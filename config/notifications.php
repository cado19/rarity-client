<?php
// DISPLAY SWEET ALERT IF A MESSAGE IS SET IN THE URL

// check for message in the url

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "
        <script>
            $(document).ready(function(){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '$msg',
                    showConfirmButton: false,
                    timer: 3000
                });
            })
        </script>
    ";
} elseif (isset($_GET['err_msg'])) {
	$msg = $_GET['err_msg'];
	echo "
        <script>
            $(document).ready(function(){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '$msg',
                    showConfirmButton: false,
                    timer: 3000
                });
            })
        </script>
    ";
}

?>