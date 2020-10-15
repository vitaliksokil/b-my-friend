<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BMyFriend</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Piedra&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
</head>
<body>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div class="col-3">
                <div class="logo">
                    <a href="/">BMyFriend</a>
                </div>
            </div>
            <div class="col-9">
                <ul class="nav main-navigation justify-content-end">
                    <li class="nav-item">Chats</li>
                    <li class="nav-item">Groups</li>
                    <li class="nav-item">Settings</li>
                    <li class="nav-item">Logout</li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">

<section class="main">

    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="profile-image">
                    <img src="https://www.meme-arsenal.com/memes/663d52e3d3a81d5630eb165d4e4216d4.jpg" alt="">
                </div>
            </div>
            <div class="col-9">
                <div class="profile-info">
                    <div>
                        <div class="user-name">
                            <h2>Name Surname</h2>
                        </div>
                        <div class="user-status">
                            <h4>Some status of the user</h4>
                        </div>
                    </div>
                    <div>
                        <div class="user-followers">
                            <ul class="nav">
                                <li class="nav-item">Followers: <span>999</span></li>
                                <li class="nav-item"><i class="fas fa-users"></i>Friends: <span>999</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <section class="blog">
        <nav class="navbar navbar-dark bg-dark justify-content-center">
            <div class="col-3  text-right pr-5" style="border-right: 1px solid white">
                <div class="blog-item-menu-item">
                    <h5>Pictures</h5>
                </div>
            </div>
            <div class="col-3 pl-5">
                <div class="blog-item-menu-item">
                    <h5>Blog</h5>
                </div>
            </div>
        </nav>

        <div class="pictures">
            <div class="row">
                <div class="col-lg-4">
                    <img src="https://tulatrud.ru/wp-content/uploads/modnye-avatarki-dlya-vk_0.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img src="https://tulatrud.ru/wp-content/uploads/modnye-avatarki-dlya-vk_0.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img src="https://tulatrud.ru/wp-content/uploads/modnye-avatarki-dlya-vk_0.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img src="https://tulatrud.ru/wp-content/uploads/modnye-avatarki-dlya-vk_0.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img src="https://tulatrud.ru/wp-content/uploads/modnye-avatarki-dlya-vk_0.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img src="https://tulatrud.ru/wp-content/uploads/modnye-avatarki-dlya-vk_0.jpg" alt="">
                </div>
            </div>
        </div>
    </section>
</div>

</body>
</html>
