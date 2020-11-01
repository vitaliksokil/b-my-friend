@extends('main')

@section('content')

@include('includes.header')
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
                                <h2>Name Surname asdasdasdasd</h2>
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
@endsection
