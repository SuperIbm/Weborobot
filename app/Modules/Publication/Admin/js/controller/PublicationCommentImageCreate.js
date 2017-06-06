Ext.define('Publication.controller.PublicationCommentImageCreate',
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationCommentImageCreate",
	
	views: ["PublicationCommentImageCreateWindow"],
	stores: ["Publication"],
	
		control:
		{
			"Publication\\.view\\.PublicationCommentImageCreateWindow[name='Publication'] button[action=send]":
			{
				click: function(button)
				{				
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;			
					button.up("window").mask("Загрузка...");
					
					var PublicationCommentImage = Ext.create(this.getModel("PublicationCommentImage"));
						
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: PublicationCommentImage.getProxy().getApi()["create"],
								params: 
								{
								idPublicationComment: button.up("window").down("form").getForm().getRecord().getId()
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
								thisObj.getStore("PublicationComment").load();
								thisObj.getStore("PublicationCommentTree").load();
								
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
			"Publication\\.view\\.PublicationCommentImageCreateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.view\\.PublicationCommentImageCreateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);