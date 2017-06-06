Ext.define('Publication.controller.PublicationSectionUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationSectionUpdate",
	
	views: ["PublicationSectionUpdateWindow"],
	stores: ["PublicationSection"],
	
		control:
		{			
			"Publication\\.view\\.PublicationSectionUpdateWindow[name='Publication'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{	
					var thisObj = this;				
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					
					var Publication = Ext.create(this.getModel("PublicationSection"), data);																
					Publication.setId(button.up("window").down("form").getRecord().getId());
					Publication.phantom = false;
						
						Publication.save
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
									
								thisObj.getStore("PublicationSection").load();							
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);
								button.up("window").unmask();
									
									if(result.errortype == "isExist")
									{
										Ext.Msg.show
										(
											{
											title: "Ошибка!",
											msg: "Вы не можете добавить раздел с таким названием, т.к. он уже есть в базе данных!",
											icon: Ext.MessageBox.WARNING,
											buttons: Ext.MessageBox.OK
											}
										);
									}
									else if(result.errormsg)
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
			"Publication\\.view\\.PublicationSectionUpdateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Publication\\.view\\.PublicationSectionUpdateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);