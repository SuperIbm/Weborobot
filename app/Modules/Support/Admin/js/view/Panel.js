Ext.define('Support.view.Panel', 
	{
    extend: 'Ext.panel.Panel',
	alias: 'widget.Support.view.Panel',
	
		requires:
		[
		"Support.view.SupportForm"
		],
	
	title: "Техническая поддержка",
	icon: Admin.getApplication().Section.get("Support")["iconSmall"],
	layout: 'fit',
	frame: true,
	scrollable: false,
		
		items:
		[
			{
			xtype: "Support.view.SupportForm"
			}
		],
		fbar:
		[
			{	
			xtype: "button",
			text: "Отправить",
			action: "send"
			},
			{	
			xtype: "button",
			text: "Очистить",
			action: "reset"
			}
		],
		initComponent: function()
		{
			this.tools = 
			[
				{
				type: "gear",
				itemId: "SupportUser",
				tooltip: "Управлять данными администратора",
				hidden: Admin.getApplication().Access.is("Support", "isUpdate") == true ? false : true
				}
			];
		
		this.callParent();	
		}
	}
);