Ext.define('Module.controller.ModuleCreate',
	{
	extend: 'Ext.app.Controller',
	
	id: "ModuleCreate",
	
	views: ["ModuleCreateWindow"],
	stores: ["Module"],
	
		control:
		{			
			"Module\\.view\\.ModuleCreateWindow[name='Module'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					button.up("window").mask("Загрузка...");
					
					var Module = Ext.create(this.getModel("Module"));
					
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: Module.getProxy().getApi()["create"],
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
								thisObj.getStore("Module").load();
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
			"Module\\.view\\.ModuleCreateWindow[name='Module'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Module\\.view\\.ModuleCreateWindow[name='Module'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);