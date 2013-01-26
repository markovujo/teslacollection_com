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
	
    var store = Ext.create('Ext.data.Store', {
        autoDestroy: true,
        model: 'Article',
        proxy: {
            type: 'ajax',
            url: '/articles/getAll',
            reader: {
                type: 'json',
                root: 'records'
            }
        },
        sorters: [{
            property: 'common',
            direction:'ASC'
        }]
    });
    
	Ext.define('Publication', {
        extend: 'Ext.data.Model',
        fields: [
             {name : 'id', mapping: 'Publication.id'},
             {name : 'name', mapping: 'Publication.name'}
        ]
    });
	
    var publicationStore = Ext.create('Ext.data.Store', {
        autoDestroy: true,
        model: 'Publication',
        autoLoad: true,
        proxy: {
            type: 'ajax',
            url: '/publications/getAll',
            reader: {
                type: 'json',
                root: 'records'
            }
        },
        sorters: [{
            property: 'common',
            direction:'ASC'
        }]
    });
    
	Ext.define('Author', {
        extend: 'Ext.data.Model',
        fields: [
             {name : 'id', mapping: 'Author.id'},
             {name : 'name', mapping: 'Author.name'}
        ]
    });
	
    var authorStore = Ext.create('Ext.data.Store', {
        autoDestroy: true,
        model: 'Author',
        autoLoad: true,
        proxy: {
            type: 'ajax',
            url: '/authors/getAll',
            reader: {
                type: 'json',
                root: 'records'
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
                store: publicationStore,
                valueField : 'id',
                displayField : 'name',
                emptyText:'Select Author',
                //selectOnFocus:true,
                //lazyRender: true,
                autoShow: true,
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
                store: authorStore,
                valueField : 'id',
                displayField : 'name',
                emptyText:'Select Author',
                //selectOnFocus:true,
                //lazyRender: true,
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
                    ['active','active'],
                    ['inactive','inactive']
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
                text: 'Delete',
                iconCls: 'icon-delete',
                action: 'delete',
                tooltip: 'Delete Article?',
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
    
    store.load({
        callback: function(){
        	/*
            Ext.Msg.show({
                title: 'Store Load Callback',
                msg: 'store was loaded, data available for processing',
                modal: false,
                icon: Ext.Msg.INFO,
                buttons: Ext.Msg.OK
            });
            */
        }
    });
});
