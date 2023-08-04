<?php
session_start();
if (isset($_SESSION["username"])) {
    if ($_SESSION['Etat'] == 'Banni') {
        header('Location: desactive.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/testparticles/particles.css">
    <!-- <link rel="stylesheet" href="assets/MDB5-Pro-6.1.0/plugins/css/all.min.css"> -->
    <link rel="stylesheet" href="assets/MDB5-Pro-6.1.0/css/mdb.dark.min.css">
    <title></title>
</head>
<body style="background-color: black;">
<?php
//include('assets/includes/Header.php');
//if (isset($_SESSION["username"])) {

?>
<!-- <div class="sucess">

        <h1>Bienvenue <?php //echo $_SESSION['username'];
?>!</h1>

        <a href="logout.php">déconnexion</a>


        <div>

        </div>
    </div>
    <?php
//} else {
?>
    <a href="login.php">connexion</a> -->
<?php
//}
?>
<body style="background-color: black;">
<div class="main">
    <!-- particles.js container -->
    <div id="particles-js">

        <!--background image  -->

        <div class="background-image"></div>
        <!-- testanime -->
        <div class="circle-wraper">
            <div id="circles">
                <div class="circle c1">
                    <div class="circle c2">
                        <div class="circle c3">
                            <div class="circle c4">
                                <div class="circle c5">
                                    <div class="circle c6">
                                        <div class="circle c7">
                                            <div class="circle c8">

                                                <h3><div class="button">
                                                        <a id="push" href="/first/first.php"> <img id="buttonlogo" src="/assets/img/Logo.png" alt="">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </a>
                                                    </div></h3></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></div>
            </div>
        </div>
    </div>
</div>
<!-- testanim -->
<!-- <div id="animated-example" class="animated rotateInDownRight"></div>
<button onclick="myFunction()">Reload page</button>

<script>
   function myFunction() {
      location.reload();
   }
</script> -->

<!-- Lampion mouv -->

<div class="lampion" id="lampion2">
    <!-- <a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details"> -->
    <img id="lampion_mouv" src="/assets/img/lampion2.webp" alt="" >
    </a>
</div>

<!-- lampion mouv 2 -->

<div class="lampion" id="lampion2">
    <!-- <a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details"> -->
    <img id="lampion_mouv2" src="/assets/img/lampion2.webp" alt="" >
    </a>
</div>

<!-- lampion mouv 3

<div class="lampion" id="lampion3"><a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details">
  <img id="lampion_mouv3" src="/assets/img/lampion2.webp" alt="" >
  </a>
</div>

<!-- lampion mouv 2 -->

<!-- <div class="lampion" id="lampion4"><a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details">
  <img id="lampion_mouv4" src="/assets/img/lampion2.webp" alt="" >
  </a>
</div>

<!-- lampion mouv 2 -->

<!-- <div class="lampion" id="lampion5"><a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details">
  <img id="lampion_mouv5" src="/assets/img/lampion2.webp" alt="" >
  </a>
</div> -->

<!-- lampion mouv 2 -->

<!-- <div class="lampion" id="lampion6"><a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details">
  <img id="lampion_mouv6" src="/assets/img/lampion2.webp" alt="" >
  </a>
</div> -->

<!-- lampion mouv 2 -->

<!-- <div class="lampion" id="lampion7"><a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details">
  <img id="lampion_mouv7" src="/assets/img/lampion2.webp" alt="" >
  </a>
</div> -->
<!-- lampion mouv 2 -->

<!-- <div class="lampion" id="lampion8"><a href="https://www.amazon.fr/dp/B0B49TP6GL?psc=1&ref=ppx_yo2ov_dt_b_product_details">
  <img id="lampion_mouv8" src="/assets/img/lampion2.webp" alt="" >
  </a>
</div> -->



<!-- <div class="lampion">
    <img id="lampion_mouv" src="/assets/img/lampion2.webp" alt="">
</div> --> --> -->

<!-- testanim -->
<!-- <div id="animated-example" class="animated rotateInDownRight"></div> -->
<!-- <button onclick="myFunction()">Reload page</button>

<script>
   function myFunction() {
      location.reload();
   }
</script> -->

<!-- cadre autres événements -->
<!-- <div class="event">
    <div id="cadre" >
        <img src="/assets/img/cadre.webp" alt="">
        <div id="contenu"><img src="/assets/img/event.webp" alt="" ></div>
</div> -->

<!-- test tedd -->
<!--
<div class="box">
    <div class="cards-container">
<div class="card-container">

  <div class="card">

    <div class="front">

      <img class="zhongli" src="/img/zhongli.png" alt="" height="300px" width="300px">

      <div class="card-titre">
       <h5>Ce beau jeune homme et
          personnage géo aux manières élégantes possède des connaissances qui vont bien
          au-delà de celles des gens ordinaires</h5>
      </div>
    </div>

    <div class="back">

      <div class="card-matériaux">
      </div>

    </div>

  </div>

</div>  -->
</div>

<video id="transition-video" src="/assets/mp4/transition.mp4" autoplay></video>


<script src="/testparticles/particles.js"></script>

<script src="/testparticles/particles.min.js"></script>

<script>
    window.addEventListener("DOMContentLoaded", function() {
        particlesJS.load('particles-js', '/testparticles/particlesjs-config.json', function() {
            console.log('che che che');

        });
    });
</script>
<script type="text/javascript" src="assets/MDB5-Pro-6.1.0/js/mdb.min.js"></script>
<!-- MDB PLUGINS -->
<script type="text/javascript" src="assets/MDB5-Pro-6.1.0/plugins/js/all.min.js"></script>
</body>
</body>
</html>