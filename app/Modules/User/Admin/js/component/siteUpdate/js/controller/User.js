Ext.define('User.action.siteUpdate.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteUpdate",
	
		control:
		{
			"User\\.action\\.siteUpdate\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteUpdate\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);