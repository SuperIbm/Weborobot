Ext.define('Widget.controller.Widget', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Widget",
	
	views: ["WidgetGrid"],
	models: ["Widget"],
	stores: ['Widget'],
	
	WindowCreate: null,
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{
					if(!Ext.util.History.hasToken("widgetCreate") && this.WindowCreate) this.WindowCreate.close();
					if(!Ext.util.History.hasToken("widgetUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"widgetCreate":
			{
				action: function()
				{
					if(Admin.getApplication().Access.is("Widget", "isCreate")) this.create();
				}
			},
			"widgetUpdate/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Widget").isLoaded() == false)
					{
						this.getStore("Widget").on("load",
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
					if(Admin.getApplication().Access.is("Widget", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		grid: "Widget\\.view\\.WidgetGrid[name='Widget']"
		},
	
		control:
		{
			"Widget\\.view\\.WidgetGrid[name='Widget'] button[action=create]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "widgetCreate"
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"Widget\\.view\\.WidgetGrid[name='Widget'] button[action=update]":
			{
				click: function(button)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "widgetUpdate",
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

				this.WindowCreate = Ext.create("Widget.view.WidgetCreateWindow",
					{
						listeners:
						{
							close: function()
							{
							thisObj.WindowCreate = null;
								
								var token = Ext.util.History.deleteToken
								(
									[
									"widgetCreate"
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
					thisObj.WindowUpdate = Ext.create("Widget.view.WidgetUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"widgetUpdate"
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
					
				thisObj.getGrid().getSelectionModel().select(record);
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelWidget"));
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