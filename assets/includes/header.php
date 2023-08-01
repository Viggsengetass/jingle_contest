<!-- <header class="p-3 text-bg-dark">
    <nav class="navbar navbar-expend-lg navbar-dark shadow-1" data-mdb-hidden="false" data-mdb-accordion="true">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="https://genshin-impact.lowhost.fr/" class="nav-link px-2 text-white">Accueil</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">ZOB</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Zob</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Zob</a></li>
                </ul>
                <?php
if (isset($_SESSION["username"])) {
    echo '
                         <div class="d-flex align-items-center">
                            <a href="mon-compte.php" class="d-block link-dark text-decoration-none dropdown-toggle">
                            <img src="https://www.gravatar.com/avatar/';
    echo md5(strtolower(trim($_SESSION["email"])));
    echo '" alt="mdo" width="32" height="32" class="rounded-circle">
                            <small class="text-white">';
    echo $_SESSION['username'];
    if ($_SESSION['role'] == 'Admin') {
        echo '<a href="admin.php"><button type="button" class="btn btn-outline-light me-2">Espace Admin</button></a>';
    }
    echo '
                         <a href="logout.php"><button type="button" class="btn btn-warning me-3">Déconnexion</button></a>';
} else {
    echo '<div class="text-end">
                         <a href="login.php"><button type="button" class="btn btn-outline-light me-2">Connexion</button></a>
                         <a href="inscription.php"><button type="button" class="btn btn-warning">Inscription</button></a>
                         </div>';
}
?>
            </div>
        </div>
    </nav>
</header> -->
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Container wrapper -->
        <div class="container">
            <!-- Navbar brand -->
            <a class="navbar-brand me-2" href="https://genshin-impact.lowhost.fr/">
                <img
                    src="/assets/img/Logo.png"
                    height="16"
                    alt="MDB Logo"
                    loading="lazy"
                    style="margin-top: -1px;"
                />
            </a>

            <!-- Toggle button -->
            <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample"
                aria-controls="navbarButtonsExample"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="https://genshin-impact.lowhost.fr/first/first.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/chat.php">chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/calendrier2.php">Calendrier des évenements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/build.php">Build</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/testteddy.php">Personnage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/testali.php">Actus</a>
                    </li>
                </ul>
                <!-- Left links -->

                <?php
                if (isset($_SESSION["username"])) {
                    echo '
                         <div class="d-flex align-items-center">
                            <a href="/mon-compte.php" class="d-block link-dark text-decoration-none dropdown-toggle">
                            <img src="https://www.gravatar.com/avatar/';
                    echo md5(strtolower(trim($_SESSION["email"])));
                    echo '" alt="mdo" width="32" height="32" class="rounded-circle">
                            <small class="text-white">';
                    echo $_SESSION['username'];
                    if ($_SESSION['role'] == 'Admin') {
                        echo '<a href="/admin.php"><button type="button" class="btn btn-outline-light me-2">Espace Admin</button></a>';
                    }
                    echo '
                         <a href="/logout.php"><button type="button" class="btn btn-warning me-3">Déconnexion</button></a>';
                } else {
                    echo '<div class="d-flex align-items-center">
                    <a href="/login.php"><button type="button" class="btn btn-outline-light px-3 me-2">
                        Connexion
                    </button></a>
                    <a href="/inscription.php"><button type="button" class="btn btn-warning me-3">
                        S\'inscrire
                    </button></a>
                </div>';
                }
                ?>
            </div>
            <!-- Collapsible wrapper -->
        </div>

        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>
<?php