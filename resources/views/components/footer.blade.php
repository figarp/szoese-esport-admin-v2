<footer class="bg-primary text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Hasznos linkek</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Főoldal</a></li>
                    <li><a href="https://szoese.hu/" target="_blank">SZoESE</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Kapcsolat</h5>
                <p>Cím: Szombathely, Károlyi Gáspár tér 4, 9700</p>
                <p>Email: info@esportszoese.hu</p>
            </div>
            <div class="col-md-4">
                <h5>Kövess minket!</h5>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="https://www.facebook.com/szoese.esport" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://discord.gg/8eNhAWSy58" target="_blank">
                            <i class="fa-brands fa-discord"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row footerImgContainer">
            <a href="https://szoese.hu" target="_blank">
                <img src="{{ Vite::asset('resources/images/szoese_logo_fekete.png') }}" alt="" title="SZoESE">
            </a>
        </div>
    </div>
</footer>
