Ext.define('AdminSection.controller.AdminSection', 
	{
	extend: 'Ext.app.Controller',
	
	id: "AdminSection",
	
	views: ["AdminSectionTab"],
	models: ["AdminSection"],
	stores: ['AdminSection'],
	
	WindowUpdate: null,
	
		routes:
		{
			"!":
			{
				action: function()
				{				
					if(!Ext.util.History.hasToken("adminSectionUpdate") && this.WindowUpdate) this.WindowUpdate.close();	
				}	
			},
			"adminSectionTab/:id":
			{
				before: function(id, action)
				{
					if(this.getStore("AdminSection").isLoaded() == false)
					{
						this.getStore("AdminSection").on("load",
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
				this.getTab().setActiveTab(id);
				}
			},
			"adminSectionUpdate/:id":
			{
				before: function(id, action)
				{
					if(this.getStore("AdminSection").isLoaded() == false)
					{
						this.getStore("AdminSection").on("load",
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
					if(Admin.getApplication().Access.is("AdminSection", "isUpdate")) this.update(id);
				}
			}
		},
		
		refs: 
		{
		tab: "AdminSection\\.view\\.AdminSectionTab[name='AdminSection']"
		},
	
		control:
		{
			"AdminSection\\.view\\.AdminSectionTab[name='AdminSection']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "adminSectionTab",
							value: newCard.itemId
							}
						]
					);
				
				this.redirectTo(token);
				}
			},
			"AdminSection\\.view\\.AdminSectionGrid[name='AdminSection'] button[action=update]":
			{
				click: function(button)
				{				
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "adminSectionUpdate",
							value: button.up("gridpanel").getSelection()[0].getId()
							}
						]
					);
					
				this.redirectTo(token);
				}
			},
			"AdminSection\\.view\\.Panel tool[itemId='refresh']":
			{
				click: function(button)
				{
				var bundles = Admin.getApplication().Section.getBandles();
				
					for(var i = 0; i < bundles.length; i++)
					{
					button.up("panel").down("gridpanel[bundleShow='" + bundles[i]["name"] + "']").getStore().getProxy().setExtraParam("bundleShow", bundles[i]["name"]);
					button.up("panel").down("gridpanel[bundleShow='" + bundles[i]["name"] + "']").getStore().load();	
					}
				}	
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
				thisObj.getApplication().createController("AdminSectionUpdate");
				
					thisObj.WindowUpdate = Ext.create("AdminSection.view.AdminSectionUpdateWindow",
						{
							listeners:
							{
								close: function(win)
								{
								thisObj.WindowUpdate = null;
									
									var token = Ext.util.History.deleteToken
									(
										[
										"adminSectionUpdate"	
										]
									);
									
								thisObj.redirectTo(token);	
								}
							}
						}
					).show().center();
							
				thisObj.WindowUpdate.down("form").getForm().loadRecord(record);
				thisObj.WindowUpdate.setTitle(thisObj.WindowUpdate.getTitle() + ": " + record.get("labelSection"));
				}
			
			var bundleShow = this.getStore("AdminSection").getProxy().getExtraParams()["bundleShow"];
			this.getStore("AdminSection").getProxy().setExtraParam("bundleShow", null);
			this.getStore("AdminSection").getProxy().setExtraParam("id", id);
				
				this.getStore("AdminSection").load
				(
					{
						callback: function(records, operation, success)
						{
							if(success == true)
							{
							thisObj.getStore("AdminSection").getProxy().setExtraParam("bundleShow", bundleShow);
							thisObj.getStore("AdminSection").getProxy().setExtraParam("id", null);
							thisObj.getStore("AdminSection").load();
							
							show(records[0]);
							}
							else thisObj.WindowUpdate = null;
						}
					}
				);
			}	
		}
	}
);