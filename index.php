<?php
session_start();
$name = $email = $subject = $desc = "";

if(isset($_SESSION["name"])){
    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    $subject = $_SESSION["subject"];
    $desc = $_SESSION["desc"];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" type="image/x-icon" href="images.png">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <title>Student Leave Application</title>
    </head>
    <body class="bg-light">
        <div class="main">
            <h1>Student Leave Application</h1>
        </div>
        <form id="form" method="POST" autocomplete="off">
            <div class="input">
                <span><img src="user.svg" width="20px"></span>
                <input type="text" id="name" name="name" placeholder="Your Name" value="<?php echo $name ?>">
            </div>
            <span id="nameError"></span>
            <div class="input">
                <span><img src="mail.png" width="20px"></span>
                <input type="text" id="email" name="email" placeholder="Email Address" value="<?php echo $email ?>">
            </div>
            <span id="emailError"></span>
            <div class="input">
                <span><img src="light-bulb.png" width="20px"></span>
                <input type="text" id="subject" name="subject" placeholder="Subject / Reason" value="<?php echo $subject ?>">
            </div>
            <span id="subjectError"></span>
            <br>
            <div id="editor" class="bg-white"></div>
            <span id="descError"></span>
            <input id="submit" type="submit" value="Submit">
        </form>
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow'
            });

            quill.root.innerHTML = `<?php echo $desc ?>`;
            
            $("#name").keyup(function(){
                validateName();
            });
            $("#email").keyup(function(){
                validateEmail();
            });
            $("#subject").keyup(function(){
                validateSubject();
            });

            function validateName(){
                let name = $("#name").val();
                let error = "";
                if(name == ""){
                    error = "Name is required!";
                }
                $("#nameError").text(error);
                
                return name != "";
            };
            
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            function validateEmail(){
                let email = $("#email").val();
                let error = "";
                let isValid = true;
                
                if(email == ""){
                    error = "Email is required!";
                    isValid = false;
                }
                else if(!isValidEmail(email)){
                    error = "Invalid email format!";
                    isValid = false;
                }
                
                $("#emailError").text(error);
                
                return isValid;
            }

            function validateSubject(){
                let subject = $("#subject").val();
                let error = "";
                if(subject == ""){
                    error = "Subject is required!";
                }
                $("#subjectError").text(error);
                
                return subject != "";
            };

            $("#form").submit(function(event){
                event.preventDefault();
                
                if(validateName() && validateEmail() && validateSubject()){
                    $("#submit").attr("disabled","true");

                    let data = {
                        name: $("#name").val(),
                        email: $("#email").val(),
                        subject: $("#subject").val(),
                        desc: quill.root.innerHTML
                    }
                    
                    $.ajax({
                        type: "POST",
                        url: "temp.php",
                        data: data,
                        success: function(data){
                            let response = JSON.parse(data);
                            
                            if(response.status == "error"){
                                $("#nameError").text(response.name);
                                $("#emailError").text(response.email);
                                $("#subjectError").text(response.subject);
                                $("#descError").text(response.desc);
                            }
                            else{
                                location.href = "confirmation.php";
                            }
                        }
                    });
                }
            })
        </script>
    </body>
</html>