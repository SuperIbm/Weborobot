Ext.define('ModuleTemplate.controller.ModuleTemplate',
	{
	extend: 'Ext.app.Controller',
	
	id: "ModuleTemplate",
	
	views: ["ModuleTemplateGrid"],
	models: ["ModuleTemplate", "ModuleTemplateSelect"],
	stores: ['ModuleTree', 'ModuleTemplate', "ModuleTemplateSelect"],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("componentTemplateCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("componentTemplateUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"componentTemplateCreate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("ModuleTree").isLoaded() == false)
					{					
						this.getStore("ModuleTree").on("load",
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
					if(Admin.getApplication().Access.is("ModuleTemplate", "isCreate")) this.create(id);
				}
			},
			"componentTemplateUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("ModuleTemplate").isLoaded() == false)
					{
						this.getStore("ModuleTemplate").on("load",
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
					if(Admin.getApplication().Access.is("ModuleTemplate", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "ModuleTemplate\\.view\\.ModuleTemplateGrid[name='ModuleTree']",
		tree: "ModuleTemplate\\.view\\.ModuleTree[name='ModuleTree']"
		},
	
		control:
		{
			"ModuleTemplate\\.view\\.ModuleTemplateGrid[name='ModuleTree'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "componentTemplateCreate",
							value: this.getTree().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"ModuleTemplate\\.view\\.ModuleTemplateGrid[name='ModuleTree'] button[action=update]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "componentTemplateUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"ModuleTemplate\\.view\\.ModuleTemplateGrid[name='ModuleTree'] button[action=destroy]":
			{
				click: function(button)
				{
				var thisObj = this;
				var SelModel = button.up("gridpanel").getSelectionModel();
				
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
									var selections = SelModel.getSelection();
									
										for(var i = 0; i < selections.length; i++)
										{
											selections[i].count = i + 1;

											selections[i].erase
											(
												{
													success: function(record, operation)
													{
														if(record.count == selections.length)
														{
															button.up("gridpanel").unmask();
															thisObj.getStore("ModuleTemplate").load();
														}
													},
													failure: function(record, operation)
													{
														if(record.count == selections.length) button.up("gridpanel").unmask();
																												
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
			}
		},
		
		create: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;
            thisObj.getApplication().createController("ModuleTemplateCreate");

				this.WindowCreate = Ext.create("ModuleTemplate.view.ModuleTemplateCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"componentTemplateCreate",
									"componentTemplateCreateTab"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
				
			this.WindowCreate.setTitle(this.WindowCreate.getTitle() + ": к " + this.getTree().getSelection()[0].get("text"));
			this.WindowCreate.down("form").getForm().id = id;
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;
			thisObj.getApplication().createController("ModuleTemplateUpdate");

				function show(record)
				{
					thisObj.WindowUpdate = Ext.create("ModuleTemplate.view.ModuleTemplateUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"componentTemplateUpdate",
										"componentTemplateUpdateTab"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelTemplate"));
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