Ext.define('Publication.controller.PublicationSectionCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationSectionCreate",
	
	views: ["PublicationSectionCreateWindow"],
	stores: ["PublicationSection"],
	
		control:
		{			
			"Publication\\.view\\.PublicationSectionCreateWindow[name='Publication'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					
					var Publication = Ext.create(this.getModel("PublicationSection"), data);
					Publication.setId(null);
					
						Publication.save
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
			"Publication\\.view\\.PublicationSectionCreateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.view\\.PublicationSectionCreateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);