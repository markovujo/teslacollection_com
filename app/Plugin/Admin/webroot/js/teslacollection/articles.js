Ext.require([
    'Ext.selection.CellModel',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.form.*',
    'Ext.window.*'
]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
    function formatDate(value){
        return value ? Ext.Date.dateFormat(value, 'M d, Y') : '';
    }
	
	Ext.define('Article', {
        extend: 'Ext.data.Model',
        fields: [
             {name : 'id', mapping: 'Article.id'},
             {name : 'volume', mapping: 'Article.volume'},
             {name : 'page', mapping: 'Article.page'},
             {name : 'title', mapping: 'Article.title'},
             {name : 'publication_id', mapping: 'Article.publication_id'},
             {name : 'author_id', mapping: 'Article.author_id'},
             {name : 'date', mapping: 'Article.date'},
             {name : 'year', mapping: 'Article.year'},
             {name : 'range_text', mapping: 'Article.range_text'},
             {name : 'status', mapping: 'Article.status'}
        ]
    });
	
    // create the Data Store
    var store = Ext.create('Ext.data.Store', {
        // destroy the store if the grid is destroyed
        autoDestroy: true,
        model: 'Article',
        proxy: {
            type: 'ajax',
            // load remote data using HTTP
            url: 'articles/getAll',
            // specify a XmlReader (coincides with the XML format of the returned data)
            reader: {
                type: 'json',
            }
        },
        sorters: [{
            property: 'common',
            direction:'ASC'
        }]
    });
    
    var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });
    
    // create the grid and specify what field you want
    // to use for the editor at each header.
    var grid = Ext.create('Ext.grid.Panel', {
        store: store,
        columns: [{
            id: 'id',
            header: 'ID',
            dataIndex: 'id',
            editor: {
                allowBlank: true
            }
        }, {
            header: 'Volume',
            dataIndex: 'volume',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'numberfield',
                allowBlank: false,
                minValue: 0,
                maxValue: 23
            }
        }, {
            header: 'Page',
            dataIndex: 'page',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'numberfield',
                allowBlank: false,
                minValue: 0,
                maxValue: 100000
            }
        }, {
            header: 'Title',
            dataIndex: 'title',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'textfield',
            }
        }, {
        	header: 'Publication',
            dataIndex: 'publication_id',
            width: 130,
            editor: new Ext.form.field.ComboBox({
                typeAhead: true,
                triggerAction: 'all',
                selectOnTab: true,
                store: [
                    ['Shade','Shade'],
                    ['Mostly Shady','Mostly Shady'],
                    ['Sun or Shade','Sun or Shade'],
                    ['Mostly Sunny','Mostly Sunny'],
                    ['Sunny','Sunny']
                ],
                lazyRender: true,
                listClass: 'x-combo-list-small'
            })
        }, {
        	header: 'Author',
            dataIndex: 'author_id',
            width: 130,
            editor: new Ext.form.field.ComboBox({
                typeAhead: true,
                triggerAction: 'all',
                selectOnTab: true,
                store: [
                    ['Shade','Shade'],
                    ['Mostly Shady','Mostly Shady'],
                    ['Sun or Shade','Sun or Shade'],
                    ['Mostly Sunny','Mostly Sunny'],
                    ['Sunny','Sunny']
                ],
                lazyRender: true,
                listClass: 'x-combo-list-small'
            })
        }, {
            header: 'Date',
            dataIndex: 'date',
            width: 95,
            renderer: formatDate,
            editor: {
                xtype: 'datefield',
                format: 'm/d/y'
            }
        }, {
            header: 'Year',
            dataIndex: 'year',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'textfield',
            }
        }, {
            header: 'Range',
            dataIndex: 'range_text',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'textfield',
            }
        }, {
        	header: 'Status',
            dataIndex: 'status',
            width: 130,
            editor: new Ext.form.field.ComboBox({
                typeAhead: true,
                triggerAction: 'all',
                selectOnTab: true,
                store: [
                    ['created','created'],
                    ['disabled','disabled']
                ],
                lazyRender: true,
                listClass: 'x-combo-list-small'
            })
        }, {
            xtype: 'actioncolumn',
            header: 'Delete',
            width: 130,
            sortable: false,
            items: [{
                icon: '../shared/icons/fam/delete.gif',
                tooltip: 'Delete Plant',
                handler: function(grid, rowIndex, colIndex) {
                    store.removeAt(rowIndex); 
                }
            }]
        }],
        selModel: {
            selType: 'cellmodel'
        },
        renderTo: 'article-grid',
        width: 1000,
        height: 1000,
        title: 'Collection Articles',
        frame: true,
        tbar: [{
            text: 'Add Article',
            handler : function(){
                // Create a model instance
                var r = Ext.create('Article', {
                    common: 'Test',
                    light: 'Mostly Shady',
                    price: 0,
                    availDate: Ext.Date.clearTime(new Date()),
                    indoor: false
                });
                store.insert(0, r);
                cellEditing.startEditByPosition({row: 0, column: 0});
            }
        }],
        plugins: [cellEditing]
    });
    
    // manually trigger the data store load
    store.load({
        // store loading is asynchronous, use a load listener or callback to handle results
        callback: function(){
            Ext.Msg.show({
                title: 'Store Load Callback',
                msg: 'store was loaded, data available for processing',
                modal: false,
                icon: Ext.Msg.INFO,
                buttons: Ext.Msg.OK
            });
        }
    });
});
