app.Models.article = Backbone.Model.extend({
  defaults: {
    count: 1,
  },
  initialize: function Doc() {
    console.log('Doc Constructor');
  }
});

app.Models.bourse = Backbone.Model.extend({
  defaults: {
    count: 1,
  },
  initialize: function Doc() {
    console.log('Doc Constructor');
  }
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
    console.log('Commande Live Constructor');
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

app.Collections.bourse = Backbone.Collection.extend({
  model: app.Models.bourse,
  initialize: function() {
  },

});