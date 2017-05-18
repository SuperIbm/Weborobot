Ext.define('Widget.controller.WidgetUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "WidgetUpdate",
	
	views: ["WidgetUpdateWindow"],
	stores: ["Widget"],
	
		control:
		{			
			"Widget\\.view\\.WidgetUpdateWindow[name='Widget'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idWidget"] = button.up("window").down("form").getRecord().getId();
					
					var Widget = Ext.create(this.getModel("Widget"), data);															
						
						Widget.save
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
									
								thisObj.getStore("Widget").load();
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
			"Widget\\.view\\.WidgetUpdateWindow[name='Widget'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Widget\\.view\\.WidgetUpdateWindow[name='Widget'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);