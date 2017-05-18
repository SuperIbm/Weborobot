Ext.define('User.controller.User', 
	{
	extend: 'Ext.app.Controller',
	id: "User",
	
	views: ["UserTab"],
	stores: ['UserAccount'],
	
		routes:
		{
			"userTab/:id":
			{
				before: function(id, action)
				{				
					if(this.getStore("UserAccount").isLoaded() == false)
					{
						this.getStore("UserAccount").on("load",
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
		tab: "User\\.view\\.UserTab[name='User']"
		},
		
		control:
		{			
			"User\\.view\\.UserTab[name='User']":
			{
				tabchange: function(TabPanel, newCard, oldCard, eOpts)
				{
					var token = Ext.util.History.addToToken
					(
						[
							{
							index: "userTab",
							value: newCard.id
							}
						]
					);
				
				this.redirectTo(token);
				}
			}
		}
	}
);