Ext.define('Widget.controller.WidgetCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "WidgetCreate",
	
	views: ["WidgetCreateWindow"],
	stores: ["Widget"],
	
		control:
		{			
			"Widget\\.view\\.WidgetCreateWindow[name='Widget'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					button.up("window").mask("Загрузка...");
					
					var Widget = Ext.create(this.getModel("Widget"));
					
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: Widget.getProxy().getApi()["create"],							
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
									
								button.up("window").down("form").reset();
								thisObj.getStore("Widget").load();	
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
											msg: "Произошла ошибка выполнения программы на сервере!</br>Описание ошибки: " + action.result.errormsg + ".",
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
			"Widget\\.view\\.WidgetCreateWindow[name='Widget'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Widget\\.view\\.WidgetCreateWindow[name='Widget'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);