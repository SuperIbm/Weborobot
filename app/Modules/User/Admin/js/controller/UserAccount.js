Ext.define('User.controller.UserAccount', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserAccount",
	
	views: ["UserAccountGrid"],
	models: ["UserAccount"],
	stores: ['UserAccount', 'UserGroupSelect', 'UserRoleSelect'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("userAccountCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("userAccountUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"userAccountCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("User", "isCreate")) this.create();
				}
			},
			"userAccountUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserAccount").isLoaded() == false)
					{
						this.getStore("UserAccount").on("load",
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
		grid: "User\\.view\\.UserAccountGrid[name='User']"
		},
	
		control:
		{
			"User\\.view\\.UserAccountGrid[name='User'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userAccountCreate"
							},
							{
							index: "userAccountCreateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserAccountGrid[name='User'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userAccountUpdate",
							value: this.getGrid().getSelection()[0].getId()
							},
							{
							index: "userAccountUpdateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserAccountGrid[name='User'] button[action=destroy]":
			{
				click: function(button)
				{
				var thisObj = this;
				var SelModel = button.up("gridpanel").getSelectionModel();
				
					if(SelModel.hasSelection())
					{
					var selections = SelModel.getSelection();
					
						for(var i = 0; i < selections.length; i++)
						{
							if(selections[i].getId() == 1)
							{
								Ext.Msg.show
								(
									{
									title: "Предупреждение!",
									msg: "Вы не можете удалить главного пользователя!",
									icon: Ext.MessageBox.WARNING,
									buttons: Ext.MessageBox.OK
									}
								);
								
							return false;
							}
						}
						
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
															thisObj.getStore("UserAccount").load();
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
			},
			
			"User\\.view\\.UserGroupCreateForm[name='User']":
			{
				actionForm: function(form, type)
				{
				this.getStore('UserGroupSelect').load();
				}
			},
			
			"User\\.view\\.UserGroupGrid[name='User']":
			{
				afterDelete: function(frid, ids, success)
				{
				this.getStore('UserGroupSelect').load();	
				}
			},
			"User\\.view\\.UserAccountCreateGroupGrid[name='User']":
			{
				afterDelete: function(frid, ids, success)
				{
				this.getStore('UserGroup').load();	
				}
			}
		},
		
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			thisObj.getApplication().createController("UserAccountCreate");
				
				this.WindowCreate = Ext.create("User.view.UserAccountCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"userAccountCreate",
									"userAccountCreateTab"	
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
				thisObj.getApplication().createController("UserAccountUpdate");
				thisObj.getApplication().createController("UserAccountImage");
				
					thisObj.WindowUpdate = Ext.create("User.view.UserAccountUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"userAccountUpdate",
										"userAccountUpdateTab"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
						
				thisObj.getGrid().getSelectionModel().select(record);
							
				var groups = record.get("groups");
				var recordCurrents = [];
				
					thisObj.WindowUpdate.down("gridpanel").getStore().on("load", 
						function()
						{						
							for(var i = 0; i < groups.length; i++)
							{
                                if(groups[i]["usergroup"])
                                {
                                    for(var y = 0; y < groups[i]["usergroup"].length; y++)
                                    {
                                        thisObj.WindowUpdate.down("gridpanel").getStore().each
                                        (
                                            function(record)
                                            {
                                                if(record.get("idUserGroup") == groups[i]["usergroup"][y]["idUserGroup"])
                                                {
                                                recordCurrents[recordCurrents.length] = record;
                                                }
                                            }
                                        );
                                    }
                                }
							}

                            if(recordCurrents.length) thisObj.WindowUpdate.down("gridpanel").getSelectionModel().select(recordCurrents);
						},
						null,
						{
						single: true	
						}
					);
				
				thisObj.WindowUpdate.down("form[itemId='enter']").getForm().loadRecord(record);
				thisObj.WindowUpdate.down("form[itemId='personal']").getForm().loadRecord(record);
				thisObj.WindowUpdate.down("form[itemId='adress']").getForm().loadRecord(record);
				thisObj.WindowUpdate.down("form[itemId='pasport']").getForm().loadRecord(record);
				thisObj.WindowUpdate.down("form[itemId='firma']").getForm().loadRecord(record);
				
				var organAbout = Weborobot.Util.parserBr2Rn(record.get("organAbout"));
				thisObj.WindowUpdate.down("form[itemId='firma'] textareafield[name='organAbout']").setValue(organAbout);
				
				thisObj.WindowUpdate.down("imagePanel").setImageByArray(record.get("idImageMiddle"));
				
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("login"));
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