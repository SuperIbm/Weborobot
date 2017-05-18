Ext.define('User.action.siteLogin.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteLogin",
	
		control:
		{
			"User\\.action\\.siteLogin\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteLogin\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);