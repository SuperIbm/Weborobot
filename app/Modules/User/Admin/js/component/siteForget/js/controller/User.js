Ext.define('User.action.siteForget.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteForget",
	
	stores: ["ComponentTemplateSelect"],
	
		control:
		{
			"User\\.action\\.siteForget\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteForget\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);