<?php
// function that will show record value or NA if absent
function show_value($object, $value)
{
    if (array_key_exists($value, $object)) {
        if (isset($object[$value])) {
            echo $object[$value];
        } else {
            echo "N/A";
        }
    } else {
        echo "N/A";
    }
}

// function that will show numeric record value or NA if absent
function show_numeric_value($object, $value)
{
    global $res;
    if (array_key_exists($value, $object)) {
        if (isset($object[$value])) {
            $res = (float) ($object[$value]);
            echo number_format($res);
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

}

// function that will show monetary numeric record value or NA if absent
function show_monetary_value($object, $value)
{
    global $res;
    if (array_key_exists($value, $object)) {
        if (isset($object[$value])) {
            $res = (float) ($object[$value]);
            echo number_format($res, 2);
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }

}



// function that will show date record value or NA if absent
function show_date_value($object, $value)
{
    if (array_key_exists($value, $object)) {
        if (isset($object[$value])) {
            $date_display = strtotime($object[$value]);
            echo date("l jS \of F Y", $date_display);
        } else {
            echo "N/A";
        }
    } else {
        echo "N/A";
    }
}

// function that will show record value or empty string in field in edit form
function edit_input_value($object, $value)
{
    if (array_key_exists($value, $object)) {
        if (isset($object[$value])) {
            echo $object[$value];
        } else {
            echo "";
        }
    } else {
        echo "";
    }
}
// function that will show record value or empty string in dropdown field in edit form
function edit_dropdown_value($object, $value)
{
    if (array_key_exists($value, $object)) {
        if (isset($value)) {
            echo $object[$value];
        } else {
            echo "--Please choose an option--";
        }
    } else {
        echo "--Please choose an option--";
    }

}

function format_number_plate($plate_1, $plate_2)
{
    $plate_1 = strtoupper($plate_1);
    // $plate_2 = $_POST['plate_2'];

    // format plate 2
    $plate_2_1 = substr($plate_2, 0, 3);
    $plate_2_2 = ucwords(substr($plate_2, -1));
    $plate     = $plate_1 . " " . $plate_2_1 . $plate_2_2;

    return $plate;
}

function category_name($category_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "SELECT name FROM vehicle_categories WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$category_id]);
        if ($stmt->rowCount() == 1) {
            $res = $stmt->fetch();
        } else {
            $res = "Failed";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// generate link where customer can edit their profile
function customer_edit_link($id)
{
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

    $link .= "?page=client/register/edit&id=${id}";

    return $link;
}

// generate link where customer can edit their profile
function customer_profile_pic_link($id)
{
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

    $link .= "?page=client/register/profile_form&id=${id}";

    return $link;
}
// generate link where customer can upload their id image
function customer_id_link($id)
{
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

    $link .= "?page=client/register/id_form&id=${id}";

    return $link;
}

// generate link where customer can upload their license image
function customer_license_link($id)
{
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

    $link .= "?page=client/register/dl_form&id=${id}";

    return $link;
}

function voucher_link($id)
{
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

    $link .= "?page=bookings/booking_voucher&id=${id}";

    return $link;
}

function cancelled_voucher_link($id)
{
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

    $link .= "?page=bookings/cancelled_booking_voucher&id=${id}";
    
    return $link;
}

// this is a general upload function that will return a status response for validation purposes
function upload_image($destination, $temporary_name)
{
    global $res;
    move_uploaded_file($temporary_name, $destination);
    $res = "Success";
    return $res;
}

function countries()
{
    $countries = ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];

    return $countries;
}

function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            imagejpeg($image, $destination, $quality);
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            imagepng($image, $destination, $quality);
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            imagegif($image, $destination, $quality);
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
           imagejpeg($image, $destination, $quality);
    } 
     
     
    // Return compressed image 
    return $destination; 
} 
