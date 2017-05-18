Ext.define("Admin.view.ux.TreePanel",
	{
	extend: "Ext.tree.TreePanel",
	
	rootVisible: false,
	canDeleteFirstNode: true,
	canUpdateFirstNode: true, 
	canCreateInFirstNode: false,
	
	saveScrollPosition: true,
	remoteEdit: true,
	
	forceFit: true,
	
	bodyBorder: false,
	border: false,
	frame: false,
	
		selModel:
		{
		xtype: "treemodel",
		mode: "MULTI"
		},
	selType: "checkboxmodel",
	
		plugins: 
		[
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
		var ButtonCreate, MenuItemCreate, 
		ButtonUpdate, MenuItemUpdate,
		ButtonDestroy, MenuItemDestroy,
		ContextMenu;
		var thisObj = this;
						
			this.getButtonCreate = function()
			{
			return ButtonCreate;
			};
			
			this.getMenuItemCreate = function()
			{
			return MenuItemCreate;
			};
			
			//
			
			this.getButtonUpdate = function()
			{
				return ButtonUpdate;
			};
			
			this.getMenuItemUpdate = function()
			{
			return MenuItemUpdate;
			};
			
			//
			
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
			
			this.getSelectionModel().getOwnTree = function()
			{
			return thisObj;	
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
			
			//
		
			this.resetButtons = function(nodes)
			{
			var hasRoot = false;
			
				for(var i = 0; i < nodes.length; i++)
				{										
					if(nodes[i].isRoot() == true) hasRoot = true;				
					if(this.rootVisible == false)
					{
						if(nodes[i].parentNode)
						{
							if(nodes[i].parentNode.isRoot() == true)
							{
							hasRoot = true;
							}
						}
					}
				}
											
				if(ButtonCreate != undefined)
				{							
					if(nodes.length == 0 || nodes.length > 1) disabledCreate = true;
					else
					{
						if(this.canCreateInFirstNode == true && hasRoot == true) disabledCreate = true;
						else disabledCreate = false;	
					}
				
				ButtonCreate.setDisabled(disabledCreate);
				MenuItemCreate.setDisabled(disabledCreate);	
				}
				
				if(ButtonUpdate != undefined)
				{	
					if(nodes.length > 1 && this.multiColumnEdit == true) disabledUpdate = false;
					else if(nodes.length == 0 || nodes.length > 1) disabledUpdate = true;
					else
					{															
						if(this.canUpdateFirstNode == false && hasRoot == true) disabledUpdate = true;
						else disabledUpdate = false;
					}
					
				ButtonUpdate.setDisabled(disabledUpdate);
				MenuItemUpdate.setDisabled(disabledUpdate);
				}
				
				if(ButtonDestroy != undefined)
				{								
					if(nodes.length == 0) disabledDelete = true;
					else
					{					
						if(this.canDeleteFirstNode == false && hasRoot == true) disabledDelete = true;
						else disabledDelete = false;	
					}
					
				ButtonDestroy.setDisabled(disabledDelete);
				MenuItemDestroy.setDisabled(disabledDelete);
				}
			};
			
		var createDockedTop = false;		
		
			if(this.buttonCreate) createDockedTop = true;
			if(this.buttonUpdate) createDockedTop = true;
			if(this.buttonDestroy) createDockedTop = true;
		
			if(this.buttonCreate || this.buttonUpdate || this.buttonDestroy)
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
			
				ContextMenu = new Ext.menu.Menu
				(
					{
					renderTo: this.getEl()	
					}
				);
				
				if(this.buttonCreate)
				{								
					ButtonCreate = new Ext.button.Button
					(
						Ext.apply
						(
							{
							action: 'create',
							disabled: true,
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
								thisObj.getButtonCreate().fireEvent("click", thisObj.getButtonCreate());
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
					2,
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
			
			if(this.filter)
			{
			var id = "bottom_" + this.getId();
															
				if(!this.getDockedComponent(id))
				{								
					this.addDocked
					(
						{
						xtype: 'toolbar',
						id: id,
						dock: 'bottom'
						},
					0
					);
				}
				
			var value;
			
				if(this.getStore().isFiltered() == true)
				{
				var filters = this.getStore().getFilters();
					
					filters.each
					(
						function(item)
						{
							if(item.getId() == "_titleFilter") value = item.val;
						}
					);
				}
			
			this.getDockedComponent(id).insert(this.getDockedComponent(id).items.length, "->");		
				
				this.getDockedComponent(id).insert
				(
				this.getDockedComponent(id).items.length, 	
					{
					xtype: "textfield", 
					labelWidth: 50,
					fieldLabel: "Искать:",
					value: value,
					
						triggers: 
						{
							rest:
							{
							cls: 'x-form-clear-trigger',
								handler: function()
								{
								this.setValue("");	
								}
							}
						},
						listeners:
						{
							change: function()
							{
							var reg = new RegExp(this.getValue(), 'i');
							var value = this.getValue();
							
								function filterFn(node)
								{
									if(node.isVisible() == false) return false;
									if(value == "") return true;
									
								var result = reg.test(node.get(thisObj.filter["text"] == undefined ? 'text' : thisObj.filter["text"]));
								
									if(result == false)
									{
										if(node.childNodes)
										{
											for(var i = 0; i < node.childNodes.length; i++)
											{
											result = filterFn(node.childNodes[i]);
											
												if(result == true)
												{
												node.expand();
												return true;
												}
											}
										}
									}
									
								return result;
								}
							
							var tree = this.up('treepanel');
							Ext.suspendLayouts();
							
								tree.fireEventArgs("beforeFilter",
									[
									value
									]
								);

								tree.store.filter
								(
									{
									filterFn: filterFn,
									id: '_titleFilter',
									val: value
									}
								);
								
							Ext.resumeLayouts(true);							
							this.focus();
								
								tree.fireEventArgs("afterFilter",
									[
									value
									]
								);
							},
						buffer: 250
						}
					}
				);	
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
			
		var _checked = [];
		var _selected = [];
		var rootVisible = this.rootVisible;
		var _scrollPositionOld = null;
		var _titleFilter = null;
			
			thisObj.on("beforeload",
				function(store, operation, eOpts)
				{
					if(store.getFilters().getByKey("_titleFilter"))
					{
					_titleFilter = store.getFilters().getByKey("_titleFilter");
					store.removeFilter("_titleFilter", true);
					}
					else _titleFilter = null;

				_scrollPositionOld = thisObj.getView().getScrollY();
				_checked = thisObj.getChecked();
				_selected = thisObj.getSelectionModel().getSelection();	
				}
			);
			
			thisObj.on("load",
				function(store, records, successful, operation, node, eOpts)
				{
					if(_titleFilter)
					{
						store.filter
						(
							{
							filterFn: _titleFilter["initialConfig"]["filterFn"],
							id: _titleFilter["initialConfig"]["id"],
							val: _titleFilter["initialConfig"]["val"]
							}
						);
					}

					if(successful == true && _checked.length)
					{					
					node.getOwnerTree().setChecked(_checked);	
					}
					
					if(successful == true && _selected.length)
					{
					var selectRecord = [];
					
						for(var i = 0; i < _selected.length; i++)
						{
						var rec = store.getNodeById(_selected[i].getId());
						
							if(rec) selectRecord[selectRecord.length] = rec;
						}
					
					thisObj.getSelectionModel().select(selectRecord);
					}
					
					if(successful == true)
					{
						thisObj.on("afterlayout",
							function()
							{
								if(thisObj.saveScrollPosition == true && _scrollPositionOld)
								{
									if(_scrollPositionOld > 25) thisObj.getView().setScrollY(_scrollPositionOld);	
								}	
							},
							thisObj,
							{
							single: true	
							}
						);
						
					thisObj._recordsEdit = records;	
					}				
				}
			);
		},		
		listeners:
		{
			beforeedit: function(editor, context, eOpts)
			{			
				if(context.grid.canUpdateFirstNode == false)
				{
					if(context.record.isRoot() == true && this.rootVisible == true) return false;	
					if(this.rootVisible == false)
					{
						if(context.record.parentNode.isRoot() == true) return false;
					}
				}
				
			var edit = false;
			
				function setSelectEdit(records)
				{
					for(var i = 0; i < records.length; i++)
					{									
						if(context.record.getId() != records[i].getId())
						{
						records[i]._selectEdit = undefined;	
						}
						else
						{
							if(!records[i]._selectEdit) records[i]._selectEdit = "mark";
							else
							{
							records[i]._selectEdit = "edit";
							edit = true;
							}
						}
						
						if(records[i].childNodes) setSelectEdit(records[i].childNodes);
					}
				}
				
			setSelectEdit(context.grid._recordsEdit);
				
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

						for(var k in data)
						{
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
									context.record.reject()
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
			},
			selectionchange: function(obj, selected, eOpts)
			{
			this.resetButtons(selected);	
			},
			itemclick: function(obj, record, item, index, e, eOpts)
			{
			this.resetButtons(this.getSelectionModel().getSelection());	
			},
			itemcontextmenu: function(obj, record, item, index, e, eOpts)
			{
			e.stopEvent();
				if(this.getContextMenu()) this.getContextMenu().showAt(e.getXY());							
			},
			beforedestroy: function()
			{
				if(this.getContextMenu()) this.getContextMenu().destroy();	
			},
			itemmove: function(node, oldParent, newParent, index, eOpts)
			{															
				if(this.dragAble)
				{
				var thisObj = this;
				node.getOwnerTree().mask(thisObj.maskLoad);
					
					Ext.Ajax.request
					(
						{
						url: this.dragAble["url"],
						method: "POST",
							params: 
							{
							nameTable: this.dragAble["nameTable"],
							idProperty: this.dragAble["fieldKey"],
							idReferenOld: oldParent.id,
							idReferenNew: newParent.id,
							weight: index,
							id: node.id
							},						
							success: function(response, options)
							{
							node.getOwnerTree().unmask();
							var jsonObj = Ext.util.JSON.decode(response.responseText);
							
								if(jsonObj["success"] == false)
								{
									Ext.Msg.show
									(
										{
										title: thisObj.error,
										msg: thisObj.errorMsgServer,
										icon: Ext.MessageBox.ERROR,
										buttons: Ext.MessageBox.OK
										}
									);
									
								node.getTreeStore().load()
								}
							},
							failure: function(response, options)
							{
							node.getOwnerTree().unmask();
							
								Ext.Msg.show
								(
									{
									title: thisObj.error,
									msg: thisObj.errorMsgServer,
									icon: Ext.MessageBox.ERROR,
									buttons: Ext.MessageBox.OK
									}
								);
								
							node.getTreeStore().load()
							}
						}
					);
				}
			}
		},
		setCheckedById: function(ids)
		{
			for(var i = 0; i < ids.length; i++)
			{
				this.getView().node.cascadeBy
				(
					function(rec)
					{
						if(rec.getId() == ids[i])
						{
						rec.set("checked", true);	
						}
					}
				)	
			}
			
		return this;
		},
		setChecked: function(record)
		{
		var ids = [];
		
			for(var i = 0; i < record.length; i++)
			{
			ids[i] = record[i].getId();
			}
			
		return this.setCheckedById(ids);
		}
	}	
);