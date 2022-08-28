<?php
require_once "../templates/header.php";
?>
    </head>
    <body>
<?php
require_once "../templates/nav.php";
?>
<div>
    <form class="mt-5" method="post" action="/connexion">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="panel-heading">Connexion</div>
                </div>
                <div class="col-12">
                    <div class="p-3" style="background-color:#f3f3f3">
                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <?php
                                    if($flashbag != null){
                                ?>
                                    <div class="alert alert-<?= ($flashbag['status'] == "error")?'danger':'success' ?> mt-1 mb-1"><?= $flashbag['message'] ?></div>
                                <?php                   
                                    }
                                ?>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $user->getEmail() ?>">
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?= $user->getPassword() ?>">
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>
                        </div> 
                        <input type="text" class="d-none" name="action" value="login">
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </form>
<div>


<script>
    let email = document.getElementById("email");
    let remember = document.getElementById("remember");
    let login = localStorage.getItem("login");
    if(login != null){
        email.setAttribute("value",login);
        remember.checked = true;
    }
    remember.addEventListener("change",(e)=>{
        if(e.target.checked == true)localStorage.setItem("login",email.value);
        else localStorage.removeItem("login");
    })
    email.addEventListener("keyup",(e)=>{
        if(remember.checked == true)localStorage.setItem("login",email.value);
    })
</script>
<?php
require_once "../templates/footer.php";
?>
