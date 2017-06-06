Ext.define('Publication.controller.PublicationCommentUpdate',
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationCommentUpdate",
	
	views: ["PublicationCommentUpdateWindow"],
	stores: ["PublicationCommentTree"],
	
		control:
		{			
			"Publication\\.view\\.PublicationCommentUpdateWindow[name='Publication'] button[action=send]":
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
							url: PublicationComment.getProxy().getApi()["update"],
								params:
								{
								idPublicationComment: button.up("window").down("form").getRecord().getId()
								},
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
			"Publication\\.view\\.PublicationCommentUpdateWindow[name='Publication'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Publication\\.view\\.PublicationCommentUpdateWindow[name='Publication'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);