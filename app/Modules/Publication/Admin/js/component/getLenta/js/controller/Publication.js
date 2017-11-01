Ext.define('Publication.component.getLenta.controller.Publication',
	{
	extend: 'Ext.app.Controller',
	
	id: "Publication.component.getLenta",
	
	stores: ["ModuleTemplateSelect", "PublicationSectionSelect"],
	models: ["PublicationSectionSelect"],
	
		control:
		{
			"Publication\\.action\\.getLenta\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.action\\.getLenta\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);