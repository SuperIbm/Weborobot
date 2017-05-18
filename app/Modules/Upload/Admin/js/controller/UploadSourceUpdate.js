Ext.define('Upload.controller.UploadSourceUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UploadSourceUpdate",
	
	views: ["UploadSourceUpdateWindow"],
	stores: ["UploadSource"],
	
		control:
		{			
			"Upload\\.view\\.UploadSourceUpdateWindow[name='Upload'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;				
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["idUploadSource"] = button.up("window").down("form").getRecord().getId();
					
					var UploadSource = Ext.create(this.getModel("UploadSource"), data);															
						
						UploadSource.save
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
									
								thisObj.getStore('UploadSource').load();
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
			"Upload\\.view\\.UploadSourceUpdateWindow[name='Upload'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Upload\\.view\\.UploadSourceUpdateWindow[name='Upload'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);