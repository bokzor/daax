var app = {
    // Classes
    Collections: {},
    Models: {},
    Views: {},
    Routes: {},
    // Instances
    collections: {},
    models: {},
    views: {},
    routes: {},
    config: {
        url: 'http://lespoules2.order'
    },

    init: function() {
        //document.oncontextmenu = new Function("return false");
        //document.onselectstart = new Function("return false");

        this.collections.articles = new this.Collections.articles;
        this.collections.categories = new this.Collections.categories;
        this.collections.commande = new this.Collections.commande;
        this.collections.articles.fetch();
        this.collections.categories.fetch();
        // on cree la vue qui va afficher les catégories
        this.views.cats = new this.Views.CatsView({
            collection: this.collections.categories,
            attributes: {
                level: 0
            }
        });
        // on affiche les catégories
        this.views.cats.render();
        this.infos = new this.Models.infos;
        this.views.articles = new this.Views.ArticlesView({
            collection: this.collections.articles,
            attributes: {
                cat_id: 0
            }
        });
        this.views.articlesCommandes = new this.Views.ArticlesCommandesView({
            collection: this.collections.commande,
            el: $('#right-drawer ul')
        });
        this.views.barreAction = new app.Views.BarreActionView({
            el: $('#barre-action')
        });


        console.log('window.App Initialized');
        Backbone.history.start();
    }
}