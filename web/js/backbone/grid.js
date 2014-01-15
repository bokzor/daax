function grid(){

    var DeleteCell = Backgrid.Cell.extend({
        template: _.template('Edit'),
        events: {
          "click": "edit"
        },
        edit: function (e) {
          e.preventDefault();
          editRow('article', this.model.id);
        },
        render: function () {
          this.$el.html(this.template());
          this.delegateEvents();
          return this;
        }
    });

    var columns = [{
    name: "id", // The key of the model attribute
    label: "ID", // The name to display in the header
    editable: false, // By default every cell in a column is editable, but *ID* shouldn't be
    // Defines a cell type, and ID is displayed as an integer without the ',' separating 1000s.
    cell: Backgrid.IntegerCell.extend({
      orderSeparator: ''
    })
  }, {
    name: "name",
    label: "Name",
    // The cell type can be a reference of a Backgrid.Cell subclass, any Backgrid.Cell subclass instances like *id* above, or a string
    cell: "string", // This is converted to "StringCell" and a corresponding class in the Backgrid package namespace is looked up
    editable: false,
  }, {
    name: "category",
    label: "Categorie",
    cell: "string", // An integer cell is a number cell that displays humanized integers
    editable: false,
  }, {
    name: "prix",
    label: "Prix",
    cell: "number", // An integer cell is a number cell that displays humanized integers
    editable: false,
  },
  {
    name: "weight",
    label: "Edit",
    cell: DeleteCell,
  }

  ];

  // Set up a grid to use the pageable collection
  var pageableGrid = new Backgrid.Grid({
    columns: columns,
    collection: app.collections.articles
  });

  // Render the grid
  var $example2 = $("#test");
  $example2.append(pageableGrid.render().$el)

  // Initialize the paginator
  var paginator = new Backgrid.Extension.Paginator({
    collection: app.collections.articles
  });

  // Render the paginator
  $example2.append(paginator.render().$el);

  // Initialize a client-side filter to filter on the client
  // mode pageable collection's cache.
  var filter = new Backgrid.Extension.ClientSideFilter({
    collection: app.collections.articles.fullCollection,
    fields: ['name', 'category']
  });

  // Render the filter
  $example2.prepend(filter.render().$el);

  // Add some space to the filter and move it to the right
  filter.$el.css({float: "right", margin: "20px"});

}