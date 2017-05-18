Ext.define('Admin.controller.Enter', 
	{
	extend: 'Ext.app.Controller',
	views: ['EnterViewport'],
	models: ['EnterForm'],
	
		control:
		{
			"Admin\\.view\\.EnterWindow button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					button.up("window").mask("Загрузка...");
					var EnterForm = Ext.create(this.getModel("EnterForm"), button.up("window").down("form").getValues());
					
						EnterForm.save
						(
							{
								success: function(form, action)
								{										
								button.up("window").unmask();
								
								var result = Ext.util.JSON.decode(action.getResponse().responseText);
								Admin.getApplication().Access._setConfig(result["data"]);
								
								Admin.getApplication().Enter.getViewport().destroy();
								Admin.getApplication().App._setViewport(new Admin.view.AppViewport());
								
								Admin.getApplication().App.onReady();
								},
								failure: function(form, action, option)
								{										
								button.up("window").unmask();
								var result = Ext.util.JSON.decode(action.getResponse().responseText);
								
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
			"Admin\\.view\\.EnterWindow button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").getForm().reset();
				}
			}
		}
	}
);