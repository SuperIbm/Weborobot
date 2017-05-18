Ext.define('Infoblock.controller.Infoblock', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Infoblock",
	
	views: ["InfoblockGrid"],
	models: ["Infoblock"],
	stores: ['Infoblock'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("infoblockCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("infoblockUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"infoblockCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("Infoblock", "isCreate")) this.create();
				}
			},
			"infoblockUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Infoblock").isLoaded() == false)
					{
						this.getStore("Infoblock").on("load",
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
					if(Admin.getApplication().Access.is("Infoblock", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Infoblock\\.view\\.InfoblockGrid[name='Infoblock']"
		},
	
		control:
		{
			"Infoblock\\.view\\.InfoblockGrid[name='Infoblock'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "infoblockCreate"
							},
							{
							index: "infoblockCreateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Infoblock\\.view\\.InfoblockGrid[name='Infoblock'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "infoblockUpdate",
							value: this.getGrid().getSelection()[0].getId()
							},
							{
							index: "infoblockUpdateTab",
							value: "tab_1"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Infoblock\\.view\\.InfoblockGrid[name='Infoblock'] button[action=destroy]":
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
							title: this.questionDestroyTitle,
							buttons: Ext.MessageBox.YESNO,
							icon: Ext.MessageBox.QUESTION,
							msg: this.questionDestroyMsg,
							
								fn: function(btn)
								{										
									if(btn == "yes")
									{											
									button.up("gridpanel").mask(thisObj.maskLoad);
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
															thisObj.getStore("Infoblock").load();
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
		
		create: function()
		{		
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;
			thisObj.getApplication().createController("InfoblockCreate");
					
				this.WindowCreate = Ext.create("Infoblock.view.InfoblockCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"infoblockCreate",
									"infoblockCreateTab"	
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
			this.WindowUpdate = true;

				function show(record)
				{
				thisObj.getApplication().createController("InfoblockUpdate");
				
					thisObj.WindowUpdate = Ext.create("Infoblock.view.InfoblockUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"infoblockUpdate",
										"infoblockUpdateTab"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.down("ckeditor").setValue(record.get("code"));
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelInfoblock"));
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