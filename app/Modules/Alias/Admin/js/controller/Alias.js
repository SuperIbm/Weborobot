Ext.define('Alias.controller.Alias', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Alias",
	
	views: ["AliasGrid"],
	models: ["Alias"],
	stores: ['Alias'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("aliasCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("aliasUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"aliasCreate":
			{
				action: function()
				{				
					if(Admin.getApplication().Access.is("Alias", "isCreate")) this.create();
				}
			},
			"aliasUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Alias").isLoaded() == false)
					{
						this.getStore("Alias").on("load",
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
					if(Admin.getApplication().Access.is("Alias", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Alias\\.view\\.AliasGrid[name='Alias']"
		},
	
		control:
		{
			"Alias\\.view\\.AliasGrid[name='Alias'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "aliasCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Alias\\.view\\.AliasGrid[name='Alias'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "aliasUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Alias\\.view\\.AliasGrid[name='Alias'] button[action=destroy]":
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
															thisObj.getStore("Alias").load();
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

			thisObj.getApplication().createController("AliasCreate");
			
				this.WindowCreate = Ext.create("Alias.view.AliasCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"aliasCreate"
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

				function show(record)
				{
				thisObj.getApplication().createController("AliasUpdate");
				
					thisObj.WindowUpdate = Ext.create("Alias.view.AliasUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"aliasUpdate"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("pattern"));
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