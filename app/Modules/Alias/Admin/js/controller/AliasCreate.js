Ext.define('Alias.controller.AliasCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "AliasCreate",
	
	views: ["AliasCreateWindow"],
	stores: ['Alias'],
	
		control:
		{			
			"Alias\\.view\\.AliasCreateWindow[name='Alias'] button[action=send]":
			{
				click: function(button)
				{				
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					
					var Alias = Ext.create(this.getModel("Alias"), data);				
					Alias.setId(null);
					
						Alias.save
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
									
								button.up("window").down("form").reset();
								button.up("window").down("treepicker[name='idPage']").setRawValue("");
								thisObj.getStore("Alias").load();	
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
			"Alias\\.view\\.AliasCreateWindow[name='Alias'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				button.up("window").down("treepicker[name='idPage']").setRawValue("");
				}
			},
			"Alias\\.view\\.AliasCreateWindow[name='Alias'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);