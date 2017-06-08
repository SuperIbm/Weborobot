Ext.define('Publication.controller.PublicationSection', 
	{
	extend: 'Ext.app.Controller',
	
	id: "PublicationSection",
	
	views: ["PublicationSectionTree"],
	models: ["PublicationSection"],
	stores: ["PublicationSection"],
	
	WindowCreate: null,
	WindowUpdate: null,
	
	idOld: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("publicationSectionCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("publicationSectionUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"publicationSectionCreate":
			{
				before: function(action)
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
				action: function()
				{
					if(Admin.getApplication().Access.is("Publication", "isCreate")) this.create();
				}
			},
			"publicationSectionUpdate/:id":
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
					if(Admin.getApplication().Access.is("Publication", "isUpdate")) this.update(id);
				}
			},
			"publicationSectionSelect/:id":
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
					if(this.idOld != id)
					{
					this.idOld = id;
					this.select(id);
					}
				}
			}
		},
		
		refs: 
		{
		tree: "Publication\\.view\\.PublicationSectionTree[name='Publication']",
		grid: "Publication\\.view\\.PublicationGrid[name='Publication']"
		},
	
		control:
		{
			"Publication\\.view\\.PublicationSectionTree[name='Publication'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationSectionCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"Publication\\.view\\.PublicationSectionTree[name='Publication'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationSectionUpdate",
							value: this.getTree().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Publication\\.view\\.PublicationSectionTree[name='Publication'] button[action=destroy]":
			{
				click: function(button)
				{
				var SelModel = button.up("treepanel").getSelectionModel();
				
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
									button.up("treepanel").mask("Загрузка...");									
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
														button.up("treepanel").unmask();
														
															button.up("treepanel").fireEventArgs("afterDelete", 
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
														button.up("treepanel").unmask();
														
															button.up("treepanel").fireEventArgs("afterDelete", 
																[
																button.up("treepanel"),
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
			"Publication\\.view\\.PublicationSectionTree[name='Publication'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("treepanel").getStore().load();
				}	
			},
			"Publication\\.view\\.PublicationSectionTree[name='Publication']":
			{
				beforeselect: function(modelSel, record, index, eOpts)
				{								
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "publicationSectionSelect",
							value: record.getId()
							}
						]
					);
					
				this.redirectTo(token);
				},
				afterDelete: function(tree, ids)
				{
				tree.getSelectionModel().select(tree.getRootNode());
				this.getStore('PublicationComment').load();
				}
			}
		},
		
		select: function(id)
		{
		var record = this.getTree().getStore().getById(id);
		
			if(record)
			{
			this.getGrid().getStore().getProxy().setExtraParam("idPublicationSection", id);
			this.getGrid().getStore().loadPage(1);
			
			this.getTree().getSelectionModel().select(record, null, true);
			
			this.getGrid().setTitle("Публикации: " + record.getData().labelSection);
			
				if(this.getTree().getButtonCreate())
				{
				this.getTree().getButtonCreate().setDisabled(false);	
				this.getTree().getMenuItemCreate().setDisabled(false);
				}
			
				if(id != 0)
				{
					if(this.getGrid().getButtonCreate())
					{
					this.getGrid().getButtonCreate().setDisabled(false);	
					this.getGrid().getMenuItemCreate().setDisabled(false);
					}
			
					if(this.getTree().getButtonUpdate())
					{
					this.getTree().getButtonUpdate().setDisabled(false);	
					this.getTree().getMenuItemUpdate().setDisabled(false);
					}
			
					if(this.getTree().getButtonDestroy())
					{
					this.getTree().getButtonDestroy().setDisabled(false);	
					this.getTree().getMenuItemDestroy().setDisabled(false);
					}
				}
				else
				{
					if(this.getGrid().getButtonCreate())
					{
					this.getGrid().getButtonCreate().setDisabled(true);	
					this.getGrid().getMenuItemCreate().setDisabled(true);
					}
			
					if(this.getTree().getButtonUpdate())
					{
					this.getTree().getButtonUpdate().setDisabled(true);	
					this.getTree().getMenuItemUpdate().setDisabled(true);
					}
			
					if(this.getTree().getButtonDestroy())
					{
					this.getTree().getButtonDestroy().setDisabled(true);	
					this.getTree().getMenuItemDestroy().setDisabled(true);
					}
				}
			}
			else
			{
			this.getGrid().setTitle("Публикации");
			
				if(this.getGrid().getButtonCreate())
				{
				this.getGrid().getButtonCreate().setDisabled(true);	
				this.getGrid().getMenuItemCreate().setDisabled(true);
				}
			}
		},
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			thisObj.getApplication().createController("PublicationSectionCreate");
						
				this.WindowCreate = Ext.create("Publication.view.PublicationSectionCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"publicationSectionCreate"
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			
			this.WindowCreate.down("form").getForm().id = this.getTree().getSelection()[0].getId();
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
				thisObj.getApplication().createController("PublicationSectionUpdate");
				
				var rec = record;
							
					thisObj.WindowUpdate = Ext.create("Publication.view.PublicationSectionUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"publicationSectionUpdate"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getTree().getSelectionModel().select(record);							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelSection"));
				
					thisObj.WindowUpdate.down("form").on("actionForm",
						function(form, action)
						{
						var record = thisObj.getTree().getStore().getById(rec.getId());									
						
							if(record) thisObj.getTree().getSelectionModel().select(record);	
						}
					);
				}
			
			var record = this.getTree().getStore().getById(id);
			
				if(record) show(record);
				else this.WindowUpdate = null;
			}	
		}
	}
);