Ext.define('Robots.view.RobotsForm',
	{
    extend: 'Ext.form.Panel',
	alias: 'widget.Robots.view.RobotsForm',
	
	bodyPadding: 15,
	
	bodyBorder: false,
	border: false,
	frame: false,
	layout: 'fit',
	
		items:
		[
			{
			xtype: "codemirror",

			hideLabel: true,
			height: "100%",
			layout: 'fit',
			
			name: "text"
			}
		]
	}
);