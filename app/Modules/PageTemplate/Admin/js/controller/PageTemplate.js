Ext.define('PageTemplate.controller.PageTemplate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PageTemplate",
	
	views: ["PageTemplateGrid"],
	models: ["PageTemplate"],
	stores: ['PageTemplate'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("pageTemplateCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("pageTemplateUpdate") && this.WindowUpdate) this.WindowUpdate.close();
				}
			},
			"pageTemplateCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("PageTemplate", "isCreate")) this.create();
				}
			},
			"pageTemplateUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("PageTemplate").isLoaded() == false)
					{
						this.getStore("PageTemplate").on("load",
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
					if(Admin.getApplication().Access.is("PageTemplate", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "PageTemplate\\.view\\.PageTemplateGrid[name='PageTemplate']"
		},
	
		control:
		{
			"PageTemplate\\.view\\.Panel tool[itemId='FilesystemTpl']":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "section",
							value: "Filesystem"
							},
							{
							index: "dirSelect",
							value: "..\\tpl\\"	
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"PageTemplate\\.view\\.PageTemplateGrid[name='PageTemplate'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "pageTemplateCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},			
			"PageTemplate\\.view\\.PageTemplateGrid[name='PageTemplate'] button[action=update]":
			{
				click: function(button)
				{								
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "pageTemplateUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"PageTemplate\\.view\\.PageTemplateGrid[name='PageTemplate'] button[action=destroy]":
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
														thisObj.getStore("PageTemplate").load();
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
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;

				this.WindowCreate = Ext.create("PageTemplate.view.PageTemplateCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"pageTemplateCreate"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;

				function show()
				{
					thisObj.WindowUpdate = Ext.create("PageTemplate.view.PageTemplateUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"pageTemplateUpdate"
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
			
				if(record) show();
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