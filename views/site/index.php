<?php

/** @var yii\web\View $this */

$this->title = 'HBO-MAX Style Portal';
?>

<style>
    body {
        background-color: #141414;
        color: #ffffff;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .navbar-custom {
        background-color: #000000;
        padding: 1rem 2rem;
    }

    .navbar-custom a {
        color: #ffffff;
        font-weight: bold;
        margin-right: 20px;
        text-decoration: none;
    }

    .navbar-custom a:hover {
        color: #b636ff;
    }

    .hero {
        background: url('https://d30gl8nkrjm6kp.cloudfront.net/articulos/articulos-425772.jpg') no-repeat center center;
        background-size: cover;
        height: 500px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    
    
    .hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(20, 20, 20, 0.6); 
        z-index: 1;
    }
    .hero h1,
    .hero p,
    .hero .btn {
        z-index: 2;
        position: relative;
    }

    .hero h1 {
        font-size: 3rem;
        color: #ffffff;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.3rem;
        color: #d1d1d1;
        margin-bottom: 1.5rem;
    }

    .hero .btn {
        background-color: #b636ff;
        border: none;
        padding: 0.8rem 1.5rem;
        color: white;
        font-size: 1rem;
        border-radius: 30px;
        text-decoration: none;
    }

    .movie-section {
        padding: 3rem 2rem;
    }

    .movie-section h2 {
        color: #ffffff;
        margin-bottom: 2rem;
    }

    .movie-card {
        background-color: #1f1f1f;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
        transition: transform 0.3s;
    }

    .movie-card:hover {
        transform: scale(1.05);
    }

    .movie-card img {
        width: 100%;
        border-radius: 6px;
    }

    .movie-card-title {
        font-size: 1.2rem;
        margin-top: 0.5rem;
    }

    .navbar-custom {
        width: 100vw; 
        left: 0;
        top: 0;
        position: relative; 
        background: linear-gradient(to right, #000000, #3b0a78, #b636ff);
        padding: 1rem 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        margin: 0;
    }


    .navbar-custom a,
    .navbar-custom .dropdown-toggle {
        color: #ffffff !important;
        font-weight: bold;
        margin-right: 20px;
        font-size: 1.05rem;
        transition: color 0.3s;
    }

    .navbar-custom a:hover,
    .navbar-custom .dropdown-toggle:hover {
        color: #ffb3ff !important;
        text-decoration: none;
    }

    .navbar-custom i {
        margin-right: 6px;
        color: #ff66ff;
        font-size: 1.1rem;
    }

       
    .navbar-custom .dropdown-menu {
        background: linear-gradient(to right, #000000, #3b0a78, #b636ff);
        border: none;
    }

    
    .navbar-custom .dropdown-menu .dropdown-item {
        color: #ffffff;
        font-weight: bold;
    }

    .navbar-custom .dropdown-menu .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.1); 
        color: #ffb3ff;
    }


</style>



<div class="hero">
    <h1>HBO-MAX</h1>
    <p>Disfruta de las mejores películas y series en un solo lugar</p>
    <a class="btn" href="#">Explorar ahora</a>
</div>


<div class="movie-section container">
    <h2>Películas destacadas</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="movie-card">
                <img src="https://www.themoviedb.org/t/p/original/74xTEgt7R36Fpooo50r9T25onhq.jpg" alt="The Batman Poster" style="height: 500px;">
                <center><div class="movie-card-title">THE BATMAN</div></center>
            </div>
        </div>
        <div class="col-md-4">
            <div class="movie-card">
                <img src="https://www.themoviedb.org/t/p/original/iGoXIpQb7Pot00EEdwpwPajheZ5.jpg" alt="Harry Potter 7 Parte 1" style="height: 500px;">
                <center><div class="movie-card-title">HARRY POTTER Y LAS RELIQUIAS DE LA MUERTE: PARTE 2</div></center>
            </div>
        </div>
        <div class="col-md-4">
            <div class="movie-card">
                <img src="https://www.themoviedb.org/t/p/original/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg" alt="Interestelar" style="height: 500px;">
                <center><div class="movie-card-title">INTERESTELAR</div></center>
            </div>
        </div>
    </div>
</div>
