app.Views.main = Backbone.View.extend({
  initialize: function () {
    console.log('Views initialisé'); 
    //this.displayOrder();
  },
  displayOrder: function(){

  }
  
  
});

app.Views.actualOrder = Backbone.View.extend({
    el : $('#message-block'),
    initialize : function () {
        console.log('on initialise la vue actualOrder')
        this.listArticle = _.template($('#actualOrder').html());
        _.bindAll(this, 'render');  
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },

    render : function () {
        var renderedContent = this.listArticle({ commande : this.collection.toJSON() });

        $(this.el).html(renderedContent);
        return this;
    }
});

app.Views.commandeLive = Backbone.View.extend({
    el : $('#commandeLiveContainer'),
    initialize : function () {
        console.log('on initialise la vue commandeLive')
        this.commandeLive = _.template($('#commandeLive').html());
        _.bindAll(this, 'render');  
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },

    render : function () {
        console.log('on met a jour la vue live');
        var renderedContent = this.commandeLive({ commandesLive : this.collection.toJSON() });
        $(this.el).html(renderedContent);
        return this;
    }
});


app.Views.commandeFullLive = Backbone.View.extend({
    
    initialize : function () {
        console.log('on initialise la vue commandeFullLive')
        this.commandeLive = _.template($('#commandeFullLive').html());
        $('[id^=commandeFullLive-]').remove();
        _.bindAll(this, 'render');  
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },
    render : function () {
        console.log('on met a jour la vue full live');
        var renderedContent = this.commandeLive({ commandesLive : this.collection.toJSON() });
        $(this.el).html(renderedContent);
        return this;
    }
});

app.Views.totalCommandeFullLive = Backbone.View.extend({
    
    initialize : function () {
        console.log('on initialise la vue TotalCommandeFullLive')
        this.commandeLive = _.template($('#totalCommandeFullLive').html());
        _.bindAll(this, 'render');  
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },
    render : function () {
        console.log('on met a jour la vue total full live');
        var renderedContent = this.commandeLive({ total : this.collection.toJSON() });
        $(this.el).html(renderedContent);
        return this;
    }
});

app.Views.bourse = Backbone.View.extend({
    
    initialize : function () {
        this.bourse = _.template($('#bourse').html());
        _.bindAll(this, 'render');  
        this.collection.bind('change', this.render);
        this.collection.bind('add', this.render);
        this.collection.bind('remove', this.render);
        this.collection.bind('reset', this.render);

    },
    render : function () {
        var renderedContent = this.bourse({ bourse : this.collection.toJSON() });
        $(this.el).html(renderedContent);
        return this;
    }
});



