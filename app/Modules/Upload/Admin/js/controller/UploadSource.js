Ext.define('Upload.controller.UploadSource', 
	{
	extend: 'Ext.app.Controller',
	
	id: "UploadSource",
	
	views: ["UploadSourceWindow"],
	models: ["UploadSource"],
	stores: ['UploadSource'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("sourceUploadCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("sourceUploadUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"sourceUploadCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("Upload", "isCreate")) this.create();
				}
			},
			"sourceUploadUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UploadSource").isLoaded() == false)
					{
						this.getStore("UploadSource").on("load",
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
					if(Admin.getApplication().Access.is("Upload", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Upload\\.view\\.UploadSourceWindow[name='Upload'] Upload\\.view\\.UploadSourceGrid[name='Upload']"
		},
	
		control:
		{
			"Upload\\.view\\.UploadSourceGrid[name='Upload'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "sourceUploadCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Upload\\.view\\.UploadSourceGrid[name='Upload'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "sourceUploadUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Upload\\.view\\.UploadSourceGrid[name='Upload'] button[action=destroy]":
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
														thisObj.getStore("UploadSource").load();
														}
													},
													failure: function(record, operation)
													{
														if(record.count == selections.length) button.up("gridpanel").unmask();
																												
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
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			thisObj.getApplication().createController("UploadSourceCreate");
			
				this.WindowCreate = Ext.create("Upload.view.UploadSourceCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"sourceUploadCreate"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
				function show(record)
				{
				thisObj.getApplication().createController("UploadSourceUpdate");
				
					thisObj.WindowUpdate = Ext.create("Upload.view.UploadSourceUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"sourceUploadUpdate"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("login"));
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
							}
						}
					);	
				}
			}	
		}
	}
);