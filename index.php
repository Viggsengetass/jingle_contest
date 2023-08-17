<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Ma Plateforme</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student_dashboard.php">Tableau de bord élève</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="teacher_dashboard.php">Tableau de bord professeur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Se connecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="text-animation-container">
        <p class="text-animation" aria-label="CodePen">
            <span class="animate-text" data-text="Jingle">Jingle</span><br>
            <span class="animate-text" data-text="-">-</span><br>
            <span class="animate-text" data-text="Contest">Contest</span>
        </p>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-12 text-center main-content">
            <h1 class="display-4">Bienvenue sur Ma Plateforme</h1>
            <p class="lead">Découvrez et évaluez les jingles soumis par les élèves dans notre concours de création musicale !</p>
            <a href="ranking.php" class="btn btn-primary btn-lg">Voir le classement</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
