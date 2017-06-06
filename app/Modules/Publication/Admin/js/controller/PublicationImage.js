Ext.define('Publication.controller.PublicationImage', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationImage",
	
	views: ["PublicationUpdateImagePanel"],
	stores: ['Publication', 'PublicationImage'],
	models: ["PublicationImage"],
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("publicationUpdateImage") && this.WindowUpdate) this.WindowUpdate.close();
				}	
			},
			"publicationUpdateImage/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Publication").isLoaded() == false)
					{
						this.getStore("Publication").on("load",
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
					if(Admin.getApplication().Access.is("Publication", "isUpdate")) this.create(id);
				}
			}
		},
		
		refs: 
		{
		image: "Publication\\.view\\.PublicationUpdateWindow[name='Publication'] Publication\\.view\\.PublicationUpdateImagePanel[name='Publication']"
		},
	
		control:
		{
			"Publication\\.view\\.PublicationUpdateImagePanel[name='Publication'] button[action=create]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationUpdateImage",
							value: button.up("window").down("form").getForm().getRecord().getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationUpdateImagePanel[name='Publication'] button[action=destroy]":
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
								
								var PublicationImage = Ext.create(thisObj.getModel("PublicationImage"));									
								
									Ext.Ajax.request
									(
										{
										url: PublicationImage.getProxy().getApi()["destroy"],
										method: "POST",
											params:
											{
											idPublication: button.up("window").down("form").getForm().getRecord().getId()
											},
											success: function(response, options)
											{
											var result = Ext.JSON.decode(response.responseText);
											
												if(result["success"] == true)
												{						
												button.up("imagePanel").unmask();
												button.up("imagePanel").cleanImage();
												thisObj.getStore("Publication").load();
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
				thisObj.getApplication().createController("PublicationImageCreate");
				
					thisObj.WindowUpdate = Ext.create("Publication.view.PublicationImageCreateWindow",
						{
							listeners:
							{
								close: function()
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"publicationUpdateImage"
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
				
			var record = this.getStore("Publication").getById(id);
		
				if(record)show(record);
				else
				{
				this.getStore("Publication").getProxy().setExtraParam("id", id);
				
					this.getStore("Publication").load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.getStore("Publication").getProxy().setExtraParam("id", null);
								thisObj.getStore("Publication").load();
								
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