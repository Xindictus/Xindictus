<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
        <div style="text-align: center; margin-top: 15px;">
            Logged in as user
            <label class="text-primary" aria-disabled="true">
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                echo $_SESSION["name"]." ".$_SESSION["surname"];
                ?>
            </label>
        </div>
    </div>
</nav>
