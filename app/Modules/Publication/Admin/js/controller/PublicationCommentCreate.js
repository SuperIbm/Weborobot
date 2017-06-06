Ext.define('Publication.controller.PublicationCommentCreate',
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationCommentCreate",
	
	views: ["PublicationCommentCreateWindow"],
	stores: ["PublicationCommentTree"],
	
		control:
		{			
			"Publication\\.view\\.PublicationCommentCreateWindow[name='Publication'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					var PublicationComment = Ext.create(this.getModel("PublicationComment"));

						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: PublicationComment.getProxy().getApi()["create"],
								params:
								{
								idPublication: button.up("window").down("form").getForm().idPublication,
								idPublicationComment_referen: button.up("window").down("form").getForm().idPublicationComment_referen
								},
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
								thisObj.getStore("Publication").load();
								thisObj.getStore("PublicationComment").load();
								thisObj.getStore("PublicationCommentTree").load();
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
			"Publication\\.view\\.PublicationCommentCreateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.view\\.PublicationCommentCreateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);