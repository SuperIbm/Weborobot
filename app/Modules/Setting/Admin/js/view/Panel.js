Ext.define('Setting.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Setting.view.Panel',
	
	title: "Настройки сайта",
	icon: Admin.getApplication().Section.get("Setting")["iconSmall"],
	layout: 'fit',
	scrollable: false,
	frame: true,
		
		items:
		[
			{
			xtype: "Setting.view.SettingGridProperty"
			}
		]
	}
);