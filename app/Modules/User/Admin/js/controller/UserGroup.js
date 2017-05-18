Ext.define('User.controller.UserGroup', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserGroup",
	
	views: ["UserGroupGrid"],
	models: ["UserGroup"],
	stores: ['UserGroup', 'UserRoleSelect', 'UserGroupSelect', 'PageSelect'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("userGroupCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("userGroupUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"userGroupCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("User", "isCreate")) this.create();
				}
			},
			"userGroupUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserGroup").isLoaded() == false)
					{
						this.getStore("UserGroup").on("load",
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
		grid: "User\\.view\\.UserGroupGrid[name='User']"
		},
	
		control:
		{
			"User\\.view\\.UserGroupGrid[name='User'] button[action=create]":
			{
				click: function(button)
				{					
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userGroupCreate"
							},
							{
							index: "userGroupCreateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserGroupGrid[name='User'] button[action=update]":
			{
				click: function(button)
				{
				var Grid = button.up("panel").up("panel").down("User\\.view\\.UserGroupGrid");
				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userGroupUpdate",
							value: Grid.getSelection()[0].getId()
							},
							{
							index: "userGroupUpdateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserGroupGrid[name='User'] button[action=destroy]":
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
							if(selections[i].getId() == 1 || selections[i].getId() == 2 || selections[i].getId() == 3)
							{
								Ext.Msg.show
								(
									{
									title: "Предупреждение!",
									msg: "Вы не можете удалить стандартные группы!",
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
									var ids = [];
									
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
														thisObj.getStore("UserGroup").load();
														
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
			
			"User\\.view\\.UserRoleCreateForm[name='User']":
			{
				actionForm: function(form, type)
				{
				this.getStore('UserRoleSelect').load();
				}
			},
			"User\\.view\\.UserRoleUpdateForm[name='User']":
			{
				actionForm: function(form, type)
				{
				this.getStore('UserRoleSelect').load();
				}
			},
			
			"Page\\.view\\.PageCreateSettingForm[name='Page']":
			{
				actionForm: function(form, type)
				{
				this.getStore('PageSelect').load();
				}
			},
			"Page\\.view\\.PageUpdateSettingForm[name='Page']":
			{
				actionForm: function(form, type)
				{
				this.getStore('PageSelect').load();
				}
			}
		},
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;

			thisObj.getApplication().createController("UserGroupCreate");
			
				this.WindowCreate = Ext.create("User.view.UserGroupCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"userGroupCreate",
									"userGroupCreateTab"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
				
			this.WindowCreate.down("treepanel").getStore().getProxy().setExtraParam("isCheckedAccess", true);
				
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
				thisObj.getApplication().createController("UserGroupUpdate");
				
					thisObj.WindowUpdate = Ext.create("User.view.UserGroupUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"userGroupUpdate",
										"userGroupUpdateTab"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
				thisObj.WindowUpdate.down("treepanel").getStore().getProxy().setExtraParam("isCheckedAccess", true);		
				
					thisObj.WindowUpdate.down("treepanel").getStore().load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.WindowUpdate.down("treepanel").expandAll(true);
								var idPages = [],
									pages = record.get("pages");

                                    if(pages)
                                    {
                                        for(var i = 0; i < pages.length; i++)
                                        {
                                        idPages[i] = pages[i]["idPage"];
                                        }
                                    }

								thisObj.WindowUpdate.down("treepanel").setCheckedSelection(idPages);
								}
							}
						}
					);
				
				var roles = record.get("roles");
				var recordCurrents = [];

				    if(roles)
                    {
                        for(var i = 0; i < roles.length; i++)
                        {
                            thisObj.WindowUpdate.down("gridpanel").getStore().each
                            (
                                function(record)
                                {
                                    if(record.get("idUserRole") == roles[i]["idUserRole"])
                                    {
                                    recordCurrents[recordCurrents.length] = record;
                                    }
                                }
                            );
                        }

                        if(recordCurrents.length) thisObj.WindowUpdate.down("gridpanel").getSelectionModel().select(recordCurrents);
                    }

				
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("nameGroup"));	
				}
			
			var record = thisObj.getGrid().getStore().getById(id);
			
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