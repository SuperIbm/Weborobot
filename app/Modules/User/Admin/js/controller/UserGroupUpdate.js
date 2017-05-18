Ext.define('User.controller.UserGroupUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserGroupUpdate",
	
	views: ["UserGroupUpdateWindow"],
	stores: ['UserGroup'],
	
		routes:
		{
			"userGroupUpdateTab/:id":
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
				this.getTabCreate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabCreate: "User\\.view\\.UserGroupUpdateWindow[name='User'] User\\.view\\.UserGroupUpdateTab[name='User']"
		},
	
		control:
		{			
			"User\\.view\\.UserGroupUpdateWindow[name='User'] User\\.view\\.UserGroupUpdateTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userGroupUpdateTab",
							value: newCard.itemId
							}
						]
					);
								
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserGroupUpdatePageTree[name='User'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("treepanel").getStore().load();
				}	
			},
			"User\\.view\\.UserGroupUpdatePageTree[name='User'] tool[itemId='expand']":
			{
				click: function(button)
				{
				button.up("window").down("treepanel").expandAll(true);
				}
			},
			"User\\.view\\.UserGroupUpdatePageTree[name='User'] tool[itemId='collapse']":
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
			"User\\.view\\.UserGroupUpdateUserRoleGrid[name='User'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("gridpanel").getStore().load();
				}	
			},
			"User\\.view\\.UserGroupUpdateWindow[name='User'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
						if(button.up("window").down("form").getRecord().getId() != 1 && button.up("window").down("form").getRecord().getId() != 2)
						{
						var thisObj = this;
									
						button.up("window").mask("Загрузка...");
						var data = button.up("window").down("form").getValues();
						data["isDeleteUserGroupRole"] = 1;
                        data["isDeleteUserGroupPage"] = 1;
						var pages = button.up("window").down("treepanel").getCheckedSelection();
						
							for(var i = 0; i < pages.length; i++)
							{
							data["pages[" + pages[i] + "]"] = pages[i];	
							}
						
							if(button.up("window").down("gridpanel").getSelectionModel().hasSelection())
							{	
							var roles = button.up("window").down("gridpanel").getSelectionModel().getSelection();
							
								for(var i = 0; i < roles.length; i++)
								{
								data["roles[" + roles[i].getId() + "]"] = roles[i].getId();	
								}
							}
						
						var UserGroup = Ext.create(this.getModel("UserGroup"), data);	
						UserGroup.setId(button.up("window").down("form").getRecord().getId());
						UserGroup.phantom = false;
						
							UserGroup.save
							(
								{						
									success: function(model, operation)
									{
									button.up("window").unmask();
										
										Ext.Msg.show
										(
											{
											title: "Данные добавлены!",
											msg: "Введенные вами данные были удачно добавлены!",
											icon: Ext.MessageBox.INFO,
											buttons: Ext.MessageBox.OK
											}
										);
									
									thisObj.getStore("UserGroup").load();
										
										button.up("window").down("form").fireEventArgs("actionForm", 
											[
											button.up("window").down("form"),
											"update"
											]
										);
									},
									failure: function(model, operation)
									{
									var result = Ext.decode(operation.getResponse().responseText);
									button.up("window").unmask();
									
										if(result.errormsg)
										{
											Ext.Msg.show
											(
												{
												title: "Ошибка!",
												msg: result.errormsg,
												icon: Ext.MessageBox.ERROR,
												buttons: Ext.MessageBox.OK
												}
											);
										}
										else
										{
											Ext.Msg.show
											(
												{
												title: "Ошибка!",
												msg: "Произошла ошибка выполнения программы на сервере!",
												icon: Ext.MessageBox.WARNING,
												buttons: Ext.MessageBox.OK
												}
											);	
										}
									}
								}
							);
						}
						else
						{
							Ext.Msg.show
							(
								{
								title: "Предупреждение!",
								msg: "Вы не можете править стандартную группу!",
								icon: Ext.MessageBox.INFO,
								buttons: Ext.MessageBox.OK
								}
							);	
						}
					}
					else
					{
						Ext.Msg.show
						(
							{
							title: "Предупреждение!",
							msg: "Некоторые поля в форме заполнены некорректно!",
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);	
					}
				}
			},
			"User\\.view\\.UserGroupUpdateWindow[name='User'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").loadRecord(button.up("window").down("form").getRecord());
				
				button.up("window").down("gridpanel").getSelectionModel().deselectAll();
				button.up("window").down("treepanel").getStore().load();
				}
			},
			"User\\.view\\.UserGroupUpdateWindow[name='User'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);