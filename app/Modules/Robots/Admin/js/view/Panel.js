Ext.define('Robots.view.Panel',
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Robots.view.Panel',

		requires:
		[
		"Robots.view.RobotsForm"
		],
	
	title: "Robots",
	icon: Admin.getApplication().Section.get("Robots")["iconSmall"],
	layout: 'fit',
	frame: true,
	scrollable: false,
		
		items:
		[
			{
			xtype: "Robots.view.RobotsForm"
			}
		],
		fbar:
		[
			{
			xtype: "button",
			text: "Сохранить",
			action: "send"
			},
			{
			xtype: "button",
			text: "Очистить",
			action: "reset"
			}
		]
	}
);
