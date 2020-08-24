<?php
$title= 'contect';
require_once 'layout/header.php';

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

    $maxsize = 1*1024;
    $byte= "byte";

    //for real file extinsion  uplode on serve
    $fileupload =  mime_content_type($filedocument['tmp_name']);
  
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

$name = $email = $message = " ";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # code...

 
    //Validate
    $name =filterString($_POST['name']);
    if (!$name) {
        # code...
        $nameError = 'your name required';
    }
    $email = filterEmail($_POST['email']);
    if (!$email) {
        # code...
        $emailError="your email not correct";
    }
    $message =  filterString($_POST['message']);
    if (!$message) {
        # code...
        $massegeError=' your massege required!';
    }



    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        # code...
        if (upload($_FILES['document'])  === "Done") {
            # code...
            echo "You have been successfuly uploaded";
        } else {
            $documentError= upload($_FILES['document']);
        }
    }
}
?>

<div class="contianer">


    <h1>Contect</h1>

    <form
        action=" <?php $_SERVER['PHP_SELF']  ?>  "
        method="post" enctype="multipart/form-data">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?php echo $email?>" placeholder='email'>
                <span class="text-danger"><?php $emailError?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="name">name</label>
                <input type="text" value="<?php echo $name?>"
                    name="name" class="form-control" placeholder='name'>
                <span class="text-danger"><?php echo $nameError?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="document">Doucment</label>
                <input type="file" class="form-control" name="document">
                <span class="text-danger"><?php echo $documentError?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="Message">Message</label>
                <textarea name="message" class="form-control"
                    placeholder='message'> <?php echo $message?></textarea>
                <span class="text-danger"><?php echo $massegeError?></span>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Submit form</button>

    </form>

    <?php require_once 'layout/footer.php';
