Ext.define('Component.controller.ComponentCreate',
	{
	extend: 'Ext.app.Controller',
	
	id: "ComponentCreate",
	
	views: ["ComponentCreateWindow"],
	stores: ["Component"],
	
		control:
		{			
			"Component\\.view\\.ComponentCreateWindow[name='ModuleTree'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idModule"] = button.up("window").down("form").getForm().id;
					
					var Component = Ext.create(this.getModel("Component"), data);
					Component.setId(null);
					
						Component.save
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
									
								thisObj.getStore("Component").load();
								button.up("window").down("form").reset();
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
			"Component\\.view\\.ComponentCreateWindow[name='ModuleTree'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Component\\.view\\.ComponentCreateWindow[name='ModuleTree'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);