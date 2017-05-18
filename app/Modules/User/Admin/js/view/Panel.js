Ext.define('User.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.User.view.Panel',
	
	title: "Пользователи",
	icon: Admin.getApplication().Section.get("User")["iconSmall"],
	layout: 'border',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "User.view.UserTab"
			}
		]
	}
);