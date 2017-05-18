Ext.define('Module.controller.ModuleUpdate',
	{
	extend: 'Ext.app.Controller',
	
	id: "ModuleUpdate",
	
	views: ["ModuleUpdateWindow"],
	stores: ["Module"],
	
		control:
		{			
			"Module\\.view\\.ModuleUpdateWindow[name='Module'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idModule"] = button.up("window").down("form").getRecord().getId();
					
					var Module = Ext.create(this.getModel("Module"), data);
						
						Module.save
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
									
								thisObj.getStore("Module").load();
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
			"Module\\.view\\.ModuleUpdateWindow[name='Module'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Module\\.view\\.ModuleUpdateWindow[name='Module'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);