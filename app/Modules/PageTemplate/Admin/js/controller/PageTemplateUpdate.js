Ext.define('PageTemplate.controller.PageTemplateUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PageTemplateUpdate",
	
	views: ["PageTemplateUpdateWindow"],
	stores: ['PageTemplate'],
	
		control:
		{			
			"PageTemplate\\.view\\.PageTemplateUpdateWindow[name='PageTemplate'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{	
					var thisObj = this;
									
					button.up("window").mask("Загрузка...");
					var PageTemplate = Ext.create(this.getModel("PageTemplate"));																
						
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: PageTemplate.getProxy().getApi()["update"],
								params: 
								{
								idPageTemplate: button.up("window").down("form").getRecord().getId()
								},
								success: function(form, action)
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
									
								thisObj.getStore("PageTemplate").load();
								
									button.up("window").down("form").fireEventArgs("actionForm", 
										[
										button.up("window").down("form"),
										"update"
										]
									);
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
			"PageTemplate\\.view\\.PageTemplateUpdateWindow[name='PageTemplate'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"PageTemplate\\.view\\.PageTemplateUpdateWindow[name='PageTemplate'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);