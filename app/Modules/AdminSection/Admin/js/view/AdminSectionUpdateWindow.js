Ext.define('AdminSection.view.AdminSectionUpdateWindow', 
	{
    extend: 'Ext.window.Window',
	alias: 'widget.AdminSection.view.AdminSectionUpdateWindow',
		
		requires:
		[
		"AdminSection.view.AdminSectionUpdateForm"
		],
	
	name: "AdminSection",
	title: "Изменить раздел",
	iconCls: "icon_update",
	layout: 'fit',
	scrollable: true,
	constrain: true,
	width: 495,
	height: 285,
	
	modal: true,
		
		items:
		[
			{
			xtype: "AdminSection.view.AdminSectionUpdateForm"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Изменить",
			action: "send"
			},
			{	
			xtype: "button",
			text: "Очистить",
			action: "reset"
			},
			{	
			xtype: "button",
			text: "Отменить",
			action: "cancel"
			}
		]
	}
);