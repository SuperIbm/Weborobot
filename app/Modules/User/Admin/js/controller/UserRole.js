Ext.define('User.controller.UserRole', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserRole",
	
	views: ["UserRoleGrid"],
	models: ["UserRole"],
	stores: ['UserRole', 'AdminSectionSelect'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("userRoleCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("userRoleUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"userRoleCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("User", "isCreate")) this.create();
				}
			},
			"userRoleUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserRole").isLoaded() == false)
					{
						this.getStore("UserRole").on("load",
							function()
							{
							action.resume();	
							},
							null,
							{
							single: true	
							}
						);
					}
					else action.resume();
				},
				action: function(id)
				{
					if(Admin.getApplication().Access.is("User", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "User\\.view\\.UserRoleGrid[name='User']"
		},
	
		control:
		{
			"User\\.view\\.UserRoleGrid[name='User'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userRoleCreate"
							},
							{
							index: "userRoleCreateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserRoleGrid[name='User'] button[action=update]":
			{
				click: function(button)
				{
				var Grid = button.up("panel").up("panel").down("User\\.view\\.UserRoleGrid");
				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userRoleUpdate",
							value: Grid.getSelection()[0].getId()
							},
							{
							index: "userRoleUpdateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserRoleGrid[name='User'] button[action=destroy]":
			{
				click: function(button)
				{
				var thisObj = this;
				var SelModel = button.up("gridpanel").getSelectionModel();
				var selections = SelModel.getSelection();
				
					for(var i = 0; i < selections.length; i++)
					{
						if(selections[i].getId() == 1 || selections[i].getId() == 2)
						{
							Ext.Msg.show
							(
								{
								title: "Предупреждение!",
								msg: "Вы не можете удалить стандартные роли!",
								icon: Ext.MessageBox.WARNING,
								buttons: Ext.MessageBox.OK
								}
							);
							
						return false;
						}
					}
				
					if(SelModel.hasSelection())
					{
						Ext.Msg.show
						(
							{
							title: "Удалить записи?",
							buttons: Ext.MessageBox.YESNO,
							icon: Ext.MessageBox.QUESTION,
							msg: "Вы точно уверены, что хотите удалить эти записи?",
							
								fn: function(btn)
								{										
									if(btn == "yes")
									{											
									button.up("gridpanel").mask("Загрузка...");
									var ids = new Array();
									
										for(var i = 0; i < selections.length; i++)
										{
											selections[i].count = i + 1;

											selections[i].erase
											(
												{
													success: function(record, operation)
													{
													ids[i] = record.getId();

														if(record.count == selections.length)
														{
														button.up("gridpanel").unmask();
														thisObj.getStore("UserRole").load();
															
															button.up("gridpanel").fireEventArgs("afterDelete", 
																[
																button.up("gridpanel"),
																ids,
																true
																]
															);
														}
													},
													failure: function(record, operation)
													{
													ids[i] = record.getId();

														if(record.count == selections.length)
														{
														button.up("gridpanel").unmask();
														
															button.up("gridpanel").fireEventArgs("afterDelete", 
																[
																button.up("gridpanel"),
																ids,
																true
																]
															);
														}
																												
														Ext.Msg.show
														(
															{
															title: "Ошибка!",
															msg: "Произошла ошибка выполнения программы на сервере!",
															icon: Ext.MessageBox.ERROR,
															buttons: Ext.MessageBox.OK
															}
														);	
													}
												}
											);
										}		
									}
								}
							}
						);
					}
				}
			},
			"User\\.view\\.UserRoleCreatePageTree[name='Page'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("treepanel").getStore().load();
				}	
			},
			"User\\.view\\.UserRoleCreatePageTree[name='Page'] tool[itemId='expand']":
			{
				click: function(button)
				{
				button.up("window").down("treepanel").expandAll(true);
				}
			},
			"User\\.view\\.UserRoleCreatePageTree[name='Page'] tool[itemId='collapse']":
			{
				click: function(button)
				{
				var childNodes = button.up("window").down("treepanel").getRootNode().childNodes[0].childNodes;
				
					for(var i = 0; i < childNodes.length; i++)
					{
					button.up("window").down("treepanel").collapseNode(childNodes[i]);
					}
				}
			},
		},
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			thisObj.getApplication().createController("UserRoleCreate");
			thisObj.getApplication().createController("UserRolePage");
			
				this.WindowCreate = Ext.create("User.view.UserRoleCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"userRoleCreate",
									"userRoleCreateTab"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			
			this.WindowCreate.down("gridpanel").reset();
			this.WindowCreate.down("gridpanel").getStore().getProxy().setExtraParam("idUserRole", null);
			this.WindowCreate.down("gridpanel").getStore().getProxy().setExtraParam("bundleShow", null);
			this.WindowCreate.down("gridpanel").getStore().load();
			
				this.WindowCreate.down("treepanel").getStore().load
				(
					{
						callback: function(records, operation, success)
						{
							if(success == true) thisObj.WindowCreate.down("treepanel").expandAll(true);	
						}
					}
				);
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;

				function show(record)
				{
				thisObj.getApplication().createController("UserRoleUpdate");
				thisObj.getApplication().createController("UserRolePage");
				
					thisObj.WindowUpdate = Ext.create("User.view.UserRoleUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"userRoleUpdate",
										"userRoleUpdateTab"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
				
				thisObj.WindowUpdate.down("gridpanel").reset();				
				var Store = thisObj.WindowUpdate.down("gridpanel").getStore();
				
					if(Store.isLoading() == true)
					{
					thisObj.WindowUpdate.down("gridpanel").reset();
					
						Store.on("load",
							function()
							{
							Store.getProxy().setExtraParam("idUserRole", record.getId());
							Store.getProxy().setExtraParam("bundleShow", null);
							Store.load();	
							},
							null,
							{
							single: true	
							}
						);
					}
					else
					{
					Store.getProxy().setExtraParam("idUserRole", record.getId());
					Store.getProxy().setExtraParam("bundleShow", null);			
					Store.load();
					}
					
					thisObj.WindowUpdate.down("treepanel").getStore().load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.WindowUpdate.down("treepanel").expandAll(true);
								var pages = record.get("pages");
								
									if(pages)
									{
									var recSel = [];
									
										for(var i = 0; i < pages.length; i++)
										{
										recSel[i] = thisObj.WindowUpdate.down("treepanel").getStore().getById(pages[i]["idPage"]);
										}
										
									thisObj.WindowUpdate.down("treepanel").getSelectionModel().select(recSel);
									}
								}
							}
						}
					);
				
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("nameRole"));	
				}
				
			var record = this.getGrid().getStore().getById(id);
			
				if(record) show(record);
				else
				{
				this.getGrid().getStore().getProxy().setExtraParam("id", id);
				
					this.getGrid().getStore().load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.getGrid().getStore().getProxy().setExtraParam("id", null);
								thisObj.getGrid().getStore().load();
								
								show(records[0]);
								}
								else thisObj.WindowUpdate = null;
							}
						}
					);	
				}
			}	
		}
	}
);