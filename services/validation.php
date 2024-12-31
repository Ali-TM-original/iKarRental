<?php

/**
 * Validates data.
 * @param array $inputData user data.
 * @param array $errors the error array.
 * @param array $data The actual dta to send to the server.
 * @return Bool true if validation succeeds.
 */
function isContactValid($inputData, &$errors, &$data)
{
    // Name validation
    if (!isset($inputData['name']))
        $errors[] = "Name is required!";
    else if (trim($inputData['name']) === "") // " dsdas dsada dsad  " => "dsdasdsadadsad" , "  " => ""
        $errors[] = "Name can not be empty!";
    else
        $data['name'] = $inputData['name'];


    // Email validation
    if (!isset($inputData['emails']))
        $errors[] = "Emails are required!";
    else if (!is_array($inputData['emails']))
        $errors[] = "Emails must be array!";
    else {
        $validEmails = array_filter($inputData['emails'], function ($e) {
            return filter_var($e, FILTER_VALIDATE_EMAIL);
        });

        if (count($validEmails) === 0)
            $errors[] = "Must have at least one email!";
        else
            $data['emails'] = $validEmails;
    }

    // Phone validation
    if (!isset($inputData['phone']))
        $errors[] = "Phone is required!";
    else if (!filter_var($inputData['phone'], FILTER_VALIDATE_INT))
        $errors[] = "Invalid phone number!";
    else
        $data['phone'] = $inputData['phone'];

    return count($errors) === 0;
}

/**
 * Validates data.
 * @param array $inputData user data.
 * @param array $errors the error array.
 * @return Bool true if validation succeeds.
 */
function isUserValid($inputData, &$errors)
{
    if (!isset($inputData['email']) || !isset($inputData['fullname']) || !isset($inputData['password']))
        $errors[] = "Missing keys";

    $nameRegex = '/^[A-Za-z]+([\'\-\s][A-Za-z]+)*$/';
    if (!preg_match($nameRegex, $inputData['fullname']))
        $errors[] = "Invalid name";

    $passRegex = '/^(?=.*[0-9])(?=.*[!@#$%&])[A-Za-z0-9@$!&#]{8,}$/';
    if (!preg_match($passRegex, $inputData['password']))
        $errors[] = "Invalid password";

    return count($errors) === 0;
}

/**
 * Validates data.
 * @param array $inputData user data.
 * @param array $errors the error array.
 * @return Bool true if validation succeeds.
 */
function isLoginValid($inputData, &$errors)
{
    if (!isset($inputData['email']) || !isset($inputData['password']))
        $errors['global'] = "Missing keys";

    if (trim($inputData['email']) === "")
        $errors['email'] = "email is missing";

    if (trim($inputData['password']) === "")
        $errors['password'] = "Password is missing";

    return count($errors) === 0;
}

function isEditValid($inputData, &$errors): bool
{
    if (!isset($inputData['fuel']) || !isset($inputData['gear']) || !isset($inputData['year']) || !isset($inputData['passengers']) || !isset($inputData['daily_price_huf']))
        $errors['global'] = "Missing keys";

    if (strtolower($inputData['fuel']) != "petrol" && strtolower($inputData['fuel']) != "diesel" && strtolower($inputData['fuel']) != "electric")
        $errors['fuel'] = "Wrong fuel type";

    if (strtolower($inputData['gear']) != "automatic" && strtolower($inputData['gear']) != "manual")
        $errors['password'] = "Wrong Gear Type";

    if ($inputData['fuel'] == '' || $inputData['gear'] == '' || $inputData['year'] == '' || $inputData['passengers'] == '' || $inputData['daily_price_huf'] == '')
        $errors['empty'] = 'Empty fields';

    return count($errors) === 0;
}

function isCarValid($inputData, &$errors): bool
{
    if (!isset($inputData['brand']) || !isset($inputData['model']) || !isset($inputData['year']) || !isset($inputData['fuel']) || !isset($inputData['gear']) || !isset($inputData['passengers']) || !isset($inputData['daily_price_huf']) || !isset($inputData['image']))
        $errors['global'] = "Missing keys";

    if (strtolower($inputData['fuel']) != "petrol" && strtolower($inputData['fuel']) != "diesel" && strtolower($inputData['fuel']) != "electric")
        $errors['fuel'] = "Wrong fuel type";

    if (strtolower($inputData['gear']) != "automatic" && strtolower($inputData['gear']) != "manual")
        $errors['password'] = "Wrong Gear Type";

    if ($inputData['fuel'] == '' || $inputData['gear'] == '' || $inputData['year'] == '' || $inputData['passengers'] == '' || $inputData['daily_price_huf'] == '')
        $errors['empty'] = 'Empty fields';

    if (filter_var($inputData['image'], FILTER_VALIDATE_URL) == false)
        $errors['image'] = 'Image must be a url';

    return count($errors) === 0;
}