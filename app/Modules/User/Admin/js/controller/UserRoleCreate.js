Ext.define('User.controller.UserRoleCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserRoleCreate",
	
	views: ["UserRoleCreateWindow"],
	stores: ['UserRoleSelect'],
	
		routes:
		{
			"userRoleCreateTab/:id":
			{
				action: function(id)
				{
				this.getTabCreate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabCreate: "User\\.view\\.UserRoleCreateWindow[name='User'] User\\.view\\.UserRoleCreateTab[name='User']"
		},
	
		control:
		{			
			"User\\.view\\.UserRoleCreateWindow[name='User'] User\\.view\\.UserRoleCreateTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userRoleCreateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserRoleCreateWindow[name='User'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
									
					button.up("window").mask("Загрузка...");
					var data = button.up("window").down("form").getValues();
					Ext.apply(data, button.up("window").down("gridpanel").getValues());
					
					var Tree = button.up("window").down("treepanel");
					
						if(Tree.getSelectionModel().hasSelection() == true)
						{
						var records = Tree.getSelectionModel().getSelection();
						
							for(var i = 0; i < records.length; i++)
							{
							data["pages[" + records[i].getId() + "]"] = records[i].getId();	
							}
						}
					
					var UserRole = Ext.create(this.getModel("UserRole"), data);				
					UserRole.setId(null);
					
						UserRole.save
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
								thisObj.getStore("UserRole").load();
								button.up("window").down("gridpanel").reset();
								button.up("window").down("treepanel").getSelectionModel().deselectAll();
								
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
			"User\\.view\\.UserRoleCreateWindow[name='User'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				button.up("window").down("gridpanel").reset();
				}
			},
			"User\\.view\\.UserRoleCreateWindow[name='User'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);