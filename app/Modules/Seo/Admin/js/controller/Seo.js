Ext.define('Seo.controller.Seo', 
	{
	extend: 'Ext.app.Controller',
	
	id: "Seo",
	
	views: ["SeoTab"],
	models: ["Seo"],
	stores: ['Seo'],
	
		routes:
		{
			"seoTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("Seo").isLoaded() == false)
					{
						this.getStore("Seo").on("load",
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
					if(this.getTab()) this.getTab().setActiveTab(id);
				}
			}
		},
		
		refs: 
		{
		tab: "Seo\\.view\\.Panel Seo\\.view\\.SeoTab[name='Seo']"
		},
	
		control:
		{
			"Seo\\.view\\.Panel Seo\\.view\\.SeoTab[name='Seo']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "seoTab",
							value: newCard.itemId
							}
						]
					);
							
				this.redirectTo(token);
				}
			},
			"Seo\\.view\\.Panel Seo\\.view\\.SeoChart button[action=download]":
			{
				click: function(button)
				{
				button.up("panel").up("panel").down("cartesian").download();
				}
			},
			"Seo\\.view\\.Panel datefield[reference='dateFrom'], Seo\\.view\\.Panel datefield[reference='dateTo'], Seo\\.view\\.Panel comboBoxExt[reference='detalization']":
			{
				change: function(input, newValue, oldValue, eOpts)
				{					
				input.up("panel").mask();

				var DateFrom = input.up("panel").down("datefield[reference='dateFrom']").getValue();
				var DateTo = input.up("panel").down("datefield[reference='dateTo']").getValue();

				this.getStore("Seo").getProxy().setExtraParam("date", null);
				this.getStore("Seo").getProxy().setExtraParam("dateFrom", Ext.Date.format(DateFrom, 'Y-m-d'));
				this.getStore("Seo").getProxy().setExtraParam("dateTo", Ext.Date.format(DateTo, 'Y-m-d'));
				this.getStore("Seo").getProxy().setExtraParam("detalization", input.up("panel").down("comboBoxExt[reference='detalization']").getValue());
					
					this.getStore("Seo").load
					(
						{
							callback: function(records, operation, success)
							{
								if(success == false)
								{
									Ext.Msg.show
									(
										{
										title: "Ошибка!",
										msg: "Произошла ошибка выполнения программы на сервере!",
										icon: Ext.MessageBox.WARNING,
										buttons: Ext.MessageBox.OK
										}
									);	
								}
								
							input.up("panel").unmask();
							}
						}
					);
				}
			},
			"Seo\\.view\\.Panel tool[itemId='refresh']":
			{
				click: function(button)
				{
				this.getStore("Seo").load();
				}
			}
		}
	}
);