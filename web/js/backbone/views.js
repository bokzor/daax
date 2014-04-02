app.Views.main = Backbone.View.extend({
    initialize: function() {
        //this.displayOrder();
    },
    displayOrder: function() {

    }


});

app.Views.actualOrder = Backbone.View.extend({
    el: $('#message-block'),
    initialize: function() {
        this.listArticle = _.template($('#actualOrder').html());
        _.bindAll(this, 'render');
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },

    render: function() {
        var renderedContent = this.listArticle({
            commande: this.collection.toJSON()
        });

        $(this.el).html(renderedContent);
        return this;
    }
});

app.Views.commandeLive = Backbone.View.extend({
    el: $('#commandeLiveContainer'),
    initialize: function() {
        this.commandeLive = _.template($('#commandeLive').html());
        _.bindAll(this, 'render');
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },

    render: function() {
        var renderedContent = this.commandeLive({
            commandesLive: this.collection.toJSON()
        });
        $(this.el).html(renderedContent);
        return this;
    }
});


app.Views.commandeFullLive = Backbone.View.extend({

    initialize: function() {
        this.commandeLive = _.template($('#commandeFullLive').html());
        $('[id^=commandeFullLive-]').remove();
        _.bindAll(this, 'render');
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },
    render: function() {
        var renderedContent = this.commandeLive({
            commandesLive: this.collection.toJSON()
        });
        $(this.el).html(renderedContent);
        return this;
    }
});

app.Views.totalCommandeFullLive = Backbone.View.extend({

    initialize: function() {
        this.commandeLive = _.template($('#totalCommandeFullLive').html());
        _.bindAll(this, 'render');
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },
    render: function() {
        var renderedContent = this.commandeLive({
            total: this.collection.toJSON()
        });
        $(this.el).html(renderedContent);
        return this;
    }
});