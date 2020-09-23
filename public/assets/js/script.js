window.onload = function () {

    ///////////////////////////////// COMMUN ///////////////////////////

    //FOOTER MOBILE
    $('.bas').click(function () {
        $('.cache').toggle();
    })

    //////////////////////////////// ACCUEIL /////////////////////////////
    //COOKIES MOBILE
    //apparition
    var cookiesMobile = document.getElementById('cookiesMobile');

    function timerMob() {
        cookiesMobile.style.display = 'block';
    }
    setTimeout(timerMob, 1000);

    //disparition
    $('#accepteMob').click(function () {
        $('#cookiesMobile').hide();
    })

    $('#croix').click(function () {
        $('#cookiesMobile').hide();
    })

    //COOKIES DESKTOP
    //apparition
    var cookiesConteneur = document.getElementById('cookiesConteneur');

    function timer() {
        cookiesConteneur.style.display = 'block';
    } setTimeout(timer, 1000);

    //disparition
    $('#accepte').click(function () {
        $('#cookiesConteneur').hide();
    })

    //TEXTE INSCRIPTION COLLAPSE MOBILE
    $('#afficher').click(function () {
        console.log("afficher")
        $('#afficher').hide();
        $('.masque').show();
        $('#reduire').show();
        $('#points').hide();
    })

    $('#reduire').click(function () {
        $('.masque').hide();
        $('#afficher').show();
        $('#reduire').hide();
        $('#points').show();
    })

    //ACTUALITES MOBILE
    $('#voirPlus').click(function () {
        $('#post3, #post4').show();
        $('#voirMoins').show();
        $('#voirPlus').hide();
    })

    $('#voirMoins').click(function () {
        $('#post3, #post4').hide();
        $('#voirMoins').hide();
        $('#voirPlus').show();
    })

    ///////////////////////////// MESSAGERIE ////////////////////////////////

    // AFFICHER CONTACTS/MESSAGES MOBILE
    $('.lienMessages').click(function () {
        $('.contactMob').hide();
        $('.messagerieMob').show();
    })

    $('.lienContacts').click(function () {
        $('.contactMob').show();
        $('.messagerieMob').hide();
    })

    //SCROLL BAS MESSAGERIE
    $('.lienMessages').click(function () {
        $('#fin')[0].scrollIntoView(false);
    })

    //COULEUR LIENS CLIQUE MOBILE
    $(function () {
        $('.liens > .nav-item').on('click', function () {
            $('.liens > .nav-item').removeClass('lien');
            $(this).addClass('lien');
        })
    })

    //CONTACTS CLIQUE
    $(function () {
        $('.list-group > .media').on('click', function () {
            $('.list-group > .media').removeClass('activeProfil');
            $(this).addClass('activeProfil');
        });
    });


} //FERMETURE WINDOW ONLOAD

