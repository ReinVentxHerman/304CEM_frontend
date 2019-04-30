<?php session_start(); ?>
<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery1.5.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
    <script>
        $(document).ready(function() {
            $("#loginbtn").click(function() {
                var url = 'http://localhost:3000/checkMember/' + document.getElementById("email").value + '/' + document.getElementById("pw").value;
                $.ajax({
                    type: 'GET',
                    url: url,
                    async: false,
                    success: function(data) {
                        if (data.decide) {
                            $.ajax({
                                type: "POST",
                                url: "session.php",
                                async: false,
                                data: {
                                    email: data.email,
                                    id: data._id,
                                    type: data.type
                                },
                                success: function(e) {
                                    window.location = 'index.php';
                                }
                            });
                        } else {
                            alert("Email/password incorrect!");
                        }
                    }
                });
            });
            $("#registeredbtn").click(function() {
                var data = {};
                data.email = document.getElementById("email").value;
                data.pw = document.getElementById("pw").value;
                $.ajax({
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    url: 'http://localhost:3000/reg',
                    async: false,
                    success: function(data) {
                        if (data.decide) {
                            $.ajax({
                                type: "POST",
                                url: "session.php",
                                async: false,
                                data: {
                                    email: data.email,
                                    id: data._id,
                                    type: data.type
                                },
                                success: function(e) {
                                    alert("Registered had done!");
                                    window.location = 'index.php';
                                }
                            });
                        } else {
                            alert("You are already register!");
                        }
                    }
                });
            });
            var input = document.getElementById("pw");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("loginbtn").click();
                }
            });
        });

    </script>
</head>

<body>
    <div class='main'>
        <div class='title'>
            <h1>Get your favorite movie!</h1>
        </div>
        <div class='fmDiv'>
            <form class='login-form' id='login-form'>
                <input type='email' name='email' id='email' class='form-control' placeholder='email' required><br />
                <input type='password' name='pw' id='pw' class='form-control' placeholder='Password' required/><br />
                <input type='button' value='Login' class='form-btn' id='loginbtn' /><br />
                <input type='button' value='Register' class='form-btn' id='registeredbtn' />
            </form>
        </div>
    </div>
</body>

</html>
