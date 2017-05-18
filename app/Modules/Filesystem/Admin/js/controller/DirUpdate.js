Ext.define('Filesystem.controller.DirUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "DirUpdate",
	
	views: ["FilesystemDirUpdateWindow"],
	stores: ["Dir"],
	
		control:
		{			
			"Filesystem\\.view\\.FilesystemDirUpdateWindow[name='Filesystem'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["path"] = button.up("window").down("form").getRecord().getId();
					
					var Dir = Ext.create(this.getModel("Dir"), data);
					
						Dir.save
						(
							{							
								success: function(model, operation)
								{
								button.up("window").unmask();
									
									Ext.Msg.show
									(
										{
										title: "Папка добавлена",
										msg: "Указанная вами папка была удачно изменена!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
								
								var Node = thisObj.getStore("Dir").getNodeById(button.up("window").down("form").getForm().id);								
								
								var result = Ext.decode(operation.getResponse().responseText);
								Node.set("text", data["name"]);
								Node.set("name", data["name"]);
								Node.set("path", result.data.path);
								Node.commit();
								button.up("window").down("form").getForm().id = result.data.path;
								},
								failure: function(model, operation)
								{
								var result = Ext.decode(operation.getResponse().responseText);
								button.up("window").unmask();
								
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
			"Filesystem\\.view\\.FilesystemDirUpdateWindow[name='Filesystem'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Filesystem\\.view\\.FilesystemDirUpdateWindow[name='Filesystem'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);