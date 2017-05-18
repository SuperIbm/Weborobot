Ext.define('User.controller.UserAccountImage', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UserAccountImage",
	
	views: ["UserAccountUpdateImagePanel"],
	stores: ['UserAccount'],
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("userAccountUpdateImage") && this.WindowUpdate) this.WindowUpdate.close();
				}	
			},
			"userAccountUpdateImage/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserAccount").isLoaded() == false)
					{
						this.getStore("UserAccount").on("load",
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
					if(Admin.getApplication().Access.is("User", "isUpdate")) this.create(id);
				}
			}
		},
		
		refs: 
		{
		image: "User\\.view\\.UserAccountUpdateWindow[name='User'] User\\.view\\.UserAccountUpdateImagePanel[name='User']"
		},
	
		control:
		{
			"User\\.view\\.UserAccountUpdateImagePanel[name='User'] button[action=create]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userAccountUpdateImage",
							value: button.up("window").down("form[itemId='enter']").getForm().getRecord().getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"User\\.view\\.UserAccountUpdateImagePanel[name='User'] button[action=destroy]":
			{
				click: function(button)
				{
				var thisObj = this;
				
					Ext.Msg.show
					(
						{
						title: "Удаление изображение?",
						buttons: Ext.MessageBox.YESNO,
						icon: Ext.MessageBox.QUESTION,
						msg: "Вы точно уверены, что хотите удалить это изображение?",
						
							fn: function(btn)
							{										
								if(btn == "yes")
								{										
								button.up("imagePanel").mask("Загрузка...");
								
								var UserAccountImage = Ext.create(thisObj.getModel("UserAccountImage"));									
								
									Ext.Ajax.request
									(
										{
										url: UserAccountImage.getProxy().getApi()["destroy"],
										method: "POST",
											params:
											{
											idUser: button.up("window").down("form[itemId='enter']").getForm().getRecord().getId()
											},
											success: function(response, options)
											{
											var result = Ext.JSON.decode(response.responseText);
											
												if(result["success"] == true)
												{						
												button.up("imagePanel").unmask();
												button.up("imagePanel").cleanImage();
												thisObj.getStore('UserAccount').load();
												}
												else
												{
												button.up("imagePanel").unmask();
												
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
											},
											failure: function(response, options)
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
									);											
								}
							}
						}
					);					
				}
			}
		},
		
		create: function(id)
		{
		var thisObj = this;
		
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;

				function show(record)
				{
				thisObj.getApplication().createController("UserAccountImageCreate");
				
					thisObj.WindowUpdate = Ext.create("User.view.UserAccountImageCreateWindow",
						{
							listeners:
							{
								close: function()
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"userAccountUpdateImage"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
				
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);	
				
					thisObj.WindowUpdate.down("form").on("actionForm",
						function(form, actionType, idImage)
						{
						thisObj.getImage().setId(idImage).getStore().load();
						}
					);	
				}
			
			var record = this.getStore("UserAccount").getById(id);
		
				if(record) show(record);
				else
				{
				this.getStore("UserAccount").getProxy().setExtraParam("id", id);
				
					this.getStore("UserAccount").load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.getStore("UserAccount").getProxy().setExtraParam("id", null);
								thisObj.getStore("UserAccount").load();
								
								show(records[0]);
								}
								else thisObj.WindowUpdate = null;
							}
						}
					);
				}
			}
		}
	}
);