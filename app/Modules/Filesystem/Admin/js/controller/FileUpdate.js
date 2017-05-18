Ext.define('Filesystem.controller.FileUpdate', 
	{
	extend: 'Ext.app.Controller',
	
	id: "FileUpdate",
	
	views: ["FilesystemFileUpdateWindow"],
	stores: ["File"],
	
		routes:
		{
			"fileUpdateTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("File").isLoaded() == false)
					{
						this.getStore("File").on("load",
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
				action: function(id)
				{
					if(this.getTabUpdate()) this.getTabUpdate().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tabUpdate: "Filesystem\\.view\\.FilesystemFileUpdateWindow[name='Filesystem'] Filesystem\\.view\\.FilesystemFileUpdateTab[name='Filesystem']"
		},
	
		control:
		{			
			"Filesystem\\.view\\.FilesystemFileUpdateWindow[name='Filesystem'] Filesystem\\.view\\.FilesystemFileUpdateTab[name='Filesystem']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "fileUpdateTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Filesystem\\.view\\.FilesystemFileUpdateWindow[name='Filesystem'] button[action=send]":
			{
				click: function(button)
				{
					if(button.up("window").down("form").isValid() == true)
					{
					var thisObj = this;
					
					button.up("window").mask("Загрузка...");
					
					var data = button.up("window").down("form").getValues();
					data["path"] = button.up("window").down("form").getRecord().getId();
					
						if(button.up("window").down("textarea")) data["content"] = button.up("window").down("textarea").getValue();
					
					var File = Ext.create(this.getModel("File"), data);
					
						File.save
						(
							{
								success: function(model, operation)
								{
								button.up("window").unmask();
									
									Ext.Msg.show
									(
										{
										title: "Папка добавлена",
										msg: "Введенные вами данные были удачно изменены!",
										icon: Ext.MessageBox.INFO,
										buttons: Ext.MessageBox.OK
										}
									);
								
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
			"Filesystem\\.view\\.FilesystemFileUpdateWindow[name='Filesystem'] button[action=reset]":
			{
				click: function(button)
				{
				var form = button.up("window").down("form");
				form.loadRecord(form.getRecord());
				}
			},
			"Filesystem\\.view\\.FilesystemFileUpdateWindow[name='Filesystem'] button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);