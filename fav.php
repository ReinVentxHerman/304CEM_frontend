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
            <?php 
                if (isset($_GET['id'])) {
                    echo "var url='https://topup304cembackend.herokuapp.com:3000/getAllFav/'+'".$_GET['id']."';";
                }
            ?>

            $.ajax({
                type: 'GET',
                url: url,
                async: false,
                success: function(e) {
                    var str;
                    for (var j = 0; j < e.length; j++) {
                        str = "";
                        var link = 'https://topup304cembackend.herokuapp.com:3000/getAllFavMv/' + e[j].mvid;
                        $.ajax({
                            type: 'GET',
                            url: link,
                            async: false,
                            success: function(data) {
                                str += "<tr id='" + j + "'>";
                                str += "<td id='tbtitle'><a href='addMovie.php?id=" + data._id + "'>" + data.date.replace("T", " ") + "   " + data.title + "</a></td>";
                                str += "<td><img src='img/fav.png' onclick='favMv(\"" + data._id + "\")' id='favbtn'/></td>";
                                str += "</tr>";
                                $("#table").append(str);
                                checkfavMv(data._id, j);
                            }
                        });
                    }
                }
            });
        });

        function checkfavMv(id, i) {
            var link = "https://topup304cembackend.herokuapp.com:3000/getFav/" + id + "/" + "<?php echo $_SESSION['id']; ?>";
            $.ajax({
                type: 'GET',
                contentType: 'application/json',
                url: link,
                async: false,
                success: function(data) {
                    if (data) {
                        var name = "#" + i + " #favbtn"
                        $(name).attr("src", "img/faved.png");
                        $(name).attr("onclick", 'unFavMv("' + id + '")');
                    } else {
                        var name = "#" + i + " #favbtn"
                        $(name).attr("src", "img/fav.png");
                    }
                }
            });
        }

        function unFavMv(id) {
            var link = "https://topup304cembackend.herokuapp.com:3000/unFav/" + id + "/" + "<?php echo $_SESSION['id']; ?>";
            $.ajax({
                type: 'DELETE',
                contentType: 'application/json',
                url: link,
                async: false,
                success: function(data) {
                    window.location.reload();
                }
            });
        }

        function delfavMv(id) {
            if (confirm('Confirm???')) {
                var link = "https://topup304cembackend.herokuapp.com:3000/delMv/" + id;
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
            var link = "https://topup304cembackend.herokuapp.com:3000/favMv";
            var data = {};
            <?php 
            if(isset($_SESSION['type']) && !empty($_SESSION['type'])){
                echo "data.userid='".$_SESSION['id']."';";
            ?>
            data.mvid = id;

            $.ajax({
                type: 'POST',
                data: JSON.stringify(data),
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

    </script>
</head>

<body>
    <?php include 'bar.php';?>
    <div class='main'>
        <h5>Favourite Moive</h5>
        <table class="table" id='table'>
        </table>

    </div>
</body>

</html>
