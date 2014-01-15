app.Models.article = Backbone.Model.extend({
    defaults: {},
    initialize: function Doc() {}
});

app.Collections.articles = Backbone.Collection.extend({
    model: app.Models.article,
    comparator: 'name',
    url: app.config.url + '/rest/article.json',
    recherche: function(query) {
        app.views.articles.attributes['recherche'] = query;
        app.views.articles.attributes['cat_id'] = 0;
        app.views.articles.recherche();
    }
});

app.Models.category = Backbone.Model.extend({
    defaults: {},

});

app.Collections.categories = Backbone.Collection.extend({
    model: app.Models.category,
    url: app.config.url + '/rest/category.json',
    initialize: function() {
        this.on('sync', function() {
            app.views.cats.render();
            console.log('catégorie chargée');
        });
    }
});


app.Models.infos = Backbone.Model.extend({
    defaults: {
        tableId: -1,
        commandeId: -1,
        serverId: -1,
        page: '/',
        bancontact: 0,
        cash: 0,
        statut: 0,
    },
    annuler: function() {
        app.collections.commande.reset();
        this.clear().set(this.defaults);
    }
});

app.Models.articleCommande = Backbone.Model.extend({
    defaults: {
        count: 1,
        supplements: '',
        etat: '',
    },
    idAttribute: "id",
    initialize: function Doc() {
        this.set({
            htmlId: this.cid
        })
    },
    toggleActive: function() {
        console.log('salut');
        if (this.get('etat') === '') {
            this.set({
                etat: 'active'
            });
        } else {
            this.set({
                etat: ''
            });
        }
    }
});


app.Collections.commande = Backbone.Collection.extend({
    model: app.Models.articleCommande,
    initialize: function() {},
    chargerTable: function(table_id) {
        this.reset();
        url = app.config.url + '/get/commande/table_id/' + table_id + '.json';
        $.getJSON(url, function(data) {
            $.each(data['articles'], function(key, val) {
                for (i = 0; i < val['count']; i++) {
                    var article = {
                        'prix': val['prix'],
                        'name': val['name'],
                        'id_article': val['id'],
                        'supplements': val['supplements'],
                        'comment': val['comment']
                    };
                    app.collections.commande.addArticle(article);
                }
            });
            // on vient de charger les commandes d'une table. Elle devient donc actie
            app.infos.set('tableId', table_id);

        });
    },
    chargerId: function(id) {
        this.reset();
        url = app.config.url + '/get/commande/id/' + id + '.json';
        $.getJSON(url, function(data) {
            $.each(data['articles'], function(key, val) {
                for (i = 0; i < val['count']; i++) {
                    var boisson = {
                        'prix': val['prix'],
                        'name': val['name'],
                        'id': val['id'],
                        'supplements': val['supplements'],
                        'comment': val['comment']
                    };
                    app.collections.commande.add(articleCommande);
                }
            });
            // on vient de charger une commande. Elle devient donc active
            app.infos.set('commandeId', id);
        });
    },
    enregister: function(table_id) {
        $.ajax({
            type: 'POST',
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            url: app.config.url + '/save/commande/' + table_id,
            data: {
                table_id: table_id,
                commande: app.collections.commande.toJSON(),
                commande_id: app.infos.get('commandeId'),
            },
            // Il faudra lancer l'impression du ticket ici
            success: function() {
                app.infos.annuler();
            },
        });
    },
    modifier: function() {
        $.ajax({
            type: 'POST',
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            url: app.config.url + '/modif/commande',
            data: {
                table_id: app.infos.get('tableId'),
                commande: app.collections.commande.toJSON(),
                commande_id: app.infos.get('commandeId'),
            },
            // Il faudra lancer l'impression du ticket ici
            success: function() {
                app.infos.annuler();
            },

        });
    },
    encaisser: function(type) {
        if (app.infos.get('tableId') > 0) {
            var url = app.config.url + '/commande/archiver/' + app.infos.get('tableId');
        } else if (app.infos.get('commandeId') > 0) {
            var url = app.config.url + '/commande/archiver/commande/' + app.infos.get('commandeId');
        } else {
            var url = app.config.url + '/save/commande/' + app.infos.get('tableId');
        }
        if (type === -1) {
            app.infos.set({
                cash: app.views.articlesCommandes['total']
            })
        }
        // on a encaisse directement le compte juste
        else if (type === -2) {
            app.infos.set({
                bancontact: app.views.articlesCommandes['total']
            })
        }
        // on offre la commande
        else if (type === -3) {
            app.infos.set({
                statut: 5
            });
        }
        // on envoit les données pour enregistrer la commande
        $.ajax({
            type: 'POST',
            url: url,
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            data: {
                bancontact: app.infos.get('bancontact'),
                cash: app.infos.get('cash'),
                commande: app.collections.commande.toJSON(),
                table_id: app.infos.get('tableId'),
                commande_id: app.infos.get('commandeId'),
                statut_id: app.infos.get('statut'),
            },
            success: function() {
                app.infos.annuler();
            }
        });
    },
    deleteArticle: function() {
        this.remove(this.where({
            etat: "active"
        }));
    },
    addArticle: function(article) {
        findArticle = app.collections.commande.findWhere({
            'id_article': article.id_article
        });
        if (findArticle != undefined && JSON.stringify(findArticle.get('supplements')) == JSON.stringify(article.supplements)) {
            findArticle.set({
                'count': findArticle.get('count') + 1
            });
        } else {
            app.collections.commande.add(article);
        }
    },
});


app.Models.commande = Backbone.Model.extend({
    defaults: {},
    initialize: function Doc() {}
});

app.Collections.commandeLive = Backbone.Collection.extend({
    model: app.Models.commande,
    initialize: function() {

    },

});