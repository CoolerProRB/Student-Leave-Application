<?php
session_start();
if(!isset($_SESSION["name"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <title>Confirmation</title>
    </head>
    <body class="bg-light">
        <div class="load">
            <div class="spinner-border text-muted"></div>
        </div>
        <div class="preview">
            <p><b>Name: </b><span id="name"></span></p>
            <p><b>Email: </b><span id="email"></span></p>
            <p><b>Subject: </b><span id="subject"></span></p>
            <p><b>Description: </b></p>
            <div id="desc"></div>
        </div>
        <div class="confirm">
            <p class="text-center">Are you sure you want to submit?</p>
            <div class="center">
                <button class="btn btn-primary" onclick="location.href = 'index.php'">No</button>
                <button class="btn btn-primary" onclick="submit()">Yes</button>
            </div>
        </div>
        <script>
            let name = '<?php echo $_SESSION["name"] ?>';
            let email = '<?php echo $_SESSION["email"] ?>';
            let subject = '<?php echo $_SESSION["subject"] ?>';
            let desc = `<?php echo $_SESSION["desc"] ?>`
            
            $("#name").text(name);
            $("#email").text(email);
            $("#subject").text(subject);
            $("#desc").append(desc);

            function submit(){
                $(".load").css("display","flex");
                console.log(desc);
                $.ajax({
                    type: "POST",
                    data: {
                        name: name,
                        email: email,
                        subject: subject,
                        desc: desc
                    },
                    url: "process.php",
                    success: function(data){
                        let response = JSON.parse(data);
                        if(response.status == "success"){
                            location.href = "result.php";
                        }
                        else{
                            alert("An error occurred! Please try again.")
                        }
                    }
                });
            }
        </script>
    </body>
</html>
