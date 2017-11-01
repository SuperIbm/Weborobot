Ext.define('Publication.component.getByAction.controller.Publication',
	{
	extend: 'Ext.app.Controller',
	
	id: "Publication.component.getByAction",
	
	stores: ["ModuleTemplateSelect", "PublicationSectionSelect"],
	models: ["PublicationSectionSelect"],
	
		control:
		{
			"Publication\\.action\\.getByAction\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.action\\.getByAction\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);