var app = {
    // Classes
    Collections: {},
    Models: {},
    Views: {},
    // Instances
    collections: {},
    models: {},
    views: {},
    init: function() {
        // Initialisation de l'application ici
        this.collections.commande = new this.Collections.commande;
        this.collections.reduction = new this.Collections.reduction;
        this.collections.commandeLive = new this.Collections.commandeLive;
        this.collections.commandeFullLive = new this.Collections.commandeFullLive;
        this.collections.totalCommandeFullLive = new this.Collections.totalCommandeFullLive;

        this.views.actualOrder = new this.Views.actualOrder({
            collection: this.collections.commande
        });
        this.views.commandeLive = new this.Views.commandeLive({
            collection: this.collections.commandeLive
        });
        this.models.infos = new this.Models.infos;
        //this.views.commandeFullLive = new this.Views.commandeFullLive({collection : this.collections.commandeFullLive});
        console.log('app is init');
        // Call template init (optional, but faster if called manually)
        $.template.init();
        isReady();
        // Init payment layout
        payment();
        var event = document.createEvent('Event');
        event.initEvent('appInit', true, true);
        document.dispatchEvent(event);

    }
};

$(document).ready(function() {
    // On lance l'application une fois que notre HTML est chargé
    app.init();


});