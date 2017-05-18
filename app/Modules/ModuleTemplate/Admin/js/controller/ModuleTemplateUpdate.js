Ext.define('ModuleTemplate.controller.ModuleTemplateUpdate',
	{
	extend: 'Ext.app.Controller',
	
	id: "ModuleTemplateUpdate",
	
	views: ["ModuleTemplateUpdateWindow"],
	stores: ["ModuleTemplate"],
	
		control:
		{			
			"ModuleTemplate\\.view\\.ModuleTemplateUpdateWindow[name='ModuleTree'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;					
					button.up("window").mask("Загрузка...");
					var ModuleTemplate = Ext.create(this.getModel("ModuleTemplate"));
						
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: ModuleTemplate.getProxy().getApi()["update"],
								params: 
								{
								idModuleTemplate: button.up("window").down("form").getRecord().getId()
								},
								success: function(form, action)
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
									
								thisObj.getStore("ModuleTemplate").load();
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
			"ModuleTemplate\\.view\\.ModuleTemplateUpdateWindow[name='ModuleTree'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"ModuleTemplate\\.view\\.ModuleTemplateUpdateWindow[name='ModuleTree'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);