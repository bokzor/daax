var app = {
  // Classes
  Collections: {},
  Models: {},
  Views: {},
  // Instances
  collections: {},
  models: {},
  views: {},
  init: function () {
    // Initialisation de l'application ici
    this.collections.commande = new this.Collections.commande;
    this.collections.commandeLive = new this.Collections.commandeLive;
    this.collections.commandeFullLive = new this.Collections.commandeFullLive;
    this.collections.totalCommandeFullLive = new this.Collections.totalCommandeFullLive;
    this.collections.articles = new this.Collections.articles;
    //this.views.main = new this.Views.main();
    this.views.actualOrder = new this.Views.actualOrder({collection : this.collections.commande});
    this.views.commandeLive = new this.Views.commandeLive({collection : this.collections.commandeLive});
    this.models.infos = new this.Models.infos;
    //this.views.commandeFullLive = new this.Views.commandeFullLive({collection : this.collections.commandeFullLive});
  
  }
};

$(document).ready(function () {
  // On lance l'application une fois que notre HTML est chargé
  app.init();
  // Call template init (optional, but faster if called manually)
  $.template.init();  
  //
  isReady();
  // Init payment layout
  payment();
  
});