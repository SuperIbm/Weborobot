Ext.define('Infoblock.component.get.controller.Infoblock',
	{
	extend: 'Ext.app.Controller',
	
	id: "Infoblock.component.get",
	
	models: ["InfoblockSelect"],
	stores: ["ModuleTemplateSelect", "InfoblockSelect"],
	
		control:
		{
			"Infoblock\\.component\\.get\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Infoblock\\.component\\.get\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);