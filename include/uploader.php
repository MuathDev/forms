<?php

function filterString($fieldstring)
{

     // Remove all illegal characters from String
    $fieldstring = filter_var(trim($fieldstring), FILTER_SANITIZE_STRING);

    // return $fieldstring;

    if (empty($fieldstring)) {
        # code...
        return false;
    } else {
        # code...
        return $fieldstring;
    }
}

function filterEmail($fieldemail)
{

    // Remove all illegal characters from email
    $fieldemail = filter_var(trim($fieldemail), FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    if (filter_var($fieldemail, FILTER_VALIDATE_EMAIL)) {
        return $fieldemail;
    } else {
        return false;
    }
}

function upload($filedocument)
{
    $filesallowed = [
        'jpg'=>'image/jpeg',
        'png'=>'image/png',
        'gif'=>'image/gif'
    ];

    $maxsize = 780*1024;
    $byte= "byte";

    //for real file extinsion  uplode on serve
    $fileupload =  mime_content_type($filedocument['tmp_name']);
  
    //if file  empte
    if (empty($fileupload)) {
        # code...
        return false;
    }
    
    //file size upload
    $filesizeupload= $filedocument['size'];


    if (!in_array($fileupload, $filesallowed)) {
        return "sorry the file not work";
    } elseif ($filesizeupload>$maxsize) {
        return "size file not work must less than $maxsize$byte ";
    } else {
        return  "Done";
    }
}


$emailError=" ";
$nameError=' ';
$documentError=' ';
$massegeError=" ";

$name = $email = $message = $document = " ";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # code...

 
    //Validate
    $name =filterString($_POST['name']);
    if (!$name) {
        # code...
        $_SESSION['contact-forms']['name'] = ' ';
        $nameError = 'your name required';
    } else {
        $_SESSION['contact-forms']['name'] = $name;
    }


    $email = filterEmail($_POST['email']);
    if (!$email) {
        # code...
        $_SESSION['contact-forms']['email'] = ' ';
        $emailError="your email not correct";
    } else {
        $_SESSION['contact-forms']['email'] = $email;
    }


    $message =  filterString($_POST['message']);
    if (!$message) {
        # code...
        $_SESSION['contact-forms']['message'] = ' ';
        $massegeError=' your massege required!';
    } else {
        $_SESSION['contact-forms']['message'] = $message;
    }
 

    $document = $_FILES['document'];
    if (!$document) {
        # code...
        // $_SESSION['contact-forms']['document'] = ' ';
        $documentError= ' your file required!';
    }

    
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        # code...

        if (upload($_FILES['document'])  === "Done") {
            # code...
            $folderupload = 'uploads';

            if (!is_dir($folderupload)) {
                # code...
                mkdir($folderupload, 0775);
            }
            $namefile = $_FILES['document']['name'];

            $filepath = $folderupload . '/' . $namefile;

            if (file_exists($filepath)) {
                # code...
                $documentError = "Sorry, file already exists.";
            } else {
                move_uploaded_file($_FILES['document']['tmp_name'], $filepath);
            }
        } else {
            $documentError= upload($_FILES['document']);
        }
    }

    if ($documentError == " " &&  $nameError ==  " " && $massegeError == " " && $emailError == " ") {
        # code...
        if (mail($config['email'], "You have messge", $message)) {
            # code...
            session_destroy();
            header('Location: contact.php');
        } else {
            echo "email error";
        }
    }
}
