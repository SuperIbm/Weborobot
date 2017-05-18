Ext.define('Support.controller.SupportUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "SupportUpdate",
	
	views: ["SupportUpdateWindow"],
	models: ["Support"],
	stores: ['Support'],
	
		control:
		{			
			"Support\\.view\\.SupportUpdateWindow[name='Support'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idSupport"] = 1;
					var Support = Ext.create(this.getModel("Support"), data);													
						
						Support.save
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
									
								button.up("window").down("form").getRecord().load();
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);
								button.up("window").unmask();
									
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
			"Support\\.view\\.SupportUpdateWindow[name='Support'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Support\\.view\\.SupportUpdateWindow[name='Support'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);