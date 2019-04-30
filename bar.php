<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Hong Kong Movie</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <?php 
                    if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                        echo '<a class="nav-link" href="fav.php?id='.$_SESSION['id'].'">My Favorite</a>';
                    }else{
                        echo '<a class="nav-link" href="login.php">My Favorite</a>';
                    }
                ?>
            </li>

        </ul>
        <p class='userName'>
            <a href="self.php?id=<?php echo $_SESSION['email']; ?>" class="Rfloat userName">
                <?php 
                    if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                        echo $_SESSION['email'];
                    }else{
                        echo "Vistor";
                    }
                ?>
            </a>
        </p>
        <?php 
            if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                 echo '<a href="#" onclick="logout()" class="Rfloat logbtn">logout</a>';
            }else{
                echo '<a href="login.php" class="Rfloat logbtn">login</a>';
            }
        ?>
    </div>
</nav>




<script>
    function Search() {
        window.location = 'index.php?key=' + document.getElementById('keyword').value;
        return false;
    }

    function logout() {
        $.ajax({
            type: "POST",
            url: "session.php",
            async: false,
            data: {
                logout: true
            },
            success: function(e) {
                window.location = 'index.php';
            }
        });
    }

</script>
