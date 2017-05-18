Ext.define('User.controller.UserGroupCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserGroupCreate",
	
	views: ["UserGroupCreateWindow"],
	stores: ['UserGroup', 'PageSelect'],
	
		routes:
		{
			"userRoleGroupTab/:id":
			{
				action: function(id)
				{
				this.getTabCreate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabCreate: "User\\.view\\.UserGroupCreateWindow[name='User'] User\\.view\\.UserGroupCreateTab[name='User']"
		},
	
		control:
		{			
			
			"User\\.view\\.UserGroupCreateWindow[name='User'] User\\.view\\.UserGroupCreateTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userGroupCreateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserGroupCreatePageTree[name='Page'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("treepanel").getStore().load();
				}	
			},
			"User\\.view\\.UserGroupCreatePageTree[name='Page'] tool[itemId='expand']":
			{
				click: function(button)
				{
				button.up("window").down("treepanel").expandAll(true);
				}
			},
			"User\\.view\\.UserGroupCreatePageTree[name='Page'] tool[itemId='collapse']":
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
			"User\\.view\\.UserGroupCreateUserRoleGrid[name='User'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("gridpanel").getStore().load();
				}	
			},
			"User\\.view\\.UserGroupCreateWindow[name='User'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
										
					button.up("window").mask("Загрузка...");
					var data = button.up("window").down("form").getValues();
					
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
					UserGroup.setId(null);
					
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
									
								button.up("window").down("form").reset();
								button.up("window").down("gridpanel").getSelectionModel().deselectAll();
								
								thisObj.getStore('UserGroup').load();								
									button.up("window").down("form").fireEventArgs("actionForm", 
										[
										button.up("window").down("form"),
										"create"
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
											icon: Ext.MessageBox.ERROR,
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
							msg: "Некоторые поля в форме заполнены некорректно!",
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);	
					}
				}
			},
			"User\\.view\\.UserGroupCreateWindow[name='User'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				
				button.up("window").down("gridpanel").getSelectionModel().deselectAll();
				button.up("window").down("treepanel").getStore().load();
				}
			},
			"User\\.view\\.UserGroupCreateWindow[name='User'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);