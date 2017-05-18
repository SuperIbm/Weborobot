Ext.define('Alias.controller.AliasUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "AliasUpdate",
	
	views: ["AliasUpdateWindow"],
	stores: ["Alias"],
	
		control:
		{			
			"Alias\\.view\\.AliasUpdateWindow[name='Alias'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idAlias"] = button.up("window").down("form").getRecord().getId();
					
					var Alias = Ext.create(this.getModel("Alias"), data);											
						
						Alias.save
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
			"Alias\\.view\\.AliasUpdateWindow[name='Alias'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				
					if(form.getRecord().get("idPage")) button.up("window").down("treepicker[name='idPage']").setValue(form.getRecord().get("idPage")["idPage"]);
				}
			},
			"Alias\\.view\\.AliasUpdateWindow[name='Alias'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);