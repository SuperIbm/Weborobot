Ext.define("Admin.view.ux.GridPanel",
	{
	extend: "Ext.grid.GridPanel",

	bodyBorder: false,
	border: false,
	frame: false,
	forceFit: true,
	remoteEdit: true,
	
	multiColumnSort: true,
	
		selModel:
		{
		mode: "MULTI"
		},

	selType: "checkboxmodel",
	
		plugins:
		[
			{
			ptype: 'gridfiltersfixed',
			pluginId: "gridfilters"
			},
			{
			ptype: "cellediting",
			clicksToEdit: 1,
			pluginId: "cellediting"
			}
		],
	
	_recordsEdit: [],
	
		initComponent: function()
		{				
		this.callParent();
		var thisObj = this;
		
		var ButtonCreate, MenuItemCreate, 
		ButtonUpdate, MenuItemUpdate,
		ButtonDestroy, MenuItemDestroy;
			
			this.getButtonCreate = function()
			{
			return ButtonCreate;
			};
			
			this.getMenuItemCreate = function()
			{
			return MenuItemCreate;
			};
			
			this.getButtonUpdate = function()
			{
			return ButtonUpdate;
			};
			
			this.getMenuItemUpdate = function()
			{
			return MenuItemUpdate;
			};
			
			this.getButtonDestroy = function()
			{
			return ButtonDestroy;
			};
			
			this.getMenuItemDestroy = function()
			{
			return MenuItemDestroy;
			};
			
			//
			
			this.getContextMenu = function()
			{
			return ContextMenu;
			};
			
			//
			
			this.getSelectionModel().getOwnGrid = function()
			{
			return thisObj;	
			};
			
			//
		
			this.resetButtons = function(rows)
			{
				if(this.getButtonDestroy() && rows.length == 0)
				{
				this.getButtonDestroy().setDisabled(true);
				this.getMenuItemDestroy().setDisabled(true);
				}
				else if(this.getButtonDestroy())
				{
				this.getButtonDestroy().setDisabled(false);
				this.getMenuItemDestroy().setDisabled(false);
				}
			
				if(this.getButtonUpdate() && this.multiColumnEdit == true && rows.length > 1)
				{
				this.getButtonUpdate().setDisabled(false);
				this.getMenuItemUpdate().setDisabled(false);	
				}
				else if(this.getButtonUpdate() && rows.length == 1)
				{
				this.getButtonUpdate().setDisabled(false);
				this.getMenuItemUpdate().setDisabled(false);
				}
				else if(this.getButtonUpdate())
				{
				this.getButtonUpdate().setDisabled(true);
				this.getMenuItemUpdate().setDisabled(true);
				}
			};
			
			//
			
			this.isDblclickUpdate = function(status)
			{
				if(status === undefined) 
				{
				return this.dblclickUpdate === undefined ? true : this.dblclickUpdate;	
				}
				else
				{
				this.dblclickUpdate = status;
				return this;
				}
			};
			
			var ContextMenu = Ext.create("Ext.menu.Menu",
				{
				renderTo: this.getEl()
				}
			);
			
		var createDockedTop = false;
		
			if(this.buttonCreate) createDockedTop = true;
			if(this.buttonUpdate) createDockedTop = true;
			if(this.buttonDestroy) createDockedTop = true;
			
			if(createDockedTop)
			{
			var id = "top_" + this.getId();
			
				if(!this.getDockedComponent(id))
				{
					this.addDocked
					(
						{
						xtype: 'toolbar',
						id: id,
						dock: 'top'
						},
					0
					);
				}			
			
			this.getDockedComponent(id).add("->");
				
				if(this.buttonCreate)
				{								
					ButtonCreate = new Ext.button.Button
					(
						Ext.apply
						(
							{
							action: 'create',
							iconCls: this.buttonCreate.iconCls == undefined ? "icon_create" : this.buttonCreate.iconCls
							},
						this.buttonCreate
						)
					);
					
				this.getDockedComponent(id).add(ButtonCreate);
				
					MenuItemCreate = ContextMenu.insert
					(
					0,
						Ext.apply
						(
							{
							iconCls: this.buttonCreate.iconCls == undefined ? "icon_create" : this.buttonCreate.iconCls,
								handler: function()
								{
								thisObj.getButtonCreate().fireEvent("click", thisObj.ButtonCreate);
								}
							},
						this.buttonCreate
						)
					);
				}				
				
				if(this.buttonUpdate)
				{								
					ButtonUpdate = new Ext.button.Button
					(
						Ext.apply
						(
							{
							action: 'update',
							disabled: true,
							iconCls: this.buttonUpdate.iconCls == undefined ? "icon_update" : this.buttonUpdate.iconCls
							},
						this.buttonUpdate
						)
					);
					
				this.getDockedComponent(id).add(ButtonUpdate);
				
					MenuItemUpdate = ContextMenu.insert
					(
					1,
						Ext.apply
						(
							{
							disabled: true,
							iconCls: this.buttonUpdate.iconCls == undefined ? "icon_update" : this.buttonUpdate.iconCls,
								handler: function()
								{
								thisObj.getButtonUpdate().fireEvent("click", thisObj.getButtonUpdate());
								}
							},
						this.buttonUpdate
						)
					);
				}
				
				if(this.buttonDestroy)
				{								
					ButtonDestroy = new Ext.button.Button
					(
						Ext.apply
						(
							{
							action: 'destroy',
							disabled: true,
							iconCls: this.buttonDestroy.iconCls == undefined ? "icon_delete" : this.buttonDestroy.iconCls
							},
						this.buttonDestroy
						)
					);
					
				this.getDockedComponent(id).add(ButtonDestroy);
				
					MenuItemDestroy = ContextMenu.insert
					(
					3,
						Ext.apply
						(
							{
							disabled: true,
							iconCls: this.buttonDestroy.iconCls == undefined ? "icon_delete" : this.buttonDestroy.iconCls,
								handler: function()
								{
								thisObj.getButtonDestroy().fireEvent("click", thisObj.getButtonDestroy());
								}
							},
						this.buttonDestroy
						)
					);
				}
			}
			
			this.on("itemdblclick",
				function(obj, record, item, index, e, eOpts)
				{								
					if(thisObj.getButtonUpdate() && this.isDblclickUpdate() == true)
					{
						if(thisObj.getButtonUpdate().disabled == false && thisObj.getButtonUpdate().isVisible() == true)
						{
						thisObj.getPlugin("cellediting").cancelEdit();
						thisObj.getButtonUpdate().fireEvent("click", thisObj.getButtonUpdate());	
						}
					}
				}
			);
			
			this.on("destroy",
				function()
				{
				thisObj = null;	
				}
			);
			
			this.getStore().on("load",
				function(store, records, successful, eOpts)
				{
					if(thisObj)
					{
					thisObj._recordsEdit = records;
					thisObj.resetButtons(thisObj.getSelectionModel().getSelection());
					}
				}
			);
		},
		listeners:
		{
			itemcontextmenu: function(obj, record, item, index, e, eOpts)
			{
			e.stopEvent();
				if(this.getContextMenu()) this.getContextMenu().showAt(e.getXY());							
			},
			selectionchange: function(obj, selected, eOpts)
			{		
			this.resetButtons(selected);
			return true;
			},
			itemclick: function(obj, record, item, index, e, eOpts)
			{
			this.resetButtons(this.getSelectionModel().getSelection());	
			},
			beforedestroy: function()
			{
				if(this.getContextMenu()) this.getContextMenu().destroy();	
			},
			beforeedit: function(editor, context, eOpts)
			{
			var edit = false;
											
				for(var i = 0; i < context.grid._recordsEdit.length; i++)
				{				
					if(context.record.getId() != context.grid._recordsEdit[i].getId())
					{
					context.grid._recordsEdit[i]._selectEdit = undefined;	
					}
					else
					{
						if(!context.grid._recordsEdit[i]._selectEdit) context.grid._recordsEdit[i]._selectEdit = "mark";
						else
						{
						context.grid._recordsEdit[i]._selectEdit = "edit";
						edit = true;
						}
					}
				}
				
			return edit;
			},
			edit: function(editor, context, eOpts)
			{
				if(this.remoteEdit == true)
				{
				var thisObj = this;
				
					if(context.value != context.originalValue)
					{
					var data = context.record.getData();
					var record = context.record.copy();

						if(!record.modified) record.modified = {};

						for(var k in data)
						{
							if(context.record.isModified(k))
							{
							record.modified[k] = data[k];
							}

						var field = record.getField(k);

							if(field)
							{
								if(field.convertSend)
								{
								var val = field.convertSend.call(this, data[k], data);
								record.set(k, val);
								}
							}

							if(k.indexOf('.') != -1)
							{
							record.set(k.split(".")[1], data[k]);
							}
						}
						
						var status = thisObj.fireEventArgs("beforeEditUpdate",
							[
							editor,
							context
							]
						);
					
						if(status == true)
						{
						context.grid.mask(thisObj.maskLoad);

							record.save
							(
								{
									success: function(model, operation)
									{
									context.record.commit();
									context.grid.unmask();
									//context.grid.getStore().reload();
									
										thisObj.fireEventArgs("afterEditUpdate",
											[
											true,
											operation,
											editor,
											context
											]
										);
									},
									failure: function(model, operation)
									{
									context.record.reject();
									context.grid.unmask();
									
										Ext.Msg.show
										(
											{
											title: thisObj.error,
											msg: thisObj.errorMsgServer,
											icon: Ext.MessageBox.ERROR,
											buttons: Ext.MessageBox.OK
											}
										);	
										
										thisObj.fireEventArgs("afterEditUpdate",
											[
											false,
											operation,
											editor,
											context
											]
										);
									}						
								}
							);
						}
					}
				}
			}
		}
	}
);