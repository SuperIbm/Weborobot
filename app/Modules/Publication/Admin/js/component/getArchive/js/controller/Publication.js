Ext.define('Publication.component.getArchive.controller.Publication',
	{
	extend: 'Ext.app.Controller',
	
	id: "Publication.component.getArchive",
	
		control:
		{
			"Publication\\.action\\.getArchive\\.view\\.Window button[action=reset]":
			{
				click: function(button)
				{
				button.up("window").down("form").reset();
				}
			},
			"Publication\\.action\\.getArchive\\.view\\.Window button[action=cancel]":
			{
				click: function(button)
				{
				button.up("window").close();
				}
			}
		}
	}
);