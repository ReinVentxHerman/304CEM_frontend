<?php session_start(); ?>
<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bar.css">
    <link rel="stylesheet" href="css/addMv.css">
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery1.5.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script>
        function delCom(id, input) {
            if (confirm('Confirm???')) {
                var link = "https://topup304cembackend.herokuapp.com/delCom/" + id;
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

        function editCom(id,input) {
            var link = "https://topup304cembackend.herokuapp.com/editCom/" + id;
            var data = {};
            data.comment=document.getElementById(input).value;
            $.ajax({
                type: 'PUT',
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
        }
        $(document).ready(function() {
            <?php 
                if (isset($_GET['id'])) {
                    echo "var id='".$_GET['id']."';";
                    echo "var url='https://topup304cembackend.herokuapp.com/editMv/'+id;";
                    echo "var type='PUT';";
            ?>
            $.ajax({
                type: 'GET',
                url: 'https://topup304cembackend.herokuapp.com/getMv/' + id,
                success: function(data) {
                    if (data) {
                        $("#title").val(data.title);
                        $("#date").val(data.date);
                        $("#content").val(data.content);
                    }
                }
            });
            $.ajax({
                type: 'GET',
                url: 'https://topup304cembackend.herokuapp.com/getCom/' + id,
                success: function(data) {
                    var str = "";
                    for (var i = 0; i < data.length; i++) {
                        str += "<tr id='" + i + "'>";
                        str += "<td id='name'>" + data[i].name + "</td>";
                        if (data[i].name == '<?php echo $_SESSION['email']; ?>') {
                            str += "<td><input class='input-com' value='" + data[i].comment + "' id='input" + i + "'/></td>";
                            str += "<td id='action' class='action'><img src='img/edit.png' id='editbtn' onclick='editCom(\"" + data[i]._id + "\",\"input" + i + "\");'/><img src='img/delete.png' onclick='delCom(\"" + data[i]._id + "\",\"#input" + i + "\");' id='delbtn'/></td>";
                        } else {
                            str += "<td>" + data[i].comment + "</td>";
                        }

                        str += "</tr>";
                    }
                    $(".table").html(str);
                }
            });
            <?php
                }else{
                    echo "var url='https://topup304cembackend.herokuapp.com/addMovie';";
                    echo "var type='POST';";
                }
            ?>
            $("#sbbtn").click(function() {
                var data = {};
                data.date = document.getElementById("date").value;
                data.title = document.getElementById("title").value;
                data.content = document.getElementById("content").value;

                $.ajax({
                    type: type,
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    url: url,
                    success: function(data) {
                        if (data) {
                            window.location = 'index.php';
                        }
                    }
                });
            });
            $("#addCombtn").click(function() {
                var data = {};
                data.comment = document.getElementById("comment").value;
                data.name = '<?php echo $_SESSION['email'];?>';
                data.userid = '<?php echo $_SESSION['id'];?>';
                data.mvid = id;
                $.ajax({
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    url: 'https://topup304cembackend.herokuapp.com/addCom',
                    success: function(data) {
                        if (data) {
                            window.location.reload();
                        }
                    }
                });
            });
        });

    </script>
</head>

<body>
    <?php include 'bar.php';?>
    <form>
        <div class='main'>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Movie release date</span>
                </div>
                <input class="form-control date-input" type="date" name='date' id='date'>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Title</span>
                </div>
                <input type="text" class="form-control" placeholder="Movie title" aria-label="Title" name="title" id="title" aria-describedby="basic-addon1">
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Content</span>
                </div>
                <textarea class="form-control text-area" aria-label="Content" name='content' id='content'></textarea>
            </div>
            <?php 
            if(isset($_SESSION['type']) && !empty($_SESSION['type'] && $_SESSION['type']=="A" )){
                echo '<button type="button" class="btn btn-primary" id="sbbtn">Submit</button>';
            }else{?>
            <script>
                $("#date ,#title ,#content").attr("readonly", "readonly")

            </script>
            <br/>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Comment</span>
                </div>
                <textarea class="form-control text-area" aria-label="Comment" name='comment' id='comment'></textarea>
            </div>
            <br/>
            <button type="button" class="btn btn-primary" id="addCombtn">Add comment</button>
            <?php } ?>
            <br />
            <br />
            <table class="table" id='schedule-table'>
            </table>
        </div>
    </form>
</body>

</html>
