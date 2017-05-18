Ext.define('Component.controller.ComponentUpdate',
	{
	extend: 'Ext.app.Controller',
	
	id: "ComponentUpdate",
	
	views: ["ComponentUpdateWindow"],
	stores: ["Component"],
	
		control:
		{			
			"Component\\.view\\.ComponentUpdateWindow[name='ModuleTree'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;					
					button.up("window").mask("Загрузка...");
					var Component = Ext.create(this.getModel("Component"));
						
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: Component.getProxy().getApi()["update"],
								params: 
								{
								idComponent: button.up("window").down("form").getRecord().getId()
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
									
								thisObj.getStore("Component").load();
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
			"Component\\.view\\.ComponentUpdateWindow[name='ModuleTree'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Component\\.view\\.ComponentUpdateWindow[name='ModuleTree'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);