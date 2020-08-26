<?php
$title= 'contect';
require_once 'layout/header.php';

require_once('include/uploader.php');

 

?>

<div class="contianer">


    <h1>Contect</h1>

    <form
        action=" <?php $_SERVER['PHP_SELF']  ?>  "
        method="post" enctype="multipart/form-data">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?php if (isset($_SESSION['contact-forms']['email'])) {
    echo $_SESSION['contact-forms']['email'];
}?>" placeholder='email'>
                <span class="text-danger"><?php echo $emailError?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="name">name</label>
                <input type="text" value="<?php if (isset($_SESSION['contact-forms']['name'])) {
    echo $_SESSION['contact-forms']['name'];
}?>" name="name" class="form-control" placeholder='name'>
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
                <textarea name="message" class="form-control" placeholder='message'> <?php if (isset($_SESSION['contact-forms']['message'])) {
    echo $_SESSION['contact-forms']['message'];
}?></textarea>
                <span class="text-danger"><?php echo $massegeError?></span>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Submit form</button>

    </form>

    <?php require_once 'layout/footer.php';
