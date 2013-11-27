app.Models.article = Backbone.Model.extend({
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
  model: app.Models.article,
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
