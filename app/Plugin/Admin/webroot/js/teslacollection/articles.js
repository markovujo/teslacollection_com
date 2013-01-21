Ext.require([
    'Ext.selection.CellModel',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.form.*',
    'Ext.window.*'
]);

Ext.onReady(function(){
    var remoteProxy = new Ext.data.ScriptTagProxy({
    	url : 'articles/getAll'
    });
    
    console.log('1');
    var recordFields = [
         {name : 'id', mapping: 'id'},
         {name : 'volume', mapping: 'volume'},
         {name : 'page', mapping: 'page'},
         {name : 'title', mapping: 'title'},
         {name : 'publication_id', mapping: 'publication_id'},
         {name : 'author_id', mapping: 'author_id'},
         {name : 'date', mapping: 'date'},
         {name : 'year', mapping: 'year'},
         {name : 'range_text', mapping: 'range_text'},
         {name : 'status', mapping: 'status'},
    ];
    console.log('2');
    
    var remoteJsonStore = new Ext.data.JsonStore({
    	proxy : remoteProxy,
    	storeId : 'articleRemoteStore',
    	root : 'records',
    	autoLoad : false,
    	totalProperty : 'totalCount',
    	remoteSort : true,
    	fields : recordFields,
    	idProperty : 'id'
    });
    console.log('3');
    
    var textFieldEditor = new Ext.form.TextField();
    
    var comboEditorPublication = {
    		xtype : 'combo',
    		triggerAction: 'all',
    		displayField : 'name',
    		valueField : 'id',
    		store: {
    			xtype : 'jsonstore',
    			root: 'records',
    			fields: ['id', 'name'],
    			proxy : new Ext.data.ScriptTagProxy({
    				url : 'publications/getAll'
    			})
    		}
    };
    console.log('4');
    
    var comboEditorAuthor = {
    		xtype : 'combo',
    		triggerAction: 'all',
    		displayField : 'name',
    		valueField : 'id',
    		store: {
    			xtype : 'jsonstore',
    			root: 'records',
    			fields: ['id', 'name'],
    			proxy : new Ext.data.ScriptTagProxy({
    				url : 'authors/getAll'
    			})
    		}
    };
    console.log('5');
    
    var numberFieldEditor = {
    		xtype: 'numberfield',
    		minLength : 5,
    		maxLength : 5
    };
    console.log('6');
    
    var columnModel = [
            {
            	header : 'Id',
            	dataIndex : 'id',
            	sortable : true,
            	editor : textFieldEditor
            		
            },
            {
            	header : 'Volume',
            	dataIndex : 'volume',
            	sortable : true,
            	editor : textFieldEditor
            		
            },
            {
            	header : 'Page',
            	dataIndex : 'page',
            	sortable : true,
            	editor : textFieldEditor
            		
            },
            {
            	header : 'Title',
            	dataIndex : 'title',
            	sortable : true,
            	editor : textFieldEditor
            		
            },
            {
            	header : 'Publication',
            	dataIndex : 'publication_id',
            	sortable : true,
            	editor : comboEditorPublication	
            },
            {
            	header : 'Author',
            	dataIndex : 'author_id',
            	sortable : true,
            	editor : comboEditorAuthor
            },
            {
            	header : 'Date',
            	dataIndex : 'date',
            	sortable : true,
            	editor : textFieldEditor
            },
            {
            	header : 'Year',
            	dataIndex : 'year',
            	sortable : true,
            	editor : textFieldEditor
            },
            {
            	header : 'Range',
            	dataIndex : 'range_text',
            	sortable : true,
            	editor : textFieldEditor
            },
            {
            	header : 'Status',
            	dataIndex : 'status',
            	sortable : true,
            	editor : textFieldEditor
            }
    ];
    console.log('7');
    
    var pagingToolbar = {
    	xtype : 'paging',
    	store : remoteJsonStore,
    	pageSize : 50,
    	displayInfo : true
    };
    console.log('8');
    
    /*
    var grid = {
    	xtype : 'editorgrid',
    	columns : columnModel,
    	id : 'articleEditorGrid',
    	store : remoteJsonStore,
    	loadMask : true,
    	bbar : pagingToolbar,
    	stripeRows : true,
    	viewConfig : {
    		forceFit : true
    	}
    };
    */
    var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });

    // create the grid and specify what field you want
    // to use for the editor at each header.
    var grid = Ext.create('Ext.grid.Panel', {
        store: remoteJsonStore,
        columns: columnModel,
        selModel: {
            selType: 'cellmodel'
        },
        width: 800,
        height: 800,
        title: 'Articles',
        frame: true,
        tbar: [{
            text: 'Add Article',
            handler : function(){
                // Create a model instance
            	/*
                var r = Ext.create('Article', {
                    common: 'New Plant 1',
                    light: 'Mostly Shady',
                    price: 0,
                    availDate: Ext.Date.clearTime(new Date()),
                    indoor: false
                });
                store.insert(0, r);
                cellEditing.startEditByPosition({row: 0, column: 0});
                */
            }
        }],
        plugins: [cellEditing]
    });
    console.log('9');
    
    new Ext.window.Window({
    	height : 800,
    	width : 800,
    	border : false,
    	layout : 'fit',
    	items : grid
    }).show();
    console.log('10');
    
    remoteJsonStore.load({
    	params : {
    		start : 0,
    		limit : 50
    	}
    });
    console.log('11');
});
