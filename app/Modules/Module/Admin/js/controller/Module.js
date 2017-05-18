Ext.define('Module.controller.Module',
	{
	extend: 'Ext.app.Controller',
	
	id: "Module",
	
	views: ["ModuleGrid"],
	models: ["Module"],
	stores: ['Module'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("componentCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("componentUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"componentCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("Module", "isCreate")) this.create();
				}
			},
			"componentUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Module").isLoaded() == false)
					{
						this.getStore("Module").on("load",
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
					if(Admin.getApplication().Access.is("Module", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Module\\.view\\.ModuleGrid[name='Module']"
		},
	
		control:
		{
			"Module\\.view\\.ModuleGrid[name='Module'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "componentCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Module\\.view\\.ModuleGrid[name='Module'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "componentUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			}
		},
		
		create: function()
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;

			thisObj.getApplication().createController("ModuleCreate");
			
				this.WindowCreate = Ext.create("Module.view.ModuleCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"componentCreate"
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
				thisObj.getApplication().createController("ModuleUpdate");
				
					thisObj.WindowUpdate = Ext.create("Module.view.ModuleUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"componentUpdate"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelModule"));
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