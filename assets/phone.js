    function getIp(callback) {
        fetch('https://ipinfo.io/json?token=710be1c6822063', { headers: { 'Accept': 'application/json' }})
        .then((resp) => resp.json())
        .catch(() => {
            return {
            country: 'ke',
            };
        })
        .then((resp) => callback(resp.country));
    }
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        initialCountry: "auto",
        geoIpLookup: getIp,
        utilsScript:
           "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

   $(document).ready(function(){
        $('#phone').change(function(){
            const phoneNumber = phoneInput.getNumber();
            $('#phone').val(phoneNumber);
            console.log($('#phone').val());
        })
    });