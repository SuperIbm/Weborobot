Ext.define('Page.controller.Page', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Page",
	
	views: ["PageTree"],
	stores: ["Page", "PageTemplateSelect"],
	models: ["Page"],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("pageCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("pageUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"pageCreate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Page").isLoaded() == false)
					{
						this.getStore("Page").on("load",
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
					if(Admin.getApplication().Access.is("Page", "isCreate")) this.create(id);
				}
			},
			"pageUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Page").isLoaded() == false)
					{
						this.getStore("Page").on("load",
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
					if(Admin.getApplication().Access.is("Page", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		tree: "Page\\.view\\.PageTree[name='Page']"
		},
			
		control:
		{
			"Page\\.view\\.Panel tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("treepanel").getStore().load();
				}	
			},
			"Page\\.view\\.Panel tool[itemId='expand']":
			{
				click: function(button)
				{
				button.up("panel").down("treepanel").expandAll(true);
				}
			},
			"Page\\.view\\.Panel tool[itemId='collapse']":
			{
				click: function(button)
				{
				var childNodes = button.up("panel").down("treepanel").getRootNode().childNodes[0].childNodes;
				
					for(var i = 0; i < childNodes.length; i++)
					{
					button.up("panel").down("treepanel").collapseNode(childNodes[i]);
					}
				}
			},
			"Page\\.view\\.PageTree[name='Page'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "pageCreate",
							value: this.getTree().getSelection()[0].getId()
							},
							{
							index: "pageCreateTab",
							value: "tab_1"
							}
						]
					);
						
				this.redirectTo(token);
				}
			},
			"Page\\.view\\.PageTree[name='Page'] button[action=update]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "pageUpdate",
							value: this.getTree().getSelection()[0].getId()
							},
							{
							index: "pageUpdateTab",
							value: "tab_1"
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"Page\\.view\\.PageTree[name='Page'] button[action=destroy]":
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
									var ids = [];
									
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
			
			"Page\\.view\\.PageTree[name='Page']":
			{
				beforeedit: function(editor, context, eOpts)
				{
				var record = context.record;
				
					if(record.get("isMeetsEdit") == 0) return false;
					else return true;
				},
				itemclick: function(obj, record, item, index, e, eOpts)
				{
				record = this.getTree().getSelectionModel().getSelection();
					
					if(record)
					{					
						if(record.length == 1)
						{
						record = record[0];
						
							if(record.get("isMeetsEdit") == 0)
							{
								if(this.getTree().getButtonCreate())
								{
								this.getTree().getButtonCreate().setDisabled(true);	
								this.getTree().getMenuItemCreate().setDisabled(true);
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
							else
							{
								if(this.getTree().getButtonCreate())
								{
								this.getTree().getButtonCreate().setDisabled(false);	
								this.getTree().getMenuItemCreate().setDisabled(false);
								}
								
								if(this.getTree().getButtonUpdate())
								{
								this.getTree().getButtonUpdate().setDisabled(false);	
								this.getTree().getMenuItemUpdate().setDisabled(false);
								}
								
								if(record.get("isMeetsEdit") == 1)
								{
									if(this.getTree().getButtonDestroy())
									{					
									this.getTree().getButtonDestroy().setDisabled(false);	
									this.getTree().getMenuItemDestroy().setDisabled(false);
									}
								}
								else
								{
									if(this.getTree().getButtonDestroy())
									{					
									this.getTree().getButtonDestroy().setDisabled(true);	
									this.getTree().getMenuItemDestroy().setDisabled(true);
									}
								}
							}
						}
						else if(record.length > 1)
						{
						var disabled = false;
						
							for(var i = 0; i < record.length; i++)
							{
								if(record[i].get("isMeetsEdit") == 0)
								{
								disabled = true;
								break;	
								}
							}
							
							if(this.getTree().getButtonDestroy())
							{					
							this.getTree().getButtonDestroy().setDisabled(disabled);	
							this.getTree().getMenuItemDestroy().setDisabled(disabled);
							}
						}
					}
				}
			},
			
			"PageTemplate\\.view\\.PageTemplateCreateForm[name='PageTemplate']":
			{
				actionForm: function(form, type)
				{
				this.getStore("PageTemplateSelect").load();
				}
			},
			"PageTemplate\\.view\\.PageTemplateUpdateForm[name='PageTemplate']":
			{
				actionForm: function(form, type)
				{
				this.getStore("PageTemplateSelect").load();
				}
			}
		},
		
		create: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;
			var record = this.getTree().getStore().getById(id);
					
				if(record)
				{
					if(record.get("isMeetsEdit") != 0)
					{
						this.WindowCreate = Ext.create("Page.view.PageCreateWindow",
							{
								listeners:
								{
									close: function()
									{
									thisObj.WindowCreate = null;
									
										var token = Ext.util.History.deleteToken
										(
											[
											"pageCreate",
											"pageCreateTab"	
											]
										);
										
									thisObj.redirectTo(token);
									}
								}
							}
						).show().center();
						
					this.WindowCreate.setTitle(this.WindowCreate.getTitle() + ": к " + record.get("text"));
					this.WindowCreate.down("form").getForm().id = record.getId();
					}
					else this.WindowCreate = null;
				}
				else this.WindowCreate = null;
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;
			var record = this.getTree().getStore().getById(id);
				
				if(record)
				{
					if(record.get("isMeetsEdit") != 0)
					{
					var rec = record;
					
						this.WindowUpdate = Ext.create("Page.view.PageUpdateWindow",
							{
								listeners:
								{
									close: function()
									{
									thisObj.WindowUpdate = null;
									
										var token = Ext.util.History.deleteToken
										(
											[
											"pageUpdate",
											"pageUpdateTab"	
											]
										);
										
									thisObj.redirectTo(token);
									}
								}
							}
						).show().center();
					
					this.getTree().getSelectionModel().select(record);
					this.WindowUpdate.setTitle(this.WindowUpdate.getTitle() + ": " + record.get("namePage"));
					
						if(record.parentNode.isRoot() == true)
						{
							this.WindowUpdate.down("form").down("comboBoxExt[name='modeAccess']").setStore
							(
								new Ext.data.ArrayStore
								(
									{
										fields:
										[
										"name"
										],
										data:
										[
											[
											"Свободный"
											],
											[
											"Ограниченный"
											]
										]
									}
								)
							);
							
						this.WindowUpdate.down("form").down("textfield[name='nameLink']").setFieldLabel("Ссылка:");
						this.WindowUpdate.down("form").down("textfield[name='nameLink']").setDisabled(true);
						this.WindowUpdate.down("form").down("textfield[name='nameLink']").setHidden(true);
						this.WindowUpdate.down("form").isRoot = true;
						}
						else this.WindowUpdate.down("form").isRoot = false;
								
					this.WindowUpdate.down("form").getForm().loadRecord(record);
						
						if(record.get("modeAccessReal")) this.WindowUpdate.down("form combobox[name='modeAccess']").setValue(record.get("modeAccessReal"));
						else this.WindowUpdate.down("form combobox[name='modeAccess']").setValue(record.get("modeAccess"));
						
					this.WindowUpdate.down("ckeditor").setValue(record.get("html"));
					
					var StorePageTemplate = this.WindowUpdate.down("gridpanel").getStore();
						
						StorePageTemplate.on("load",
							function()
							{
							var recordCurrent = StorePageTemplate.getById(record.get("idPageTemplate"));
								
								if(recordCurrent)
								{
								thisObj.WindowUpdate.down("gridpanel").getSelectionModel().select(recordCurrent);	
								}
							},
							null,
							{
							single: true	
							}
						);			

					var StorePageUpdatePageComponentTree = thisObj.WindowUpdate.down("treepanel[name='PageUpdatePageComponentTree']").getStore();
					StorePageUpdatePageComponentTree.getProxy().setExtraParam("idPage", record.get("idPage"));

					    StorePageUpdatePageComponentTree.load
                        (
                            {
                                callback: function()
                                {
                                StorePageUpdatePageComponentTree.getRoot().expand();
                                }
                            }
                        );
					}
					else this.WindowUpdate = null;
				}
				else this.WindowUpdate = null;
			}
		}
	}
);