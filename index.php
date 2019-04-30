<?php session_start(); ?>
<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bar.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="js/jquery1.5.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            if (checkType()) {
                $(".addMovie").css("display", "block");
            } else {
                $(".addMovie").css("display", "none");
            }
            var today = Date.parse("<?php echo date('Y-m-d H:i',time()+6*3600); ?>");

            $.ajax({
                type: 'GET',
                url: "https://topup304cembackend.herokuapp.com/getAllMovie",
                async: false,
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        var ExMovie="";
                        var FtMovie="";
                        if (today >= Date.parse(data[i].date)) {
                            ExMovie += "<tr>";
                            ExMovie += "<td id='tbtitle'><a href='addMovie.php?id=" + data[i]._id + "'>" + data[i].date.replace("T", " ") + "   " + data[i].title + "</a></td>";
                            if (checkType()) {
                                ExMovie += "<td><a href='addMovie.php?id=" + data[i]._id + "'><img src='img/edit.png' id='editbtn'/></a><img src='img/delete.png' onclick='delMv(\"" + data[i]._id + "\")' id='delbtn'/></td>";
                            } else {
                                ExMovie += "<td><img src='img/fav.png' onclick='favMv(\"" + data[i]._id + "\")' id='favbtn'/></td>";
                            }
                            ExMovie += "</tr>";
                        } else {
                            FtMovie += "<tr id='" + i + "'>";
                            FtMovie += "<td id='tbtitle'><a href='addMovie.php?id=" + data[i]._id + "'>" + data[i].date.replace("T", " ") + "   " + data[i].title + "</a></td>";
                            if (checkType()) {
                                FtMovie += "<td><a href='addMovie.php?id=" + data[i]._id + "'><img src='img/edit.png' id='editbtn'/></a><img src='img/delete.png' onclick='delMv(\"" + data[i]._id + "\")' id='delbtn'/></td>";
                            } else {
                                FtMovie += "<td><img src='img/fav.png' onclick='favMv(\"" + data[i]._id + "\")' id='favbtn'/></td>";
                            }
                            FtMovie += "</tr>";
                            $("#schedule-table").append(FtMovie);
                            $("#ex-schedule-table").append(ExMovie);
                        }
                        if(checkType()){
                          checkfavMv(data[i]._id, i);  
                        }
                        
                    }

                }
            });
        });

        function delMv(id) {
            if (confirm('Confirm???')) {
                var link = "https://topup304cembackend.herokuapp.com/delMv/" + id;
                $.ajax({
                    type: 'DELETE',
                    url: link,
                    async: false,
                    success: function(data) {
                        if (data) {
                            window.location.reload();
                        } else {
                            alert("Try again");
                        }
                    }
                });
            }
        }

        function checkType() {
            <?php 
            if(isset($_SESSION['type']) && !empty($_SESSION['type'] && $_SESSION['type']=="A" )){
                echo "return true;";
            }else{
                echo "return false;";
            }?>
        }

        function favMv(id) {
            var link = "https://topup304cembackend.herokuapp.com/favMv";
            var data = {};
            <?php 
            if(isset($_SESSION['type']) && !empty($_SESSION['type'])){
                echo "data.userid='".$_SESSION['id']."';";
            ?>
            data.mvid = id;
            console.log(data);
            $.ajax({
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                url: link,
                async: false,
                success: function(data) {
                    if (data) {
                        window.location.reload();
                    } else {
                        alert("Try again");
                    }
                }
            });
            <?php }else{
                echo "window.location='login.php'";
            }
            ?>
        }

        function checkfavMv(id, i) {

            var link = "https://topup304cembackend.herokuapp.com/getFav/" + id + "/" + "<?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])){echo $_SESSION['id'];} ?>";
            $.ajax({
                type: 'GET',
                contentType: 'application/json',
                url: link,
                async: false,
                success: function(data) {
                    console.log(data);
                    if (data) {
                        var name = "#" + i + " #favbtn"
                        $(name).attr("src", "img/faved.png");
                    } else {
                        var name = "#" + i + " #favbtn"
                        $(name).attr("src", "img/fav.png");
                    }
                }
            });
        }

    </script>
</head>

<body>
    <?php include 'bar.php';?>
    <div class='main'>
        <h5>Future Moive</h5>
        <table class="table" id='schedule-table'>
        </table>

        <h5>Released Movie</h5>
        <table class="table" id='ex-schedule-table'>
        </table>
    </div>
    <a class='addMovie' href='addMovie.php'><img src='img/add.png'/></a>";
</body>

</html>
