Ext.define('Filesystem.controller.FileCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "FileCreate",
	
	views: ["FilesystemFileCreateWindow"],
	stores: ["File"],
	
		control:
		{			
			"Filesystem\\.view\\.FilesystemFileCreateWindow[name='Filesystem'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					button.up("window").mask("Загрузка...");
					
					var File = Ext.create(this.getModel("File"));	
						
						button.up("window").down("form").submit
						(
							{
							clientValidation: true,
							url: File.getProxy().getApi()["create"],
								params:
								{
								path: button.up("window").down("form").getForm().id	
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
								thisObj.getStore("File").load();	
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
			"Filesystem\\.view\\.FilesystemFileCreateWindow[name='Filesystem'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Filesystem\\.view\\.FilesystemFileCreateWindow[name='Filesystem'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);