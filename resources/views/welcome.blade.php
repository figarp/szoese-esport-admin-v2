<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SZoESE E-Sport Főoldal</title>
    <link rel="shortcut icon" href="{{ Vite::asset('resources/images/szoese_esport_logo_32.png') }}" type="image/x-icon">
    <meta name="description"
        content="A SzoESE E-sport a Szombathelyi Egyetemi Sportegyedület szakosztálya. Célunk a hallgatók és az érdeklődők számára lehetőséget biztosítani az e-sporttal kapcsolatos tevékenységekkel való foglalkozásra, versenyeken való részvételre és a közösség építésére. Főként PC-s versenyjátékokkal foglalkozunk, de más platformokon is nyitottak vagyunk a versenyekre és közös játékra. A szakosztály rendszeresen szervez versenyeket és közösségi eseményeket, valamint kapcsolatot tart más e-sport szervezetekkel is a kapcsolatok bővítése és tapasztalatcsere érdekében.">
    <link rel="canonical" href="https://esportszoese.hu/" />
    <meta property="og:title" content="SZoESE E-Sport">
    <meta property="og:description"
        content="A SzoESE E-sport a Szombathelyi Egyetemi Sportegyedület szakosztálya. Célunk a hallgatók és az érdeklődők számára lehetőséget biztosítani az e-sporttal kapcsolatos tevékenységekkel való foglalkozásra, versenyeken való részvételre és a közösség építésére. Főként PC-s versenyjátékokkal foglalkozunk, de más platformokon is nyitottak vagyunk a versenyekre és közös játékra. A szakosztály rendszeresen szervez versenyeket és közösségi eseményeket, valamint kapcsolatot tart más e-sport szervezetekkel is a kapcsolatok bővítése és tapasztalatcsere érdekében.">
    <meta property="og:image" content="{{ Vite::asset('resources/images/szoese_esport_logo_512.png') }}">
    <meta property="og:url" content="https://esportszoese.hu/">
    <meta property="og:type" content="website">


    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/18c03d310a.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</head>

<body>
    <x-nav-bar />
    <div class="container-lg mt-5">
        <div class="row container align-items-center mb-5 mt-5">
            <div class="col-md-6">
                <img src="{{ Vite::asset('resources/images/szoese_esport_logo_512.png') }}" alt=""
                    class="img-fluid">
            </div>
            <div class="col-md-6">
                <h1>SZoESE E-Sport Szakosztály</h1>
                <span>A <strong>Szombathelyi Egyetemi Sportegyesület</strong> E-Sport szakosztálya</span>
                <figure class="mt-5">
                    <blockquote class="blockquote">
                        <p mt-2>
                            Üdvözlünk a szombathelyi egyetemen működő e-sport szakosztály weboldalán!<br><br>
                            Amennyiben kíváncsi vagy a tevékenységünkre, olvasd el a <a
                                href="#about_us">bemutatkozásunkat</a>! 😉<br>
                            Ha készen állsz a csatlakozásra, <a href="{{ asset('register') }}">regisztrálj</a> az
                            oldalra, majd böngéssz a játékaink között és csatlakozz a szimpatikus csoportokhoz!
                        </p>
                    </blockquote>
                </figure>
            </div>
        </div>
        <hr>

        <section id="about_us" class="mt-5">
            <h2>Rólunk</h2>
            <div>
                <p>
                    A SZoESE E-Sport Szakosztály egy még friss, ugyanakkor lelkes közösség az egyetemünkön,
                    melynek tagjai elkötelezettek a gaming által nyújtott versenyzési lehetőségek iránt.
                    Szeretünk játszani kikapcsolódásként, azonban elhivatott tagjaink nem csak emiatt csatlakoztak
                    hozzánk.
                    Az elektronikus sportok egy új környezetben hozzák el a versenyzés örömeit, fájdalmait, a
                    versenyszellemet. Ezt a sokak által még nem ismert élményt szeretnénk elhozni és terjeszteni
                    Szombathelyen.
                </p>
                <p>
                    Célunk, hogy az egyetemen mindenkinek lehetőséget biztosítsunk eme új ág megismerésére és
                    gyakorlására.
                    Kompetitív tagjaink rendszeresen vesznek részt edzőmeccseken, a versenyjátékaik rejtelmeit együtt
                    ismerik ki, hogy hazai megméredtetéseken a lehető legjobb formájukat nyújthassák!
                </p>
            </div>
        </section>
        <section id="structure" class="mt-5">
            <h2>A szakosztály felépítése</h2>
            <div>
                <p>
                    A szakosztály különböző játékokra van felbontva, ezeket <strong>Játékoscsoportoknak</strong>
                    hívjuk, amikért a
                    kinevezett <strong>Csoportvezetők</strong> felelnek. <a href="{{ route('groups.index') }}">A
                        játékoscsoportokat ide
                        kattitva lehet megtekinteni!</a>
                </p>
                <p>
                    Az oldalon regisztrációt követően lehetőség van jelentkezni több csoportba is. Amennyiben
                    legalább 1 csoport elfogadta a jelentkezést, tag lesz belőled! Fontos megjegyezni, hogy tag csak
                    az egyetemünk jelenlegi
                    vagy volt hallgatója lehet. Külsős jelentkezők egyéni elbíráláson esnek át.
                </p>
            </div>
        </section>
    </div>

    <x-footer />
</body>

</html>
