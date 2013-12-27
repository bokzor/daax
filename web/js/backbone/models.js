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

app.Models.article = Backbone.Model.extend({
  defaults: {
  },
  initialize: function Doc() {
  }
});

app.Collections.articles = Backbone.PageableCollection.extend({
  model: app.Models.article,
  url: "/rest/article.json",
  state: {
      pageSize: 15
    },
  mode: "client" // page entirely on the client side
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
  },
    idAttribute: "id",
  initialize: function Doc() {
      this.set({
        htmlId: this.cid
    })
  },
});


app.Collections.commande = Backbone.Collection.extend({
  model: app.Models.articleCommande,
  initialize: function() {
  },
});


app.Models.commande = Backbone.Model.extend({
  defaults: {
  },
  initialize: function Doc() {
  }
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
