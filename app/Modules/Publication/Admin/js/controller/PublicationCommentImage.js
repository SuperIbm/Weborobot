Ext.define('Publication.controller.PublicationCommentImage',
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationCommentImage",
	
	views: ["PublicationCommentUpdateImagePanel"],
	stores: ['Publication', 'PublicationCommentImage'],
	models: ["PublicationCommentImage"],
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
			"publicationCommentUpdateImage/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("PublicationComment").isLoaded() == false)
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
		image: "Publication\\.view\\.PublicationCommentUpdateWindow[name='Publication'] Publication\\.view\\.PublicationCommentUpdateImagePanel[name='Publication']"
		},
	
		control:
		{
			"Publication\\.view\\.PublicationCommentUpdateImagePanel[name='Publication'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationCommentUpdateImage",
							value: button.up("window").down("form").getForm().getRecord().getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationCommentUpdateImagePanel[name='Publication'] button[action=destroy]":
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
								
								var PublicationCommentImage = Ext.create(thisObj.getModel("PublicationCommentImage"));
								
									Ext.Ajax.request
									(
										{
										url: PublicationCommentImage.getProxy().getApi()["destroy"],
										method: "POST",
											params:
											{
											idPublicationComment: button.up("window").down("form").getForm().getRecord().getId()
											},
											success: function(response, options)
											{
											var result = Ext.JSON.decode(response.responseText);
											
												if(result["success"] == true)
												{						
												button.up("imagePanel").unmask();
												button.up("imagePanel").cleanImage();
												thisObj.getStore("PublicationComment").load();
												thisObj.getStore("PublicationCommentTree").load();
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
				thisObj.getApplication().createController("PublicationCommentImageCreate");
				
					thisObj.WindowUpdate = Ext.create("Publication.view.PublicationCommentImageCreateWindow",
						{
							listeners:
							{
								close: function()
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"publicationCommentUpdateImage"
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
				
			var record = this.getStore("PublicationComment").getById(id);
		
				if(record) show(record);
				else
				{
				this.getStore("PublicationComment").getProxy().setExtraParam("id", id);
				
					this.getStore("PublicationComment").load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.getStore("PublicationComment").getProxy().setExtraParam("id", null);
								thisObj.getStore("PublicationComment").load();
								
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