Ext.define('User.controller.UserRoleUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserRoleUpdate",
	
	views: ["UserRoleUpdateWindow"],
	stores: ['UserRole', 'UserRoleSelect'],
	
		routes:
		{
			"userRoleUpdateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserRole").isLoaded() == false)
					{
						this.getStore("UserRole").on("load",
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
		tabCreate: "User\\.view\\.UserRoleUpdateWindow[name='User'] User\\.view\\.UserRoleUpdateTab[name='User']"
		},
	
		control:
		{			
			"User\\.view\\.UserRoleUpdateWindow[name='User'] User\\.view\\.UserRoleUpdateTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userRoleUpdateTab",
							value: newCard.itemId
							}
						]
					);
								
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserRoleUpdateWindow[name='User'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
						if(button.up("window").down("form").getRecord().getId() != 1 || button.up("window").down("gridpanel").isSelectAll() == true)
						{
						var thisObj = this;
						button.up("window").mask("Загрузка...");
						
						var data = button.up("window").down("form").getValues();
						data["isDeleteUserRoleAdminSection"] = 1;
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
						
						data["isDeleteUserRolePage"] = 1;
						
						var UserRole = Ext.create(this.getModel("UserRole"), data);
						UserRole.setId(button.up("window").down("form").getRecord().getId());
						UserRole.phantom = false;										
							
							UserRole.save
							(
								{
									success: function(model, operation)
									{
									button.up("window").unmask();
										
										Ext.Msg.show
										(
											{
											title: "Данные изменены!",
											msg: "Введенные вами данные были удачно изменены!",
											icon: Ext.MessageBox.INFO,
											buttons: Ext.MessageBox.OK
											}
										);
										
									thisObj.getStore("UserRole").load();
									
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
												icon: Ext.MessageBox.ERROR,
												buttons: Ext.MessageBox.OK
												}
											);	
										}
									}
								}
							);	
						}
						else if(button.up("window").down("form").getRecord().getId() == 1 || button.up("window").down("gridpanel").isSelectAll() == false)
						{
							Ext.Msg.show
							(
								{
								title: "Предупреждение!",
								msg: "Вы не можете понижать права главной роли!",
								icon: Ext.MessageBox.WARNING,
								buttons: Ext.MessageBox.OK
								}
							);	
						}
						else
						{
							Ext.Msg.show
							(
								{
								title: "Предупреждение!",
								msg: "Вы не можете править стандартные роли!",
								icon: Ext.MessageBox.WARNING,
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
			"User\\.view\\.UserRoleUpdateWindow[name='User'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				button.up("window").down("gridpanel").getStore().load();
				}
			},
			"User\\.view\\.UserRoleUpdateWindow[name='User'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);