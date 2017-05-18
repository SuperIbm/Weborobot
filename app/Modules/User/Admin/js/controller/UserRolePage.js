Ext.define('User.controller.UserRolePage', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserRolePage",
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("userPageCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("userPageUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"userPageCreate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Page").isLoaded() == false)
					{
						this.getStore("Page").on("load",
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
					if(Admin.getApplication().Access.is("Page", "isCreate")) this.create(id);
				}
			},
			"userPageUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Page").isLoaded() == false)
					{
						this.getStore("Page").on("load",
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
					if(Admin.getApplication().Access.is("Page", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		tree: "User\\.view\\.UserRoleCreatePageTree[name='User']"
		},
			
		control:
		{
			"User\\.view\\.UserRoleCreatePageTree[name='User'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userPageCreate",
							value: this.getTree().getSelection()[0].getId()
							},
							{
							index: "pageCreateTab",
							value: "tab_1"
							}
						]
					);
						
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserRoleCreatePageTree[name='User'] button[action=update]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userPageUpdate",
							value: this.getTree().getSelection()[0].getId()
							},
							{
							index: "pageUpdateTab",
							value: "tab_1"
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserRoleCreatePageTree[name='User'] button[action=destroy]":
			{
				click: function(button)
				{
				var SelModel = button.up("treepanel").getSelectionModel();
				
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
									button.up("treepanel").mask("Загрузка...");									
									var selections = SelModel.getSelection();
									var ids = new Array();
									
										for(var i = 0; i < selections.length; i++)
										{													
											selections[i].erase
											(
												{
													success: function(record, operation)
													{
													ids[i] = record.getId();
													
														if(i == selections.length)
														{
														button.up("treepanel").unmask();
														
															button.up("treepanel").fireEventArgs("afterDelete", 
																[
																button.up("treepanel"),
																ids,
																true
																]
															);
														}
													},
													failure: function(record, operation)
													{
													ids[i] = record.getId();
													
														if(i == selections.length)
														{
														button.up("treepanel").unmask();
														
															button.up("treepanel").fireEventArgs("afterDelete", 
																[
																button.up("treepanel"),
																ids,
																false
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
			
			"User\\.view\\.UserRoleCreatePageTree[name='User']":
			{
				beforeedit: function(editor, context, eOpts)
				{
				var record = context.record;
				
					if(record.get("isMeetsEdit") == 0) return false;
					else return true;
				},
				itemclick: function(obj, record, item, index, e, eOpts)
				{
				record = this.getTree().getSelectionModel().getSelection();
					
					if(record)
					{					
						if(record.length == 1)
						{
						record = record[0];
						
							if(record.get("isMeetsEdit") == 0)
							{
								if(this.getTree().getButtonCreate())
								{
								this.getTree().getButtonCreate().setDisabled(true);	
								this.getTree().getMenuItemCreate().setDisabled(true);
								}
								
								if(this.getTree().getButtonUpdate())
								{
								this.getTree().getButtonUpdate().setDisabled(true);	
								this.getTree().getMenuItemUpdate().setDisabled(true);
								}
								
								if(this.getTree().getButtonDestroy())
								{					
								this.getTree().getButtonDestroy().setDisabled(true);	
								this.getTree().getMenuItemDestroy().setDisabled(true);
								}
							}
							else
							{
								if(this.getTree().getButtonCreate())
								{
								this.getTree().getButtonCreate().setDisabled(false);	
								this.getTree().getMenuItemCreate().setDisabled(false);
								}
								
								if(this.getTree().getButtonUpdate())
								{
								this.getTree().getButtonUpdate().setDisabled(false);	
								this.getTree().getMenuItemUpdate().setDisabled(false);
								}
								
								if(this.getTree().getButtonDestroy())
								{					
								this.getTree().getButtonDestroy().setDisabled(false);	
								this.getTree().getMenuItemDestroy().setDisabled(false);
								}
							}
						}
						else if(record.length > 1)
						{
						var disabled = false;
						
							for(var i = 0; i < record.length; i++)
							{
								if(record[i].get("isMeetsEdit") == 0)
								{
								disabled = true;
								break;	
								}
							}
							
							if(this.getTree().getButtonDestroy())
							{					
							this.getTree().getButtonDestroy().setDisabled(disabled);	
							this.getTree().getMenuItemDestroy().setDisabled(disabled);
							}
						}
					}
				}
			}
		},
		
		create: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;

			var record = this.getTree().getStore().getById(id);
					
				if(record)
				{
					if(record.get("isMeetsEdit") != 0)
					{
						this.WindowCreate = Ext.create("Page.view.PageCreateWindow",
							{
								listeners:
								{
									close: function()
									{
									thisObj.WindowCreate = null;
									
										var token = Ext.util.History.deleteToken
										(
											[
											"userPageCreate",
											"pageCreateTab"	
											]
										);
										
									thisObj.redirectTo(token);
									}
								}
							}
						).show().center();
						
					this.WindowCreate.setTitle(this.WindowCreate.getTitle() + ": к " + record.get("text"));
					this.WindowCreate.down("form").getForm().id = record.getId();
					}
				}
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;

			var record = this.getTree().getStore().getById(id);
				
				if(record)
				{
					if(record.get("isMeetsEdit") != 0)
					{
					var rec = record;
					
						this.WindowUpdate = Ext.create("Page.view.PageUpdateWindow",
							{
								listeners:
								{
									close: function()
									{
									thisObj.WindowUpdate = null;
									
										var token = Ext.util.History.deleteToken
										(
											[
											"userPageUpdate",
											"pageUpdateTab"	
											]
										);
										
									thisObj.redirectTo(token);
									}
								}
							}
						).show().center();
					
					this.getTree().getSelectionModel().select(record);
					this.WindowUpdate.setTitle(this.WindowUpdate.getTitle() + ": " + record.get("namePage"));
					
						if(record.parentNode.isRoot() == true)
						{
							this.WindowUpdate.down("form").down("comboBoxExt[name='modeAccess']").setStore
							(
								new Ext.data.ArrayStore
								(
									{
										fields:
										[
										"name"
										],
										data:
										[
											[
											"Свободный"
											],
											[
											"Ограниченный"
											]
										]
									}
								)
							);
							
						this.WindowUpdate.down("form").down("textfield[name='nameLink']").setFieldLabel("Ссылка:");
						this.WindowUpdate.down("form").down("textfield[name='nameLink']").setDisabled(true);
						this.WindowUpdate.down("form").down("textfield[name='nameLink']").setHidden(true);
						this.WindowUpdate.down("form").isRoot = true;
						}
						else this.WindowUpdate.down("form").isRoot = false;
								
					this.WindowUpdate.down("form").getForm().loadRecord(record);
						
						if(record.get("modeAccessReal")) this.WindowUpdate.down("form combobox[name='modeAccess']").setValue(record.get("modeAccessReal"));
						else this.WindowUpdate.down("form combobox[name='modeAccess']").setValue(record.get("modeAccess"));
						
					this.WindowUpdate.down("ckeditor").setValue(record.get("html"));
					
					var StorePageTemplate = this.WindowUpdate.down("gridpanel").getStore();
						
						StorePageTemplate.on("load",
							function()
							{
							var recordCurrent = StorePageTemplate.getById(record.get("idPageTemplate"));
								
								if(recordCurrent)
								{
								thisObj.WindowUpdate.down("gridpanel").getSelectionModel().select(recordCurrent);	
								}
							},
							null,
							{
							single: true	
							}
						);			
						
					var StorePageUpdateTreeModule = thisObj.WindowUpdate.down("treepanel[name='PageUpdateTreeModule']").getStore()
					StorePageUpdateTreeModule.getProxy().setExtraParam("idPage", record.get("idPage"));
					StorePageUpdateTreeModule.load();
					}
				}
			}
		}
	}
);