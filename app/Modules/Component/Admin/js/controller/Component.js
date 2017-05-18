Ext.define('Component.controller.Component',
	{
	extend: 'Ext.app.Controller',
	
	id: "Component",
	
	views: ["ComponentGrid"],
	models: ["Component"],
	stores: ['ModuleTree', 'Component'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("componentTemplateCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("componentTemplateUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"componentTemplateCreate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("ModuleTree").isLoaded() == false)
					{					
						this.getStore("ModuleTree").on("load",
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
					if(Admin.getApplication().Access.is("Component", "isCreate")) this.create(id);
				}
			},
			"componentTemplateUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Component").isLoaded() == false)
					{
						this.getStore("Component").on("load",
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
					if(Admin.getApplication().Access.is("Component", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Component\\.view\\.ComponentGrid[name='ModuleTree']",
		tree: "Component\\.view\\.ModuleTree[name='ModuleTree']"
		},
	
		control:
		{
			"Component\\.view\\.ComponentGrid[name='ModuleTree'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "componentTemplateCreate",
							value: this.getTree().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			
			"Component\\.view\\.ComponentGrid[name='ModuleTree'] button[action=update]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "componentTemplateUpdate",
							value: this.getGrid().getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			}
		},
		
		create: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowCreate)
			{
			this.WindowCreate = true;
            thisObj.getApplication().createController("ComponentCreate");

				this.WindowCreate = Ext.create("Component.view.ComponentCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"componentTemplateCreate",
									"componentTemplateCreateTab"	
									]
								);
								
							thisObj.redirectTo(token);	
							}
						}
					}
				).show().center();
				
			this.WindowCreate.setTitle(this.WindowCreate.getTitle() + ": к " + this.getTree().getSelection()[0].get("text"));
			this.WindowCreate.down("form").getForm().id = id;
			}
		},
		update: function(id)
		{
		var thisObj = this;
				
			if(!this.WindowUpdate)
			{
			this.WindowUpdate = true;
            thisObj.getApplication().createController("ComponentUpdate");

				function show(record)
				{
					thisObj.WindowUpdate = Ext.create("Component.view.ComponentUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"componentTemplateUpdate",
										"componentTemplateUpdateTab"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelComponent"));
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