Ext.define('User.action.siteRead.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteRead",
	
	stores: ["ComponentTemplateSelect"],
	
		control:
		{
			"User\\.action\\.siteRead\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteRead\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);