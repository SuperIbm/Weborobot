Ext.define('User.action.siteConfirm.controller.User', 
	{
	extend: 'Ext.app.Controller',
	
	id: "User.action.siteConfirm",
	
	stores: ["ComponentTemplateSelect"],
	
		control:
		{
			"User\\.action\\.siteConfirm\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"User\\.action\\.siteConfirm\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);