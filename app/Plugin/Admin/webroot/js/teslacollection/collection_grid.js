Ext.ns('TeslaCollection');
Ext.define('TeslaCollection.Grid' , {
    extend: 'Ext.grid.Panel',
    alias: 'teslacollection.grid',
    store: store,

    initComponent: function() {
        Ext.apply(this, {
        	features: [{
                ftype: 'filters',
                filters: [{
                    type: 'numeric',
                    dataIndex: 'id'
                }, {
                    type: 'string',
                    dataIndex: 'name'
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
            }],
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
                header: 'Name',
                dataIndex: 'name',
                width: 400,
                align: 'left',
                editor: {
                    xtype: 'textfield',
                },
                filter: {
                    type: 'string'
                }
            }, {
            	header: 'Status',
                dataIndex: 'status',
                width: 70,
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
                    icon: document_url + 'img/delete.gif',
                    tooltip: 'Delete Article',
                    handler: function(grid, rowIndex, colIndex) {         	
                    	var record = store.getAt(rowIndex);
                    	var recordId = record.get('id');
                    	var recordTitle = record.get('title');
                    	
                		Ext.Msg.confirm('Confirm Delete', 'Are you sure you want to delete Publication (' + recordId +') - ' + recordTitle, function(btn) {
                			if(btn == 'yes'){
                				var data = [];
                				data.push(recordId);
                				//console.log(data);
                				Ext.Ajax.request({
            	    			   url: document_url + 'publications/delete',
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
            width: 1500,
            height: 800,
            title: 'Publications',
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
        			   url: document_url + 'publications/saveAll',
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
                text: 'Add Publication',
                handler : function(){
                    var r = Ext.create('Publication', {
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
            plugins: [
              Ext.create('Ext.grid.plugin.CellEditing', {
    	        clicksToEdit: 1,
    	        listeners: {
    	            beforeedit: function(editor, e, eOpts ) {
    	            	if(e.colIdx == 0) {
    	            		return false;  
    	            	} else {
    	            		return true;
    	            	}
    	          
    	            }   
    	        }
              })]
        });

        this.callParent(arguments);
    }
});