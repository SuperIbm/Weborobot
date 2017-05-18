Ext.define('Seo.component.get.controller.Seo',
	{
	extend: 'Ext.app.Controller',
	
	id: "Seo.component.get",
	
	stores: ["ComponentTemplateSelect"],
	
		control:
		{
			"Seo\\.component\\.get\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Seo\\.component\\.get\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);