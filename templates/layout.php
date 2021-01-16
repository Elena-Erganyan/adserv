<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> - AdServ</title>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" />
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header__container container">
            <div class="header__main">
                <div class="header__logo"><a <? if ($_SERVER['SCRIPT_NAME'] !== '/index.php'): ?>href="/index.php"<? endif; ?>>AdServ</a></div>
                <form class="header__search" method="get" action="search.php">
                    <input class="header__search-field" type="search" name="search">
                    <button class="header__search-btn" type="submit" name="find" value="Search for an ad">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.84 19.84"><path fill="darkviolet" d="M59.62,70.65l-4.79-4.79a8.23,8.23,0,1,0-1.46,1.47l4.79,4.79a1,1,0,1,0,1.46-1.46ZM44,65.18A6.17,6.17,0,1,1,48.32,67,6.13,6.13,0,0,1,44,65.18Z" transform="translate(-40.08 -52.58)"/></svg>
                    </button>
                </form>
                <div class="header__nav-btn" id="navBtn"><div></div></div>
                
                <? if (isset($user)): ?>
                <div class="header__logged">
                    <ul class="header__logged-list-1">
                        <li class="header__logged-item">
                            <p class="header__logged-username"><?=strip_tags($user["name"]); ?></p>
                        </li>
                        <li class="header__logged-item">
                            <a class="header__logged-link" href="logout.php">Logout</a>
                        </li> 
                    </ul>
                    <ul class="header__logged-list-2">
                        <li class="header__logged-item">
                            <a class="header__logged-link" href="my-ads.php">My ads</a>
                        </li>
                        <li class="header__logged-item">
                            <a class="header__logged-link" href="add-new-item.php">Add a new ad</a>
                        </li>
                    </ul>
                </div>
                <? else: ?>
                <div class="header__auth">
                    <ul class="header__auth-list">
                        <li class="header__auth-item">
                            <a class="header__auth-link" href="sign-in.php">Sign in</a>
                        </li>
                        <li class="header__auth-item">
                            <a class="header__auth-link" href="sign-up.php">Sign up</a>
                        </li>
                    </ul>
                </div>
                <? endif; ?>
            </div>
            <nav class="header__categories" id="categories">
                <ul class="header__categories-list">
                    <? foreach($categories as $category): ?>
                        <li class="header__item header__item--<?=$category["name"]; ?>">
                            <a class="header__link" href="ads-in-category.php?category=<?=$category["id"] ;?>"><?=$category["name"]; ?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
                <div class="header__close-btn" id="closeBtn"></div>
            </nav>
        </div>
    </header>
    <main class="main container">
        <?= $content; ?>
    </main>
    <footer class="footer">
        <div class="footer__container container">
            <div class="footer__socials">
                <ul class="footer__socials-list">
                    <li class="footer__socials-item footer__socials-item--fb">
                        <a class="footer__socials-link" href="#">Facebook
                            <svg width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg"><circle fill="none" cx="13.5" cy="13.5" r="12.667"/><path d="M14.26 20.983h-2.816v-6.626H10.04v-2.28h1.404v-1.364c0-1.862.79-2.922 3.04-2.922h1.87v2.28h-1.17c-.876 0-.972.322-.972.916v1.14h2.212l-.245 2.28h-1.92v6.625z"/></svg>
                        </a>
                    </li>
                    <li class="footer__socials-item footer__socials-item--ig">
                        <a class="footer__socials-link" href="#">Instagram
                            <svg width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg"><circle fill="none" cx="13.5" cy="13.5" r="12.687"/><path d="M13.5 8.3h2.567c.403.002.803.075 1.18.213.552.213.988.65 1.2 1.2.14.38.213.778.216 1.18v5.136c-.003.403-.076.803-.215 1.18-.213.552-.65.988-1.2 1.2-.378.14-.778.213-1.18.216h-5.135c-.403-.003-.802-.076-1.18-.215-.552-.214-.988-.65-1.2-1.2-.14-.38-.212-.78-.215-1.182V13.46v-2.566c.003-.403.076-.802.214-1.18.213-.552.65-.988 1.2-1.2.38-.14.778-.212 1.18-.215H13.5m0-1.143h-2.616c-.526.01-1.048.108-1.54.292-.853.33-1.527 1-1.856 1.854-.184.493-.283 1.014-.292 1.542v5.232c.01.526.108 1.048.292 1.54.33.853 1.003 1.527 1.855 1.856.493.184 1.015.283 1.54.293H16.117c.527-.01 1.048-.11 1.54-.293.854-.33 1.527-1.003 1.856-1.855.184-.493.283-1.015.293-1.54V13.46v-2.614c-.01-.528-.11-1.05-.293-1.542-.33-.853-1.002-1.525-1.855-1.855-.493-.185-1.014-.283-1.54-.293-.665.01-.89 0-2.617 0zm0 3.093c-2.51.007-4.07 2.73-2.808 4.898 1.26 2.17 4.398 2.16 5.645-.017.285-.495.434-1.058.433-1.63-.006-1.8-1.47-3.256-3.27-3.25zm0 5.378c-1.63-.007-2.64-1.777-1.82-3.185.823-1.41 2.86-1.4 3.67.017.18.316.276.675.278 1.04.006 1.177-.95 2.133-2.128 2.128zm4.118-5.524c0 .58-.626.94-1.127.65-.5-.29-.5-1.012 0-1.3.116-.067.245-.102.378-.102.418-.005.76.333.76.752z"/></svg>
                        </a>
                    </li>
                    <li class="footer__socials-item footer__socials-item--tw">
                        <a class="footer__socials-link" href="#">Twitter
                            <svg width="27" height="27" viewBox="0 0 27 27" xmlns="http://www.w3.org/2000/svg"><circle fill="none" cx="13.5" cy="13.5" r="12.687"/><path d="M18.38 10.572c.525-.336.913-.848 1.092-1.445-.485.305-1.02.52-1.58.635-.458-.525-1.12-.827-1.816-.83-1.388.063-2.473 1.226-2.44 2.615-.002.2.02.4.06.596-2.017-.144-3.87-1.16-5.076-2.78-.22.403-.335.856-.332 1.315-.01.865.403 1.68 1.104 2.188-.397-.016-.782-.13-1.123-.333-.03 1.207.78 2.272 1.95 2.567-.21.06-.43.09-.653.088-.155.015-.313.015-.47 0 .3 1.045 1.238 1.777 2.324 1.815-.864.724-1.956 1.12-3.083 1.122-.198.013-.397.013-.595 0 1.12.767 2.447 1.18 3.805 1.182 4.57 0 7.066-3.992 7.066-7.456v-.34c.49-.375.912-.835 1.24-1.357-.465.218-.963.36-1.473.42z"/></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="../js/script.js"></script>
</body>

</html>