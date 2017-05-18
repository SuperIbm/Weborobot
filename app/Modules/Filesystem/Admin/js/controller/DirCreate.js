Ext.define('Filesystem.controller.DirCreate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "DirCreate",
	
	views: ["FilesystemDirCreateWindow"],
	stores: ["Dir", "File"],
	
		control:
		{			
			"Filesystem\\.view\\.FilesystemDirCreateWindow[name='Filesystem'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["name"] = button.up("window").down("form").getForm().id + data["name"];
					
					var Dir = Ext.create(this.getModel("Dir"), data);				
					Dir.setId(null);
					
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
										msg: "Указанная вами папка была удачно добавлена!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
									
								button.up("window").down("form").reset();

								var result = Ext.decode(operation.getResponse().responseText);
								var Node = thisObj.getStore("Dir").getNodeById(button.up("window").down("form").getForm().id);
								
									if(Node.isLoaded() == true)
									{
									var NodeNew = Node.createNode(result.data);
									NodeNew = Node.insertBefore(NodeNew);
									}
								
								thisObj.getStore("File").load();
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
			"Filesystem\\.view\\.FilesystemDirCreateWindow[name='Filesystem'] button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Filesystem\\.view\\.FilesystemDirCreateWindow[name='Filesystem'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);