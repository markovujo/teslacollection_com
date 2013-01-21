Ext.require([
    'Ext.selection.CellModel',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
    'Ext.state.*',
    'Ext.form.*'
]);

Ext.onReady(function(){
    var remoteProxy = new Ext.data.ScriptTagProxy({
    	url : 'articles/getAll'
    });
    
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
    
    var textFieldEditor = new Ext.form.TextField();
    
    var comboEditorPublication = {
    		xtype : 'combo',
    		triggerAction: 'all',
    		displayField : 'name',
    		valueField : 'id',
    		store: {
    			xtype : 'jsonstore',
    			root: 'records',
    			fields: ['publications'],
    			proxy : new Ext.data.ScriptTagProxy({
    				url : 'publications/getAll'
    			})
    		}
    };
    
    var numberFieldEditor = {
    		xtype: 'numberfield',
    		minLength : 5,
    		maxLength : 5
    };
    
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
    
    var pagingToolbar = {
    	xtype : 'paging',
    	store : remoteJsonStore,
    	pageSize : 50,
    	displayInfo : true
    };
    
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
    
    new Ext.Window({
    	height : 800,
    	width : 800,
    	border : false,
    	layout : 'fit',
    	items : grid
    }).show();
    
    remoteJsonStore.load({
    	params : {
    		start : 0,
    		limit : 50
    	}
    });
});
