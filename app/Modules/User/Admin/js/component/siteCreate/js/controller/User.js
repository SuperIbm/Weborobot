Ext.define('User.action.siteCreate.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteCreate",
	
	stores: ["ComponentTemplateSelect"],
	
		control:
		{
			"User\\.action\\.siteCreate\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteCreate\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);