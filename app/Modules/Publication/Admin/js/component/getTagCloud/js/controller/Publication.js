Ext.define('Publication.component.getTagCloud.controller.Publication',
	{
	extend: 'Ext.app.Controller',
	
	id: "Publication.component.getTagCloud",
	
	stores: ["ComponentTemplateSelect", "PublicationSectionSelect"],
	models: ["PublicationSectionSelect"],
	
		control:
		{
			"Publication\\.action\\.getTagCloud\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.action\\.getTagCloud\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);