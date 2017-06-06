Ext.define('Publication.controller.PublicationComment',
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationComment",
	
	views: ["PublicationCommentUpdateTree", "PublicationCommentGrid"],
	models: ["PublicationComment", "PublicationCommentTree", "PublicationCommentImage"],
	stores: ["PublicationComment", "PublicationCommentTree", "PublicationCommentImage"],
	
	WindowCreate: null,
	WindowUpdate: null,
	
	idOld: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("publicationCommentCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("publicationCommentUpdate") && this.WindowUpdate) this.WindowUpdate.close();
				}	
			},
			"publicationCommentCreate/:id/:idPublication":
			{
				before: function(id, idPublication, action)
				{
					if(this.getStore("PublicationComment").isLoaded() == false)
					{					
						this.getStore("PublicationComment").on("load",
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
				action: function(id, idPublication)
				{
					if(Admin.getApplication().Access.is("Publication", "isCreate")) this.create(id, idPublication);
				}
			},
			"publicationCommentUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("PublicationComment").isLoaded() == false)
					{
						this.getStore("PublicationComment").on("load",
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
					if(Admin.getApplication().Access.is("Publication", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		tree: "Publication\\.view\\.PublicationCommentUpdateTree[name='PublicationComment']",
		grid: "Publication\\.view\\.PublicationGrid[name='Publication']",
		gridComment: "Publication\\.view\\.PublicationCommentGrid[name='PublicationComment']"
		},
	
		control:
		{
			"Publication\\.view\\.PublicationCommentUpdateTree[name='PublicationComment'] button[action=create]":
			{
				click: function(button)
				{
				var Component = button.up("panel").up("panel").down("component[name='PublicationComment']");

					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationCommentCreate",
								value:
								[
								Component.getSelection()[0].getId(),
								this.getGrid().getSelection()[0].getId()
								]
							}
						]
					);

				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationCommentUpdateTree[name='PublicationComment'] button[action=update], Publication\\.view\\.PublicationCommentGrid[name='PublicationComment'] button[action=update]":
			{
				click: function(button)
				{
				var Component = button.up("panel").up("panel").down("component[name='PublicationComment']");

					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationCommentUpdate",
							value: Component.getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationCommentUpdateTree[name='PublicationComment'] button[action=destroy], Publication\\.view\\.PublicationCommentGrid[name='PublicationComment'] button[action=destroy]":
			{
				click: function(button)
				{
				var Component = button.up("panel").up("panel").down("component[name='PublicationComment']");
				var SelModel = Component.getSelectionModel();
				
					if(SelModel.hasSelection())
					{
						Ext.Msg.show
						(
							{
							title: "Удалить записи?",
							buttons: Ext.MessageBox.YESNO,
							icon: Ext.MessageBox.QUESTION,
							msg: "Вы точно уверены, что хотите удалить эти записи?",
							
								fn: function(btn)
								{										
									if(btn == "yes")
									{
									Component.mask("Загрузка...");
									var selections = SelModel.getSelection();
									var ids = new Array();
									
										for(var i = 0; i < selections.length; i++)
										{													
											selections[i].erase
											(
												{
													success: function(record, operation)
													{
													ids[i] = record.getId();
													
														if(i == selections.length)
														{
														Component.unmask();

															Component.fireEventArgs("afterDelete",
																[
																button.up("treepanel"),
																ids,
																true
																]
															);
														}
													},
													failure: function(record, operation)
													{
													ids[i] = record.getId();
													
														if(i == selections.length)
														{
														Component.unmask();

															Component.fireEventArgs("afterDelete",
																[
																Component,
																ids,
																false
																]
															);
														}
																												
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
							}
						);
					}
				}
			},
			"Publication\\.view\\.PublicationCommentUpdateTree[name='PublicationComment'], , Publication\\.view\\.PublicationCommentGrid[name='PublicationComment']":
			{
				afterDelete: function(Component, ids, success)
				{
					if(success == true)
					{
					this.getStore("Publication").load();
					}
				}
			}
		},
		
		create: function(idPublicationComment_referen, idPublication)
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			thisObj.getApplication().createController("PublicationCommentCreate");
						
				this.WindowCreate = Ext.create("Publication.view.PublicationCommentCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"publicationCommentCreate"
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			
			this.WindowCreate.down("form").getForm().idPublicationComment_referen = idPublicationComment_referen;
			this.WindowCreate.down("form").getForm().idPublication = idPublication;
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;

				function show(record)
				{
				thisObj.getApplication().createController("PublicationCommentUpdate");
				thisObj.getApplication().createController("PublicationCommentImage");
				
				var rec = record;
							
					thisObj.WindowUpdate = Ext.create("Publication.view.PublicationCommentUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"publicationCommentUpdate"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();

				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("name"));
				thisObj.WindowUpdate.down("imagePanel").setImageByArray(record.get("idImageMiddle"));
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