app.Models.articleCommande = Backbone.Model.extend({
    defaults: {
        count: 1,
        supplements: undefined,
    },
    idAttribute: "id",
    initialize: function Doc() {
        this.set({
            htmlId: this.cid
        })
    },
});


app.Models.infos = Backbone.Model.extend({
    defaults: {
        tableId: 0,
        commandeId: 0,
        serverId: 0,
        page: '/',
    },
});

app.Models.articleCommande = Backbone.Model.extend({
    defaults: {
        count: 1,
        supplements: undefined,
        promo_id: 0,
    },
    idAttribute: "id",
    initialize: function Doc() {
        this.set({
            htmlId: this.cid
        })
        this.on('change', function() {
            updatePrixTotal();
        })
    },
});

app.Models.reduction = Backbone.Model.extend({
    defaults: {},
});

app.Collections.reduction = Backbone.Collection.extend({
    url: '/get/reduction.json',
    model: app.Models.reduction,
});



// collections backbone pour la commande en cours
app.Collections.commande = Backbone.Collection.extend({
    model: app.Models.articleCommande,
    initialize: function() {},
});

// model backbabone de la commande en cours
app.Models.commande = Backbone.Model.extend({
    defaults: {},
    initialize: function Doc() {}
});

app.Collections.commandeLive = Backbone.Collection.extend({
    model: app.Models.commande,
    initialize: function() {

    },

});

app.Collections.commandeFullLive = Backbone.Collection.extend({
    model: app.Models.commande,
    initialize: function() {

    },

});

app.Collections.totalCommandeFullLive = Backbone.Collection.extend({
    model: app.Models.article,
    initialize: function() {

    },

});


app.Models.bourse = Backbone.Model.extend({
    defaults: {
        count: 1,
    },
    initialize: function Doc() {
        console.log('Doc Constructor');
    }
});