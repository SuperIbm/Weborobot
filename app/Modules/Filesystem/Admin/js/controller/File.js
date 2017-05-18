Ext.define('Filesystem.controller.File', 
	{
	extend: 'Ext.app.Controller',
	
	id: "File",
	
	views: ["FilesystemFileGrid"],
	models: ["File"],
	stores: ["File"],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("fileCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("fileUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"fileCreate/:id":
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
					if(Admin.getApplication().Access.is("Filesystem", "isCreate")) this.create(id);
				},
				conditions: 
				{
				":id": '([/\\\\%а-яА-Яa-zA-Z0-9\\-\\_\\s,\. ]+)'
				}
			},
			"fileUpdate/:id":
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
			"Filesystem\\.view\\.FilesystemFileGrid[name='Filesystem'] tool[itemId='refresh']":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("gridpanel").getStore().load();
				}	
			},
			"Filesystem\\.view\\.FilesystemFileGrid[name='Filesystem']":
			{
				beforeitemdblclick: function(thisGrid, record, itemObj, index, e, eOpts)
				{				
					if(record.data.type == "dir")
					{
					var Treepanel = thisGrid.up("panel").up("panel").down("treepanel");
					var Node = Treepanel.getStore().getNodeById(record.data.path);
						
						if(Node)
						{
						Treepanel.getSelectionModel().select(Node);					
						Treepanel.expandNode(Node, false);
						
							Treepanel.fireEventArgs("beforeitemclick",
								[
								Treepanel,
								Node
								]
							);
						}
						else
						{
						var pathParent = record.data.path.substring(0, record.data.path.lastIndexOf("/", record.data.path.length - 2) + 1);
						var NodeParent = Treepanel.getStore().getNodeById(pathParent);
						
							thisGrid.up("panel").down("treepanel").expandNode(NodeParent, false, function()
								{
								var Node = Treepanel.getStore().getNodeById(record.data.path);
								Treepanel.getSelectionModel().select(Node);
						
									Treepanel.fireEventArgs("beforeitemclick",
										[
										Treepanel,
										Node
										]
									);	
								}
							);
						}
					
					return false;	
					}
					else return true;
				}	
			},
			"Filesystem\\.view\\.FilesystemFileGrid[name='Filesystem'] button[action=create]":
			{
				click: function(button)
				{
				var id;

					if(this.getTree().getSelection().length) id = this.getTree().getSelection()[0].getId();
					else id = "/";
				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "fileCreate",
							value: id
							}
						]
					);
					
				this.redirectTo(token);
				}
			},			
			"Filesystem\\.view\\.FilesystemFileGrid[name='Filesystem'] button[action=update]":
			{
				click: function(button)
				{
					if(button.up("gridpanel").getSelection()[0].data.type == "file")
					{
					var id = button.up("gridpanel").getSelection()[0].getId();
					
						var token = Ext.util.History.addToToken
						(
							[
								{
								index: "fileUpdate",
								value: id
								},
								{
								index: "fileUpdateTab",
								value: "tab_1"
								}
							]
						);
						
					this.redirectTo(token);
					}
					else
					{
					var TreeButtonUpdate = button.up("panel").up("panel").down("treepanel button[action=update]");
					var path = button.up("gridpanel").getSelection()[0].data.path;					
					var Treepanel = button.up("panel").up("panel").down("treepanel");
					var Node = Treepanel.getStore().getNodeById(path);
						
						if(Node)
						{
						Treepanel.getSelectionModel().select(Node);
						
							TreeButtonUpdate.fireEventArgs("click",
								[
								TreeButtonUpdate
								]
							);
						}
						else
						{
						var pathParent = path.substring(0, path.lastIndexOf("/", path.length - 2) + 1);
						var NodeParent = button.up("panel").up("panel").down("treepanel").getStore().getNodeById(pathParent);
						Treepanel = button.up("panel").up("panel").down("treepanel");
						
							Treepanel.expandNode(NodeParent, false, function()
								{
								var Node = Treepanel.getStore().getNodeById(path);
								Treepanel.getSelectionModel().select(Node);
						
									TreeButtonUpdate.fireEventArgs("click",
										[
										TreeButtonUpdate
										]
									);	
								}
							);
						}	
					}
				}
			},
			"Filesystem\\.view\\.FilesystemFileGrid[name='Filesystem'] button[action=destroy]":
			{
				click: function(button)
				{
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
											selections[i].erase
											(
												{
													success: function(record, operation)
													{
														if(i == selections.length) button.up("gridpanel").unmask();
													},
													failure: function(record, operation)
													{
														if(i == selections.length) button.up("gridpanel").unmask();
																												
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
			}
		},
		
		create: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
				function show(record)
				{
				thisObj.getApplication().createController("FileCreate");

                    thisObj.WindowCreate = Ext.create("Filesystem.view.FilesystemFileCreateWindow",
						{
							listeners:
							{
								close: function()
								{
								thisObj.WindowCreate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"fileCreate"	
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
			}	
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
				function show(record)
				{
				thisObj.getApplication().createController("FileUpdate");
				
					thisObj.WindowUpdate = Ext.create("Filesystem.view.FilesystemFileUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"fileUpdate",
										"fileUpdateTab"
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
				
				var extension = record.getData()["extension"];
					
					if(extension == "jpg" || extension == "jpng" || extension == "png"  || extension == "gif")
					{						
						thisObj.WindowUpdate.down("tabpanel").insert
						(
							{
							title: "Просмотр",
							layout: "fit",
							itemId: "tab_2",
								items:
								[
									{
									scrollable: true,
									html: "<div style='padding-top: 20px; text-align: center;'><img src='" + record.getData()["pathFull"] + "' style='max-width: 600px; height: auto' /></div>"
									}
								]
							}
						);
					}
					else if
					(
					extension == "php" || 
					extension == "tpl" || 
					extension == "htm" || 
					extension == "html" || 
					extension == "js" || 
					extension == "css" || 
					extension == "htaccess" || 
					extension == "htc" || 
					extension == "xml" || 
					extension == "sql" || 
					extension == "txt" || 
					extension == "tmp" || 
					extension == "htaccess"
					)
					{	
						switch(extension)
						{
						case "php": mode = "application/x-httpd-php"; break;
						case "tpl": mode = "htmlmixed"; break;	
						case "htm": mode = "htmlmixed"; break;	
						case "html": mode = "htmlmixed"; break;
						case "js": mode = "javascript"; break;	
						case "css": mode = "css"; break;
						case "htc": mode = "javascript"; break;
						case "xml": mode = "xml"; break;
						case "sql": mode = "sql"; break;	
						default: mode = "text";
						}
						
						thisObj.WindowUpdate.down("tabpanel").insert
						(
							{
							title: "Просмотр",
							layout: "fit",
							itemId: "tab_2",
								items:
								[
									{
									xtype: "codemirror",
									mode: mode,
									name: "content",
									hideLabel: true,
									height: 375,
									matchBrackets: true,
									value: record.getData()["content"]
									}
								]
							}
						);
					}
				}

			var record = this.getGrid().getStore().getById(id);
			
				if(record) show(record);
			}	
		}
	}
);