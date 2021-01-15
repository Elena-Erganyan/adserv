<?php

/**
 * Template engine function, includes templates, uses output buffering
 *
 * @param $file - Template file
 * @param $array - Data for inserting variables in $file
 *
 * @return $result - Page template with substituted data from the array
 */
function renderTemplate ($file, $array = []) {
    if (file_exists($file)) {
        extract($array, EXTR_OVERWRITE);
        ob_start();
        include $file;
        $result = ob_get_clean();
    } else {
        $result = "";
    }
    return $result;
}

/**
 * Function for validation numeric fields
 *
 * @param $value Value
 *
 * @return TRUE, if the value is an integer, and FALSE otherwise
 */
function validateNumbers($value) {
    return filter_var($value, FILTER_VALIDATE_INT);
};

/**
 * Function for validation phone fields
 *
 * @param $value Value
 *
 * @return TRUE, if the value is a proper phone number, and FALSE otherwise
 */
function validatePhone($value) {
    $regexp = "~^(?:\+7)\d{10}$~";
    return preg_match($regexp, $value);
};


/**
 * Function for validation email fields
 *
 * @param $value Value
 *
 * @return TRUE, if the value is an email address, and FALSE otherwise
 */
function validateEmail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

/**
 * User search function by email
 *
 * @param $email Email adress
 * @param $users Array with user data
 *
 * @return $result User,if found in the database, or null
 */
function searchUserByEmail($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user["email"] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}

?>