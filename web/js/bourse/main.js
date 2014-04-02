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
        this.collections.bourse = new this.Collections.bourse;
        //this.views.main = new this.Views.main();
    this.views.actualOrder = new this.Views.actualOrder({collection : this.collections.commande});
    this.views.commandeLive = new this.Views.commandeLive({collection : this.collections.commandeLive});
    this.views.commandeFullLive = new this.Views.commandeFullLive({collection : this.collections.commandeFullLive});
  
  },
 init2: function(){
    this.collections.bourse = new this.Collections.bourse;
 }

};

$(document).ready(function () {

  
  
});