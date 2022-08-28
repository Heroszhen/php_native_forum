<div class="container">
    <div class="row">
        <section id="header-s1">
            Forum
        </section>
    </div>
</div>
<nav class="navbar navbar-expand-md bg-light" id="main-nav">
  <div class="container">
    <!-- <a class="navbar-brand" href="#">Navbar</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if($_SESSION['page']=='home')echo'active' ?>" aria-current="page" href="/">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tutoriels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Emploi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Actualité</a>
        </li>
        <?php
          if(isset($_SESSION['user'])){
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Bonjour <?= $_SESSION['user']["name"] ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Profil</a></li>
            <?php
              if($_SESSION['user']["roles"] = "admin"){
            ?>
              <li><a class="dropdown-item" href="/admin/tous-les-articles">Admin</a></li>
            <?php 
              }
            ?>
          </ul>
        </li>
        <?php 
          }
        ?>
        <?php
          if(!isset($_SESSION['user'])){
        ?>
          <li class="nav-item">
            <a class="nav-link <?php if($_SESSION['page']=='login')echo'active' ?>" href="/connexion">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($_SESSION['page']=='logup')echo'active' ?>" href="/inscription">Inscription</a>
          </li>
        <?php
          }else{
        ?>
          <li class="nav-item">
            <a class="nav-link <?php if($_SESSION['page']=='logout')echo'active' ?>" href="/deconnexion">Déconnexion</a>
          </li>
        <?php
          }
        ?>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>