Ext.define('User.controller.UserBlockIp', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserBlockIp",
	
	views: ["UserBlockIpGrid"],
	models: ["UserBlockIp"],
	stores: ['UserBlockIp'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("userBlockIpCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("userBlockIpUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"userBlockIpCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("User", "isCreate")) this.create();
				}
			},
			"userBlockIpUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserBlockIp").isLoaded() == false)
					{
						this.getStore("UserBlockIp").on("load",
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
		grid: "User\\.view\\.UserBlockIpGrid[name='User']"
		},
	
		control:
		{
			"User\\.view\\.UserBlockIpGrid[name='User'] button[action=create]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userBlockIpCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserBlockIpGrid[name='User'] button[action=update]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userBlockIpUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserBlockIpGrid[name='User'] button[action=destroy]":
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
															thisObj.getStore("UserBlockIp").load();
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

			thisObj.getApplication().createController("UserBlockIpCreate");
			
				this.WindowCreate = Ext.create("User.view.UserBlockIpCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"userBlockIpCreate"
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
				thisObj.getApplication().createController("UserBlockIpUpdate");
				
					thisObj.WindowUpdate = Ext.create("User.view.UserBlockIpUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"userBlockIpUpdate"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
						
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("ip"));	
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