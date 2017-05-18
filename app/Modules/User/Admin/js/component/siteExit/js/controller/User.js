Ext.define('User.action.siteExit.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteExit",
	
		control:
		{
			"User\\.action\\.siteExit\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteExit\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);