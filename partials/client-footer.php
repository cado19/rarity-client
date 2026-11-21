<!-- Jquery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

  <!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.4/sweetalert2.min.js" integrity="sha512-w4LAuDSf1hC+8OvGX+CKTcXpW4rQdfmdD8prHuprvKv3MPhXH9LonXX9N2y1WEl2u3ZuUSumlNYHOlxkS/XEHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

<!-- Tempusdominus Bootstrap 4 -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" ></script>

<?php include_once 'config/notifications.php'; ?>

<script src="assets/phone.js"></script>

<script>
    $(document).ready(function(){
        //Date picker
        $('#birthdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dl_expiry').datetimepicker({
            format: 'YYYY-MM-DD'
        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

    const previews = [
        {
            input: "profile_image",
            preview: "profile_preview"
        },
        {
            input: "id_front",
            preview: "id_front_preview"
        },
        {
            input: "id_back",
            preview: "id_back_preview"
        },
        {
            input: "license_image",
            preview: "license_preview"
        }
    ];

    previews.forEach(item => {

        document
            .getElementById(item.input)
            .addEventListener("change", function () {

                if (!this.files.length) return;

                const url =
                    URL.createObjectURL(this.files[0]);

                const img =
                    document.getElementById(item.preview);

                img.src = url;
                img.style.display = "block";
            });

    });

    document
        .getElementById("customerRegistrationForm")
        .addEventListener("submit", function (e) {

            let valid = true;

            const firstName =
                document.getElementById("first_name");

            const lastName =
                document.getElementById("last_name");

            if (firstName.value.trim().length < 2) {

                valid = false;

                document.getElementById(
                    "first_name_error"
                ).innerText =
                    "First name is too short.";
            }

            if (lastName.value.trim().length < 2) {

                valid = false;

                document.getElementById(
                    "last_name_error"
                ).innerText =
                    "Last name is too short.";
            }

            const dob =
                new Date(
                    document.getElementById(
                        "date_of_birth"
                    ).value
                );

            if (dob > new Date()) {

                valid = false;

                document.getElementById(
                    "dob_error"
                ).innerText =
                    "Date of birth cannot be in the future.";
            }

            if (!valid) {
                e.preventDefault();

                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    text:
                        "Please correct the highlighted fields."
                });
            }

        });

});
</script>

<script>
    // Start the camera
    const video =
        document.getElementById("video");

    navigator.mediaDevices
    .getUserMedia({
        video: {
            facingMode: "user"
        }
    })
    .then(stream => {

        video.srcObject = stream;

    })
    .catch(error => {

        console.error(error);

    });

</script>

<script>
    // Capture the selfie
    function captureSelfie()
    {
        const canvas =
            document.getElementById("canvas");

        const context =
            canvas.getContext("2d");

        canvas.width =
            video.videoWidth;

        canvas.height =
            video.videoHeight;

        context.drawImage(
            video,
            0,
            0
        );

        const image =
            canvas.toDataURL(
                "image/jpeg",
                0.8
            );

        document.getElementById(
            "profile_image"
        ).value = image;

        const preview =
            document.getElementById(
                "preview"
            );

        preview.src = image;
        preview.style.display = "block";
    }

</script>
</body>
</html>