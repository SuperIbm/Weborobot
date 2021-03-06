Ext.define('User.controller.UserAccountUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserAccountUpdate",
	
	views: ["UserAccountUpdateWindow"],
	stores: ['UserAccount', 'UserGroup', 'UserGroupSelect', 'UserAccountImage'],
	
		routes:
		{
			"userAccountUpdateTab/:id":
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
					if(this.getTabUpdate()) this.getTabUpdate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabUpdate: "User\\.view\\.UserAccountUpdateWindow[name='User'] User\\.view\\.UserAccountUpdateTab[name='User']"
		},
	
		control:
		{			
			"User\\.view\\.UserAccountUpdateWindow[name='User'] User\\.view\\.UserAccountUpdateTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userAccountUpdateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserAccountUpdateGroupGrid[name='User'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("window").down("gridpanel").getStore().load();
				}	
			},			
			"User\\.view\\.UserAccountUpdateWindow[name='User'] button[action=send]":
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
					data["idUser"] = button.up("window").down("form[itemId='enter']").getRecord().getId();
					data["isUserGroupOfUser"] = 1;
						
						button.up("window").down("form[itemId='enter']").submit
						(
							{
							clientValidation: true,
							url: UserAccount.getProxy().getApi()["update"],
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
			"User\\.view\\.UserAccountUpdateWindow[name='User'] button[action=reset]":
			{
				click: function(button)
				{
					var forms = 
					[
					button.up("window").down("form[itemId='enter']"),
					button.up("window").down("form[itemId='personal']"),
					button.up("window").down("form[itemId='adress']"),
					button.up("window").down("form[itemId='firma']")
					];
				
					for(var i = 0; i < forms.length; i++)
					{
					forms[i].loadRecord(forms[i].getRecord());
					}
				
				var FormFirma = button.up("window").down("form[itemId='firma']");	
				var organAbout = Weborobot.Util.parserBrToRn(FormFirma.getRecord().get("organAbout"));
				button.up("window").down("form[itemId='firma'] textareafield[name='organAbout']").setValue(organAbout);
				
				var nameGroups = FormFirma.getRecord().get("nameGroups").split(", ");
				var RecordCurrents = [];
				
					for(var i = 0; i < nameGroups.length; i++)
					{					
						button.up("window").down("gridpanel").getStore().each
						(
							function(record)
							{
								if(record.get("nameGroup") == nameGroups[i])
								{
								RecordCurrents[RecordCurrents.length] = record;	
								}
							}
						);
					}
					
					if(RecordCurrents.length)
					{
					button.up("window").down("gridpanel").getSelectionModel().select(RecordCurrents);	
					}
				}
			},
			"User\\.view\\.UserAccountUpdateWindow[name='User'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);