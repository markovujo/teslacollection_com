Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('Ext.ux', 'js/ext/ext-4.1.1a/examples/ux/');
Ext.require([
    'Ext.selection.CellModel',
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.form.*',
    'Ext.window.*',
    'Ext.toolbar.Paging',
    'Ext.ux.grid.FiltersFeature',
]);

Ext.onReady(function() {
	Ext.QuickTips.init();
	
    function formatDate(value){
        //return value ? Ext.Date.dateFormat(value, 'M d, Y') : '';
    	return value;
    }
    
    var document_url = document.URL.replace('#', '');
	
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
	
	var myPageSize = 50;
	
    var store = Ext.create('Ext.data.Store', {
    	autoLoad: false,
        model: 'Article',
        pageSize: myPageSize, // items per page
        proxy: {
            type: 'ajax',
            url: document.URL + 'articles/getAll',
            reader: {
                type: 'json',
                root: 'records',
                totalProperty: "totalCount"
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
        proxy: {
            type: 'ajax',
            url: document.URL + 'publications/getAll',
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
    
    publicationStore.load();
    
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
        proxy: {
            type: 'ajax',
            url: document.URL + 'authors/getAll',
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
    
    authorStore.load();
    
	Ext.define('Page', {
        extend: 'Ext.data.Model',
        fields: [
             {name : 'id', mapping: 'Page.id'},
             {name : 'filename', mapping: 'Page.filename'},
             {name : 'full_path', mapping: 'Page.full_path'},
             {name : 'status', mapping: 'Page.status'}
        ]
    });
    
	Ext.define('Subject', {
        extend: 'Ext.data.Model',
        fields: [
	         {name : 'id', mapping: 'Subject.id'},
	         {name : 'name', mapping: 'Subject.name'},
	         {name : 'status', mapping: 'Subject.status'},
        ]
    });
    
    var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });
    
    var filters = {
        ftype: 'filters',
        filters: [{
            type: 'numeric',
            dataIndex: 'id'
        }, {
            type: 'numeric',
            dataIndex: 'volume'
        }, {
            type: 'numeric',
            dataIndex: 'page'
        }, {
            type: 'string',
            dataIndex: 'title'
        }, {
            type: 'string',
            dataIndex: 'publication_id',
            disabled: true
        }, {
            type: 'string',
            dataIndex: 'author_id',
            disabled: true
        }, {
            type: 'date',
            dataIndex: 'date'
        }, {
            type: 'numeric',
            dataIndex: 'year'
        }, {
            type: 'string',
            dataIndex: 'range_text'
        }, {
            type: 'list',
            dataIndex: 'status',
            options: ['active', 'inactive'],
            phpMode: true
        }, {
            type: 'string',
            dataIndex: 'delete',
            disabled: true
        }]
    };
    
    Ext.ns('TeslaCollection');
    TeslaCollection.ArticleModal = {
        openWindow: function(articleId)
        {        	
        	var url = document_url + 'articles/getAssociations/Page/' + articleId;
        	var pageStore = Ext.create('Ext.data.JsonStore', {
                model: 'Page',
                proxy: {
                    type: 'ajax',
                    url: url,
                    reader: {
                        type: 'json',
                        root: 'records'
                    }
                }
            });
        	
            var pageComboStore = Ext.create('Ext.data.Store', {
                autoDestroy: true,
                model: 'Page',
                proxy: {
                    type: 'ajax',
                    url: document_url + 'pages/getAll',
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
        	
        	var pageCombo = Ext.create('Ext.form.field.ComboBox', {
                typeAhead: true,
                triggerAction: 'all',
                selectOnTab: true,
                store: pageComboStore,
                valueField : 'id',
                displayField : 'filename',
                emptyText:'Select Page',
                autoShow: true,
                width : 300,
                listClass: 'x-combo-list-small',
                buttonAlign: 'center',
                listeners: {
                	select: function(combo, record, index) {  
                		var recordId = record[0].get('id');
        				var data = [];
        				data.push({
        					'article_id' : articleId,
        					'page_id' : recordId
        				});
        				
                		Ext.Ajax.request({
     	    			   url: document_url + 'articles/addAssociations/Page',
     	    			   success: function(response) {
     	    				  pageStore.add(record);
     	    			   },
     	    			   failture: function(response) {
     	    				   Ext.Msg.show({
     	    		                title: 'Failure',
     	    		                msg: 'Your data has FAILED to link!',
     	    		                modal: false,
     	    		                icon: Ext.Msg.FAIL,
     	    		                buttons: Ext.Msg.OK
     	    		            });
     	    			   },
     	    			   jsonData : Ext.JSON.encode(data)
     	    			});
                	}
                }
        	});
        	
        	var pagesGrid = Ext.create('Ext.grid.Panel', {
                store: pageStore,
                columns: [
                    {
                    	text : 'ID',
                    	flex : 1,
                    	sortable : false,
                    	dataIndex : 'id'
                    },
                    {
                        text     : 'Filename',
                        flex     : 1,
                        sortable : false,
                        dataIndex: 'filename'
                    },
                    {
                        text     : 'Full Path',
                        width    : 75,
                        sortable : false,
                        dataIndex: 'full_path'
                    },
                    {
                        text     : 'Status',
                        width    : 75,
                        sortable : false,
                        dataIndex: 'status'
                    },
                    {
                        xtype: 'actioncolumn',
                        width: 50,
                        title: 'Remove',
                        items: [{
                            icon: document_url + 'img/delete.gif',
                            tooltip: 'Remove Link',
                            handler: function(grid, rowIndex, colIndex) {               	
                            	var record = pageStore.getAt(rowIndex);
                            	var recordId = record.getId();
                            	var recordFilename = record.get('filename');
                            	
                        		Ext.Msg.confirm('Confirm Delete', 'Are you sure you want to delete Page Link (' + articleId + ' - ' + recordId + ') - ' + recordFilename, function(btn) {
                        			if(btn == 'yes'){
                        				var data = [];
                        				data.push({
                        					'article_id' : articleId,
                        					'page_id' : recordId
                        				});

                        				var url = document.URL + 'articles/deleteAssociations/Page';
                        				var url = url.replace('#', '');
                        				Ext.Ajax.request({
                    	    			   url: url,
                    	    			   success: function(response) {
                    	    				   Ext.Msg.show({
                    	    		                title: 'Success',
                    	    		                msg: 'Association has been successfully Deleted!',
                    	    		                modal: false,
                    	    		                icon: Ext.Msg.INFO,
                    	    		                buttons: Ext.Msg.OK
                    	    		            });
                    	    				   pageStore.removeAt(rowIndex);
                    	    			   },
                    	    			   failture: function(response) {
                    	    				   Ext.Msg.show({
                    	    		                title: 'Failure',
                    	    		                msg: 'Your data has FAILED to remove links!',
                    	    		                modal: false,
                    	    		                icon: Ext.Msg.FAIL,
                    	    		                buttons: Ext.Msg.OK
                    	    		            });
                    	    			   },
                    	    			   jsonData : Ext.JSON.encode(data)
                    	    			});
            	                    }
            	                }, this);
                            }
                        }]
                    }
                ],
                height: 380,
                width: 680,
                title: 'Pages',
                viewConfig: {
                    stripeRows: true
                }
            });
        	
        	pageStore.load();
        	
        	var win = new Ext.Window({
                width:700,
                height:480,
                title: 'Article (' + articleId + ')',
                autoScroll:true,
                modal:true,
                store: this.store,
                items : [{
                   xtype : 'tabpanel',
                   items : [{
                	   xtype : 'panel',
                	   title: 'Articles Pages',
                	   items : [
                	      pageCombo,
                	      pagesGrid
                	   ]
                   }, {
                	   xtype : 'panel',
                	   title: 'Subjects',
                	   /*
                	   items : [
                  	      pageCombo,
                	      pagesGrid  
                	   ]
                	   */
                   }]
                }]
        	});
        	
            win.show();
        }
    }
    
    // create the grid and specify what field you want
    // to use for the editor at each header.
    var grid = Ext.create('Ext.grid.Panel', {
    	features: [filters],
        store: store,
        columns: [{
            id: 'id',
            header: 'ID',
            dataIndex: 'id',
            width: 70,
            editor: {
                allowBlank: true
            },
            filterable: true,
            filter: {
                type: 'numeric'
            }
        }, {
            header: 'Link',
            dataIndex: 'link',
            renderer: function(value, metaData, record, rowIndex, colIndex, store) {
            	return '<a href="#" onclick="TeslaCollection.ArticleModal.openWindow(' + record.getId() + ')"/>Link<a/>';
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
            },
            filter: {
                type: 'numeric'
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
            },
            filter: {
                type: 'numeric'
            }
        }, {
            header: 'Title',
            dataIndex: 'title',
            width: 400,
            align: 'left',
            editor: {
                xtype: 'textfield',
            },
            filter: {
                type: 'string'
            }
        }, {
        	header: 'Publication',
            dataIndex: 'publication_id',
            width: 200,
            editor: new Ext.form.field.ComboBox({
                typeAhead: true,
                triggerAction: 'all',
                selectOnTab: true,
                store: publicationStore,
                valueField : 'id',
                displayField : 'name',
                emptyText:'Select Author',
                autoShow: true,
                listClass: 'x-combo-list-small'
            }),
            filter: {
                type: 'string'
            }
	        , renderer: function(value){
	            if(value != 0 && value != "") {
	            	if(publicationStore.findRecord("id", value) != null) {
	                    return publicationStore.findRecord("id", value).get('name');
	                } else { 
	                    return value;
	                }
	            } else {
	                return "";  // display nothing if value is empty
	            }
	        }
        }, {
        	header: 'Author',
            dataIndex: 'author_id',
            width: 200,
            editor: new Ext.form.field.ComboBox({
                typeAhead: true,
                triggerAction: 'all',
                selectOnTab: true,
                store: authorStore,
                valueField : 'id',
                displayField : 'name',
                emptyText:'Select Author',
                listClass: 'x-combo-list-small'
            }),
            filter: {
                type: 'string'
            }
	        , renderer: function(value){
	            if(value != 0 && value != "") {
	            	if(authorStore.findRecord("id", value) != null) {
	                    return authorStore.findRecord("id", value).get('name');
	                } else { 
	                    return value;
	                }
	            } else {
	                return "";  // display nothing if value is empty
	            }
	        }
        }, {
            header: 'Date',
            dataIndex: 'date',
            width: 95,
            renderer: formatDate,
            editor: {
                xtype: 'datefield',
                format: 'Y-m-d'
            },
            filter: {
                type: 'date'
            }
        }, {
            header: 'Year',
            dataIndex: 'year',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'textfield',
            },
            filter: {
                type: 'numeric'
            }
        }, {
            header: 'Range',
            dataIndex: 'range_text',
            width: 70,
            align: 'right',
            editor: {
                xtype: 'textfield',
            },
            filter: {
                type: 'string'
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
            }),
            filter: {
                type: 'list',
                options: ['active', 'inactive']
            }
        }, {
        	header: 'Delete',
            dataIndex: 'delete',
            xtype: 'actioncolumn',
            width:70,
            sortable: false,
            items: [{
                icon: document.URL + 'img/delete.gif',
                tooltip: 'Delete Article',
                handler: function(grid, rowIndex, colIndex) {                	
                	var record = store.getAt(rowIndex);
                	var recordId = record.get('id');
                	var recordTitle = record.get('title');
                	
            		Ext.Msg.confirm('Confirm Delete', 'Are you sure you want to delete Article (' + recordId +') - ' + recordTitle, function(btn) {
            			if(btn == 'yes'){
            				var data = [];
            				data.push(recordId);
            				//console.log(data);
            				Ext.Ajax.request({
        	    			   url: document.URL + 'articles/delete',
        	    			   success: function(response) {
        	    				   Ext.Msg.show({
        	    		                title: 'Success',
        	    		                msg: 'Your data has been successfully Deleted!',
        	    		                modal: false,
        	    		                icon: Ext.Msg.INFO,
        	    		                buttons: Ext.Msg.OK
        	    		            });
        	    				   store.removeAt(rowIndex);
        	    			   },
        	    			   failture: function(response) {
        	    				   Ext.Msg.show({
        	    		                title: 'Failure',
        	    		                msg: 'Your data has FAILED to delete!',
        	    		                modal: false,
        	    		                icon: Ext.Msg.FAIL,
        	    		                buttons: Ext.Msg.OK
        	    		            });
        	    			   },
        	    			   jsonData : Ext.JSON.encode(data)
        	    			});
	                    }
	                }, this);
                }
            }]
        }],
        dockedItems: [{
            xtype: 'pagingtoolbar',
            store: store,   // same store GridPanel is using
            dock: 'bottom',
            displayInfo: true
        }],
        selModel: {
            selType: 'cellmodel'
        },
        renderTo: 'article-grid',
        width: 1500,
        height: 800,
        title: 'Collection Articles',
        frame: true,
        tbar: [
        {
        	text: 'Save',
        	handler : function() {
        		var records = [];
        		var modified_records = store.getModifiedRecords();
        		for (var i = 0, ln = modified_records.length; i < ln; i++) {
        		    var changes = modified_records[i].getChanges();
        		    changes['id'] = modified_records[i].getId();
        		    records.push(changes);
        		}
        		
        		Ext.Ajax.request({
    			   url: document.URL + 'articles/saveAll',
    			   success: function(response) {
    				   Ext.Msg.show({
    		                title: 'Success',
    		                msg: 'Your data has been successfully saved!',
    		                modal: false,
    		                icon: Ext.Msg.INFO,
    		                buttons: Ext.Msg.OK
    		            });
    				   store.commitChanges();
    			   },
    			   failture: function(response) {
    				   Ext.Msg.show({
    		                title: 'Failure',
    		                msg: 'Your data has FAILED to save!',
    		                modal: false,
    		                icon: Ext.Msg.FAIL,
    		                buttons: Ext.Msg.OK
    		            });
    			   },
    			   jsonData : Ext.JSON.encode(records)
    			});
        	}
        }       
        , {
            text: 'Add Article',
            handler : function(){
                var r = Ext.create('Article', {
                    volume: 0,
                    page: 0
                });
                store.insert(0, r);
                cellEditing.startEditByPosition({row: 0, column: 0});
            }
        }, 
        '->',
        {
            text: 'Clear Changes',
            handler: function () {
            	store.rejectChanges();
            } 
        },
        {
            text: 'Clear Filter Data',
            handler: function () {
                grid.filters.clearFilters();
            } 
        }
        ],
        plugins: [cellEditing]
    });
    
    store.load({
    	params:{
            start: 0,
            limit: myPageSize
        }
    });
});
