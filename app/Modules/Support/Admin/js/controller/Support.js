Ext.define('Support.controller.Support', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Support",
	
	stores: ['Support'],
	
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("uploadUpdate") && this.WindowUpdate)
					{
					this.WindowUpdate.close();	
					}
				}	
			},
			"uploadUpdate":
			{
				before: function(action)
				{				
					if(this.getStore("Support").isLoaded() == false)
					{
						this.getStore("Support").on("load",
							function()
							{
							action.resume();	
							},
							null,
							{
							single: true	
							}
						);
					}
					else action.resume();
				},
				action: function()
				{
					if(Admin.getApplication().Access.is("Support", "isUpdate")) this.show();
				}
			}
		},
		
		control:
		{
			"Support\\.view\\.Panel button[action=send]":
			{
				click: function(button)
				{
					if(button.up("panel").down("form").isValid() == true)
					{					
					button.up("panel").mask("Загрузка...");
						
						button.up("panel").down("form").submit
						(
							{
							clientValidation: true,
							url: '_api/Support/SupportAdminController/send/',
								success: function(form, action)
								{
								button.up("panel").unmask();
									
									Ext.Msg.show
									(
										{
										title: "Письмо отправлено",
										msg: "Ваше письмо было отправлено администратору сайта, в ближайшее время он вас проконсультирует по возникшему вопросу!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
								
								button.up("panel").down("form").reset();
								},
								failure: function(form, action)
								{
								button.up("panel").unmask();
									
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
			"Support\\.view\\.Panel button[action=reset]":
			{
				click: function(button)
				{
				button.up("panel").down("form").reset();
				}
			},
			"Support\\.view\\.Panel tool[itemId='SupportUser']":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "uploadUpdate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			}
		},
		
		show: function()
		{
		var thisObj = this;
		
			if(!this.WindowUpdate)
			{
			thisObj.getApplication().createController("SupportUpdate");
			
			var record = this.getStore("Support").getById(1);
			
				this.WindowUpdate = Ext.create("Support.view.SupportUpdateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowUpdate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"uploadUpdate"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
				
			this.WindowUpdate.down("form").loadRecord(record);
			}
		}
	}
);