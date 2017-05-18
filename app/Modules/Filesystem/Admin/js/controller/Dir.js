Ext.define('Filesystem.controller.Dir', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Dir",
	
	views: ["FilesystemDirTree"],
	models: ["Dir"],
	stores: ["Dir"],
	
	idOld: null,
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				before: function(action)
				{								
					if(this.getStore("Dir").isLoaded() == false)
					{					
						this.getStore("Dir").on("load",
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
					if(!Ext.util.History.hasToken("dirCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("dirUpdate") && this.WindowUpdate) this.WindowUpdate.close();
				}	
			},
			"dirSelect/:id":
			{
				before: function(id, action)
				{								
					if(this.getStore("Dir").isLoaded() == false)
					{					
						this.getStore("Dir").on("load",
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
				},
				conditions: 
				{
				":id": '([/\\\\%а-яА-Яa-zA-Z0-9\\-\\_\\s,\. ]+)'
				}
			},
			"dirCreate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Dir").isLoaded() == false)
					{
						this.getStore("Dir").on("load",
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
					if(Admin.getApplication().Access.is("Filesystem", "isCreate")) this.create(id);
				},
				conditions: 
				{
				":id": '([/\\\\%а-яА-Яa-zA-Z0-9\\-\\_\\s,\. ]+)'
				}
			},
			"dirUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Dir").isLoaded() == false)
					{
						this.getStore("Dir").on("load",
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
					if(Admin.getApplication().Access.is("Filesystem", "isUpdate")) this.update(id);
				},
				conditions: 
				{
				":id": '([/\\\\%а-яА-Яa-zA-Z0-9\\-\\_\\s,\. ]+)'
				}
			}
		},
		
		refs: 
		{
		tree: "Filesystem\\.view\\.FilesystemDirTree[name='Filesystem']",
		grid: "Filesystem\\.view\\.FilesystemFileGrid[name='Filesystem']"
		},
	
		control:
		{
			"Filesystem\\.view\\.FilesystemDirTree[name='Filesystem']":
			{
				beforeselect: function(modelSel, record, index, eOpts)
				{
				var id = record.getId();
				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "dirSelect",
							value: id
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Filesystem\\.view\\.FilesystemDirTree[name='Filesystem'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("treepanel").getStore().load();
				}	
			},
			"Filesystem\\.view\\.FilesystemDirTree[name='Filesystem'] tool[itemId='collapse']":
			{
				click: function(button)
				{
				var Treepanel = button.up("panel").up("panel").down("treepanel");
				var childNodes = Treepanel.getRootNode().childNodes[0].childNodes;
				
					for(var i = 0; i < childNodes.length; i++)
					{
					Treepanel.collapseNode(childNodes[i]);
					}
				}	
			},
			"Filesystem\\.view\\.FilesystemDirTree[name='Filesystem'] button[action=create]":
			{
				click: function(button)
				{
				var id = button.up("treepanel").getSelection()[0].getId();
				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "dirCreate",
							value: id
							}
						]
					);
					
				this.redirectTo(token);
				}
			},			
			"Filesystem\\.view\\.FilesystemDirTree[name='Filesystem'] button[action=update]":
			{
				click: function(button)
				{
				var id = button.up("treepanel").getSelection()[0].getId();
				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "dirUpdate",
							value: id
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"Filesystem\\.view\\.FilesystemDirTree[name='Filesystem'] button[action=destroy]":
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
							msg: "Вы точно уверены, что хотите удалить эти папки?",
							
								fn: function(btn)
								{										
									if(btn == "yes")
									{											
									button.up("treepanel").mask("Загрузка...");									
									var selections = SelModel.getSelection();
									
										function erase(i)
										{
										var index = i;
										var parentNode = selections[index].parentNode;
										
											selections[index].erase
											(
												{
													success: function(record, operation)
													{													
														if(parentNode) if(parentNode.isRoot() == false) SelModel.select(parentNode);
													},
													failure: function(record, operation)
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
									
										for(var i = 0; i < selections.length; i++)
										{													
										erase(i);	
										}
										
									button.up("treepanel").unmask();		
									}
								}
							}
						);
					}
				}
			}
		},
		
		select: function(id)
		{	
		var thisObj = this;
				
		this.getGrid().getStore().getProxy().setExtraParam("path", id);
		this.getGrid().getStore().load();
		
			if(id)
			{			
				function afterExpand(node)
				{
				thisObj.getTree().getSelectionModel().select(node, null, true);
							
				thisObj.getGrid().setTitle("Файлы папки: " + node.getData().path);
				
					if(thisObj.getGrid().getButtonCreate())
					{
					thisObj.getGrid().getButtonCreate().setDisabled(false);	
					thisObj.getGrid().getMenuItemCreate().setDisabled(false);
					}
				
					if(thisObj.getTree().getButtonCreate())
					{
					thisObj.getTree().getButtonCreate().setDisabled(false);	
					thisObj.getTree().getMenuItemCreate().setDisabled(false);
					}
				
					if(node.get("path") == "/")
					{
						if(thisObj.getTree().getButtonUpdate())
						{
						thisObj.getTree().getButtonUpdate().setDisabled(true);	
						thisObj.getTree().getMenuItemUpdate().setDisabled(true);
						}
				
						if(thisObj.getTree().getButtonDestroy())

						{
						thisObj.getTree().getButtonDestroy().setDisabled(true);	
						thisObj.getTree().getMenuItemDestroy().setDisabled(true);
						}
					}
					else
					{					
						if(thisObj.getTree().getButtonUpdate())
						{
						thisObj.getTree().getButtonUpdate().setDisabled(false);	
						thisObj.getTree().getMenuItemUpdate().setDisabled(false);
						}
				
						if(thisObj.getTree().getButtonDestroy())
						{
						thisObj.getTree().getButtonDestroy().setDisabled(false);	
						thisObj.getTree().getMenuItemDestroy().setDisabled(false);
						}
					}
				
					if(Ext.util.History.hasToken("dirCreate"))
					{
					thisObj.create(Ext.util.History.getTokenValue("dirCreate", 0));	
					}
					
					if(Ext.util.History.hasToken("dirUpdate"))
					{
					thisObj.update(Ext.util.History.getTokenValue("dirUpdate", 0));	
					}
				}
				
				function expand(currentIndex, dirsName, nodeParent)
				{
				thisObj.getTree().mask("Загрузка...");
				
				var pathCurrent = "";
				
					for(var i = 0; i < currentIndex; i++)
					{
						if(dirsName[i] == "") continue;
						
					pathCurrent += dirsName[i] + "/";	
					}

					if(pathCurrent == "") pathCurrent = "/";

				var node = thisObj.getTree().getStore().findNode("path", pathCurrent);
					
					if(node)
					{
						node.expand(null, 
							function()
							{						
								if(currentIndex != (dirsName.length - 1)) expand(currentIndex + 1, dirsName, node);	
								else
								{
								afterExpand(node);
								thisObj.getTree().unmask();
								}
							}
						);
					}
					else
					{
					thisObj.getTree().unmask();

                        if(nodeParent) thisObj.getTree().getSelectionModel().select(nodeParent);
					}
				}

			var node = this.getTree().getStore().getById(id);
			
				if(node) afterExpand(node);
				else expand(1, id.split("/"));
			}
			else
			{
			this.getGrid().setTitle("Файлы папки");
			
				if(this.getGrid().getButtonCreate())
				{
				this.getGrid().getButtonCreate().setDisabled(true);	
				this.getGrid().getMenuItemCreate().setDisabled(true);
				}
			}
		},
		create: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;

				function show(record)
				{
				thisObj.getApplication().createController("DirCreate");

					thisObj.WindowCreate = Ext.create("Filesystem.view.FilesystemDirCreateWindow",
						{
							listeners:
							{
								close: function()
								{
								thisObj.WindowCreate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"dirCreate"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.WindowCreate.setTitle(thisObj.WindowCreate.getTitle() + ": к " + record.getId());
				thisObj.WindowCreate.down("form").getForm().id = record.getId();
				}

			var record = this.getTree().getStore().getById(id);
						
				if(record) show(record);
				else thisObj.WindowCreate = null;
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
				thisObj.getApplication().createController("DirUpdate");
				
					thisObj.WindowUpdate = Ext.create("Filesystem.view.FilesystemDirUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"dirUpdate"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.getId());
				thisObj.WindowUpdate.down("form").getForm().id = record.getId();
				}

			var record = this.getTree().getStore().getById(id);
			
				if(record) show(record);
				else this.WindowUpdate = null;
			}	
		}

	}
);