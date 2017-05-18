Ext.define('User.controller.UserAccountCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserAccountCreate",
	
	views: ["UserAccountCreateWindow"],
	stores: ['UserAccount', 'UserGroupSelect'],
	
		routes:
		{
			"userAccountUpdateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserGroupSelect").isLoaded() == false)
					{
						this.getStore("UserGroupSelect").on("load",
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
					if(this.getTabUpdate()) this.getTabUpdate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabUpdate: "User\\.view\\.UserAccountUpdateWindow[name='User'] UserAccount\\.view\\.UserAccountUpdateTab[name='User']"
		},
	
		control:
		{			
			"User\\.view\\.UserAccountCreateWindow[name='User'] User\\.view\\.UserAccountCreateTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userAccountCreateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserAccountCreateGroupGrid[name='User'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("gridpanel").getStore().load();
				}	
			},
			"User\\.view\\.UserAccountCreateWindow[name='User'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form[itemId='enter']").isValid() == true)
					{	
					var thisObj = this;
									
					button.up("window").mask("Загрузка...");
					
					var data = {};
					Ext.apply(data, button.up("window").down("form[itemId='enter']").getValues());
					Ext.apply(data, button.up("window").down("form[itemId='personal']").getValues());
					Ext.apply(data, button.up("window").down("form[itemId='adress']").getValues());
					Ext.apply(data, button.up("window").down("form[itemId='pasport']").getValues());
					Ext.apply(data, button.up("window").down("form[itemId='firma']").getValues());
					
						if(button.up("window").down("gridpanel").getSelectionModel().hasSelection())
						{	
						var groups = button.up("window").down("gridpanel").getSelectionModel().getSelection();
						
							for(var i = 0; i < groups.length; i++)
							{
							data["groups[" + groups[i].getId() + "]"] = groups[i].getId();	
							}
						}
					
					var UserAccount = Ext.create(this.getModel("UserAccount"));				
						
						button.up("window").down("form[itemId='image']").submit
						(
							{
							clientValidation: true,
							url: UserAccount.getProxy().getApi()["create"],
							params: data,
								success: function(form, action)
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
									
								button.up("window").down("form[itemId='enter']").reset();
								button.up("window").down("form[itemId='personal']").reset();
								button.up("window").down("form[itemId='adress']").reset();
								button.up("window").down("form[itemId='pasport']").reset();
								button.up("window").down("form[itemId='firma']").reset();
								button.up("window").down("form[itemId='image']").reset();
								
								button.up("window").down("gridpanel").getSelectionModel().deselectAll();
								thisObj.getStore('UserAccount').load();
								},
								failure: function(form, action)
								{
								button.up("window").unmask();
									
									if(action.result.errormsg)
									{
										Ext.Msg.show
										(
											{
											title: "Ошибка!",
											msg: action.result.errormsg,
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
			"User\\.view\\.UserAccountCreateWindow[name='User'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form[itemId='enter']").reset();
				button.up("window").down("form[itemId='personal']").reset();
				button.up("window").down("form[itemId='adress']").reset();
				button.up("window").down("form[itemId='pasport']").reset();
				button.up("window").down("form[itemId='firma']").reset();
				button.up("window").down("form[itemId='image']").reset();
				
				button.up("window").down("gridpanel").getSelectionModel().deselectAll();
				}
			},
			"User\\.view\\.UserAccountCreateWindow[name='User'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);