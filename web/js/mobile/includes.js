head.load(
    '/js/mobile/libs/zepto.js',
    '/js/mobile/libs/snap.js',
    '/js/mobile/libs/underscore.js',
    '/js/mobile/libs/mustache.js',
    '/js/mobile/libs/backbone.js',
    '/js/mobile/libs/backbone.localstorage.js',
    '/js/mobile/libs/fastclick.js',
    '/js/mobile/app.js',
    '/js/mobile/app/models/models.js',
    '/js/mobile/app/views/views.js',
    '/js/mobile/app/routes/routes.js'

);

head.ready(function() {
    // on initialise l'application
    app.init()

    // on initialise les deux panels
    app.snapper = new Snap({
        element: document.getElementById('content')
    });

    $(document).on('click', '#toggle-left', function() {
        var data = app.snapper.state();
        if (data['state'] !== 'closed') {
            app.snapper.close();
        } else {
            app.snapper.open('left');
        }
    });

    $(document).on('click', '#toggle-right', function() {
        var data = app.snapper.state();
        if (data['state'] !== 'closed') {
            app.snapper.close();
        } else {
            app.snapper.open('right');
        }
    });

    // on active le fast click pour le mobile
    FastClick.attach(document.body);

    //var e = document.body;




})