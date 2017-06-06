Ext.define('Publication.controller.PublicationImageCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationImageCreate",
	
	views: ["PublicationImageCreateWindow"],
	stores: ["Publication"],
	
		control:
		{
			"Publication\\.view\\.PublicationImageCreateWindow[name='Publication'] button[action=send]":
			{
				click: function(button)
				{				
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;			
					button.up("window").mask("Загрузка...");
					
					var PublicationImage = Ext.create(this.getModel("PublicationImage"));				
						
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: PublicationImage.getProxy().getApi()["create"],
								params: 
								{
								idPublication: button.up("window").down("form").getForm().getRecord().getId()
								},
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
								thisObj.getStore("Publication").load();
								
									button.up("window").down("form").fireEventArgs("actionForm", 
										[
										button.up("window").down("form"),
										"set",
										action.result.data.idImageMiddle.idImage
										]
									);
								},
								failure: function(form, action)
								{
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
			"Publication\\.view\\.PublicationImageCreateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.view\\.PublicationImageCreateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);