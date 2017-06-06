Ext.define('Publication.controller.Publication', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Publication",
	
	views: ["PublicationGrid", "PublicationTab"],
	models: ["Publication"],
	stores: ['PublicationSection', 'Publication'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("publicationCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("publicationUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"publicationTab/:id":
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
					if(this.getTab()) this.getTab().setActiveTab(id);
				}
			},
			"publicationCreate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("PublicationSection").isLoaded() == false)
					{					
						this.getStore("PublicationSection").on("load",
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
					if(Admin.getApplication().Access.is("Publication", "isCreate")) this.create(id);
				}
			},
			"publicationUpdate/:id":
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
					if(Admin.getApplication().Access.is("Publication", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Publication\\.view\\.PublicationGrid[name='Publication']",
		tree: "Publication\\.view\\.PublicationSectionTree[name='Publication']",
		tab: "Publication\\.view\\.PublicationTab[name='Publication']"
		},
	
		control:
		{
			"Publication\\.view\\.PublicationTab[name='Publication']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationTab",
							value: newCard.itemId
							}
						]
					);

				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationGrid[name='Publication'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationCreate",
							value: this.getTree().getSelection()[0].getId()
							},
							{
							index: "publicationCreateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"Publication\\.view\\.PublicationGrid[name='Publication'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationUpdate",
							value: this.getGrid().getSelection()[0].getId()
							},
							{
							index: "publicationUpdateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"Publication\\.view\\.PublicationGrid[name='Publication'] button[action=destroy]":
			{
				click: function(button)
				{
				var thisObj = this;
				var SelModel = button.up("gridpanel").getSelectionModel();
				
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
									button.up("gridpanel").mask("Загрузка...");									
									var selections = SelModel.getSelection();

										for(var i = 0; i < selections.length; i++)
										{
										selections[i].count = i + 1;

											selections[i].erase
											(
												{
													success: function(record, operation)
													{
														if(record.count == selections.length)
														{
															button.up("gridpanel").unmask();
															thisObj.getStore("Publication").load();
														}

													},
													failure: function(record, operation)
													{
														if(record.count == selections.length) button.up("gridpanel").unmask();

														Ext.Msg.show
														(
															{
																title: thisObj.error,
																msg: thisObj.errorMsgServer,
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
			}
		},
		
		create: function(id)
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;
			thisObj.getApplication().createController("PublicationCreate");
			
				this.WindowCreate = Ext.create("Publication.view.PublicationCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"publicationCreate",
									"publicationCreateTab"
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			
			this.WindowCreate.setTitle(this.WindowCreate.getTitle() + ": к " + this.getTree().getSelection()[0].get("labelSection"));
			this.WindowCreate.down("form").getForm().id = id;
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
				thisObj.getApplication().createController("PublicationUpdate");
				thisObj.getApplication().createController("PublicationImage");
				
					thisObj.WindowUpdate = Ext.create("Publication.view.PublicationUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"publicationUpdate",
										"publicationUpdateTab"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
				
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.down("ckeditor").setValue(record.get("textOfArticle"));
				thisObj.WindowUpdate.down("imagePanel").setImageByArray(record.get("idImageMiddle"));

				thisObj.WindowUpdate.down("treepanel[name='PublicationComment']").getStore().getProxy().setExtraParam("idPublication", id);

					thisObj.WindowUpdate.down("treepanel[name='PublicationComment']").getStore().on("load",
						function()
						{
						thisObj.WindowUpdate.down("treepanel[name='PublicationComment']").getRootNode().expand(true);
						},
						null,
						{
						single: true
						}
					);

				thisObj.WindowUpdate.down("treepanel[name='PublicationComment']").getStore().load();

				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("title"));
				}
			
			var record = this.getGrid().getStore().getById(id);
			
				if(record) show(record);
				else
				{
				this.getGrid().getStore().getProxy().setExtraParam("id", id);
				
					this.getGrid().getStore().load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == true)
								{
								thisObj.getGrid().getStore().getProxy().setExtraParam("id", null);
								thisObj.getGrid().getStore().load();
								
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